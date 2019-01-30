<?php

namespace App\Base\Repository;

use App\Base\Repository\Traits\CreateTrait;
use App\Base\Repository\Traits\UpdateTrait;
use App\Base\Repository\Traits\DeleteTrait;
use App\Base\Repository\Traits\ForceDeleteTrait;
use App\Base\Repository\Traits\ExclusionTrait;

/**
 * ベースリポジトリクラス
 * リポジトリを作成する場合には必ず継承するクラス
 *
 * @package App\Base\Repository
 * @author yanahiro
 * @version 1.0.0
s */
abstract class BaseRepository
{

    // 機能注入
    // 登録処理
    use CreateTrait;
    // 更新処理
    use UpdateTrait;
    // （論理）削除処理
    use DeleteTrait;
    // （物理）削除処理
    use ForceDeleteTrait;
    // 排他チェック処理
    use ExclusionTrait;

    /**
     * Eloquent
     *
     * @var EloquentInterface
     */
    public $eloquent;

    /**
     * プレフィックス
     *
     * @var string
     */
    public $prefix;

    /**
     * Eloquent
     * キーで絞り込んだレコード
     *
     * @var Eloquent
     */
    protected $record;
    
    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        if (is_null($this->prefix)) {
            $this->setInitPrefix();
        }
        $this->setEloquent();
    }

//    /**
//     * 登録系処理
//     */
//
//    /**
//     * Data Insert
//     * @param $data
//     * @param array $add
//     * @return mixed
//     */
//    public function create($data, $add = [])
//    {
//        return $this->eloquent->create($this->eloquent->makePost($data, $add));
//    }
//
//    /**
//     * Data Update
//     * @param $data
//     * @param null $id
//     * @param array $add
//     * @return Eloquent|bool
//     */
//    public function update($data, $id = null, $add = [])
//    {
//        $obj = $this->getRecord($id);
//        if (!is_null($obj)) {
//            $obj->update($this->eloquent->makePost($data, add));
//            return $obj;
//        }
//        return false;
//    }
//
//    /**
//     * Data Delete
//     * @param null $id
//     * @return EloquentInterface
//     */
//    public function delete($id = null)
//    {
//        $obj = $this->getObj($id);
//        // 論理削除
//        $obj->delete();
//
//        return $obj;
//    }

    /**
     * Eloquent 操作系
     */

    /**
     * Eloquentクラスの生成
     *
     * @return void
     */
    public function setEloquent()
    {
        if (is_null($this->eloquent)) {
            $eloquent = $this->prefix . 'Eloquent';
            $this->eloquent = new $eloquent();
        }
    }

    /**
     * Eloquentクラスの取得
     *
     * @return EloquentInterface
     */
    public function getEloquent()
    {
        return $this->eloquent;
    }

    /**
     * レコードの取得
     *
     * @param  int  $id
     * @return Eloquent
     */
	public function getRecord($id = null)
	{
        if (is_null($this->record)) {
		    $this->record = $this->eloquent->find($id);
        }
		return $this->record;
	}

    /**
     * オブジェクトのデータ初期化
     *
     * @return EloquentInterface
     */
    public function setRecordNull()
    {
        $this->record = null;
    }

    /**
     * プレフィックスをクラス名から設定する
     *
     * @return void
     */
    private function setInitPrefix()
    {
        $this->prefix = '\\' . str_replace('Repository', '', get_class($this));
    }

    /**
     *　楽観的排他用更新日付
     *
     * @return string
     */
    public function getLockedAtColumn()
    {
        return null;
    }
}
