<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

/**
 * 初期CSVデータを取り込むコマンド
 * databse/imports/**.csvを取り込む
 * csvを取り込むためにImportFormatを
 * 正しく設定する必要がある
 *
 * @author yanahiro
 * @since 2018.12.01
 *
 */
class ImportCsv extends Command
{

    /**
     * liteオプションが合った場合に取り込むMAXファイルサイズ
     *
     * @var string
     */
    const IMPORT_MAXSIZE = 2000;

    /**
     * コンソールコマンドの名前と引数、オプション
     *
     * @var string
     */
    protected $signature = 'db:csv
                            {user? : The ID of the user}
                            {--file=}
                            {--namespace=}
                            {--database= : Change default connection}
                            {--lite}
                            {--develop : Import csv For test}';

    /**
     * コンソールコマンドの説明
     *
     * @var string
     */
    protected $description = 'Import csv';

    /**
     * モデルのネームスペース
     *
     * @var string
     */
    protected $model_namespace = '\\App\\Models\\';

    /**
     * インポートのパス
     *
     * @var string
     */
    protected $import_path;

    /**
     * プレフィックス
     *
     * @var string
     */
    protected $prefix;

    /**
     * 新しいコマンドインスタンスを生成
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * コンソールコマンドの実行
     * database/importsにあるcsvを取り込む
     * csvはファイル名をモデル名にすること
     *
     * @return mixed
     */
    public function handle()
    {
        // コネクション変更
        $database = $this->option('database');
        if (!is_null($database)) {
            \DB::connection($database);
        }

        $path = "imports";
        //読み取りフォルダ変更
        $folder = $this->option('develop');
        if ($folder) {
            $path = "test_csv";
        }
        $this->import_path = base_path(). DIRECTORY_SEPARATOR . 'database'. DIRECTORY_SEPARATOR .$path;

        $namespace = $this->option('namespace');
        if ($namespace) {
            $this->model_namespace .= $namespace.'\\';
        }

        $files = $this->option('file');
        if (is_null($files)) {
            $files = scandir($this->import_path);
        } else {
            $files = [$files.'.csv'];
        }

        $imports = [];

        foreach ($files as $file) {
            if (!is_dir($file)) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if ($ext == 'csv') {
                    $lite = $this->option('lite');
                    if (!$lite || filesize($this->import_path . DIRECTORY_SEPARATOR . $file) < self::IMPORT_MAXSIZE) {
                        $imports[] = $file;
                    }
                }
            }
        }

        $userId = $this->argument('user');

        Model::unguard();
        // csvがある場合
        if (count($imports) > 0) {
            $this->import($imports);
        } else {
            // csvがない場合
            $this->error('Nothing csv file!');
        }
        Model::reguard();
    }

    /**
     * csvファイルを取込
     *
     * @param  array $file
     * @return void
     */
    private function import($files)
    {
        foreach($files as $file) {
            $file_path = $this->import_path . DIRECTORY_SEPARATOR .$file;

            $name = pathinfo($file, PATHINFO_FILENAME);
            $name = ucfirst($name);
            $isImport = false;
            if (class_exists($this->model_namespace . $name . '\\' .$name . 'Repository')) {
                // Model直下のRepositoryとして生成
                echo 'class name : '.$this->model_namespace . $name . '\\' .$name . 'Repository';
                $repo = $this->model_namespace . $name . '\\' .$name . 'Repository';
                $repo = new $repo;
            } else {
                if (class_exists($this->model_namespace . 'Master\\' . $name . '\\' .$name . 'Repository')) {
                    // Model直下のRepositoryとして生成出来ない場合はMaster
                    echo 'class name : '.$this->model_namespace . 'Master\\' . $name . '\\' .$name . 'Repository';
                    $repo = $this->model_namespace . 'Master\\' . $name . '\\' .$name . 'Repository';
                    $repo = new $repo;
                } else {
                    // 作成出来ない場合は次へ
                    continue;
                }
            }

            // インポート処理を呼び出す
            $isImport = \SuImport::fileUploadFirstDataByCsv(
                $repo,
                $file_path
            );

            $this->info('import '.$file);
        }
    }

}