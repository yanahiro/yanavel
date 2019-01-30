<?php namespace App\Services\CsvImport;

/**
 *
 * CSVインポート 関連処理クラス
 * データインポート処理
 *
 * @author yanahiro
 * @version 2018.12.01
 */
class DataImport
{

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * ファイルインポート処理(初期データ登録用)
     * @param  [object] $repository テーブルに紐づくリポジトリクラス
     * @param  [string] $file_path  ファイルパス
     * @return [boolean] true:成功 false:失敗
     */
    public function fileUploadFirstDataByCsv($repository, $file_path)
    {
        $isSuccess = false;
        $isSuccess = \DB::transaction(function () use ($repository, $file_path) {
            // インポート処理を呼び出す()
            $isImport = $this->uploadCsvData($repository, $file_path);
            return $isImport;
        });

        return $isSuccess;
    }

    /**
     * CSVデータ登録処理
     * @param  [object] $repository テーブルに紐づくリポジトリクラス
     * @param  [string] $file_path  ファイルパス
     * @return [boolean] true:成功 false:失敗
     */
    protected function uploadCsvData($repository, $file_path)
    {
        // Excelで編集した場合SJISになるので文字コード変換
        $buffer = mb_convert_encoding(file_get_contents($file_path), 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-win,cp932');
        $handle = tmpfile();
        fwrite($handle, $buffer);
        rewind($handle);

        // CSVファイルの読み込みが完了するまで処理を実行する
        $isFirstFlg = true;
        // ファイルの読み込みが完了するまで
        while (!feof($handle)) {
            // fgetcsvは正常にカンマが判定できないため、利用しない
            // カンマが判定できない文字例：「選択」
            // $csv = fgetcsv($handle, ',');
            $record = fgets($handle);
            $record = trim($record);
            $csv = explode(',', $record);

            // UTF-8 BOM付きなら削除
            if (preg_match('/^\xEF\xBB\xBF/', $csv[0])) {
                $csv[0] = substr($csv[0], 3);
            }

            // 対象行が空の場合は飛ばす
            if (empty($csv) || $csv[0] === NULL) {
                // //空行数を加算
                // ++$this->uploadDBObj['blank'];
                continue;
            }

            // 先頭行の場合はヘッダチェックを実施する
            if ($isFirstFlg) {
                $importFormat = $csv;
                $isFirstFlg = false;
                continue;
            }

            // CSV情報をキー付きで格納
            $workValArray = array_combine($importFormat, $csv);

            // Modelが持っているキー項目をベースに検索条件を作成する
            $model = $repository->getEloquent();
            $searchCond = $this->getSearchCondition($model, $workValArray);

            $entryId = [];
            if (empty($searchCond['searchCond'])) {
                if (!is_null($model->find($workValArray['id']))) {
                    $entryId = $model->where('id', '=', $workValArray['id'])->pluck($model->getKeyName());
                    // $entryId = $model->find($workValArray['id'])->pluck($model->getKeyName());
                }
            } else {
                $entryId = $model->whereRaw($searchCond['searchCond'], $searchCond['searchVal'])->pluck($model->getKeyName());
            }

            // バリデーションチェック なし


            $isNew = true;
            $id = '';
            if (!(count($entryId) == 0)) {
                // 1件以上存在する場合は更新モード
                $id = $entryId[0];
                $isNew = false;
            }

            // 新規／更新を判断
            if (count($entryId) == 0) {
                // 新規作成処理
                //$workValArray = $this->deleteId($workValArray);
                $repository->create($workValArray);
            } else {
                //更新処理($entryIdについては1件しか取れない前提)
                foreach($model->getPropKeyItems() as $key)
                {
                    unset($workValArray[$key]);
                }

                // オブジェクト初期化（IDで毎回更新対象のオブジェクト取得）
                $repository->setObjNull();
                $repository->update($workValArray, $entryId[0]);
            }
        }

    }

    /**
     * 検索条件作成処理
     * 受け取ったパラメータを基に検索条件文を作成する
     * @param type $model ModelFactory
     * @param type $valArray インポートデータの配列
     * @return type
     */
    private function getSearchCondition($model, $valArray)
    {

        $searchCond = '';
        $searchVal = array();
        $isFirst = true;
        $keyItems = $model->getPropKeyItems();
        //Modelに定義しているKeyItemを利用して検索条件を作成する
        foreach ($keyItems as $keyItem) {

            //先頭行の場合はandを連結しない
            if (!$isFirst) {
                $searchCond .= ' and ';
            }
            $searchCond .= '`'.$keyItem.'`' . ' = ? ';
            $searchVal[] = $valArray[$keyItem];
            $isFirst = false;
        }

        //PreparedStatementを利用する為、検索条件と値を返却する
        $searchCondition = array(
            'searchCond' => $searchCond,
            'searchVal' => $searchVal
        );

        return $searchCondition;
    }

}