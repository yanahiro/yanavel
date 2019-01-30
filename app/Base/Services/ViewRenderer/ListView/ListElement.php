<?php

namespace App\Base\Services\ViewRenderer\ListView;

/**
 * Class ListElement
 * 一覧表示 項目定義 基底クラス
 *
 * @package App\Services\ViewRenderer\ListView
 * @author yanahiro
 * @version 1.0.0
 */
abstract class ListElement implements ListElementInterface
{
    // Eloquent
    public $eloquent;

    // Eager用
    public $with = [];

    // 表示件数
    public $count = 25;

    // 表示件数選択
    public $display = [10, 25, 50, 75, 100];

    // 論理削除制御
    public $is_trash = false;

    /**
     * コンストラクタ
     *
     * @return  void
     */
    public function __construct()
    {
        // string型でeloquentがセットされている場合はインスタンスをつくる
        if (is_string($this->eloquent)) {
            $this->eloquent = new $this->eloquent;
        }
    }

    /**
     * Repositoryのセット
     *
     * @param  $repo
     * @return this
     */
    public function setRepository($repo)
    {
        $this->repo = $repo;
        if (is_null($this->eloquent)) {
            $this->eloquent = $this->repo->getEloquent();
        }
        return $this;
    }

    /**
     * Eloquentのセット
     *
     * @param  $eloquent
     * @return this
     */
    public function setEloquent($eloquent)
    {
        $this->eloquent = $eloquent;
        return $this;
    }

    /**
     * ベースのカラム作成
     *
     * @return array
     */
    public function makeBaseColomns()
    {
        return [];
    }

    /**
     * ベースの操作作成
     *
     * @return array
     */
    public function makeBaseOperations()
    {
        return $this->baseOperations(['create', 'update', 'delete']);
    }

    /**
     * ベースの操作
     *
     * @param  array $choices
     * @return array
     */
    protected function baseOperations($choices = [])
    {
        $base_operation = [
            'create' => [
                'name' => '新規登録',
                'type' => 'upper',
            ],
            'update' => [
                'name' => '更新',
                'width' => 50,
                'type' => 'list',
            ],
            'delete' => [
                'name' => '削除',
                'width' => 50,
                'type' => 'list',
            ],
            'detail' => [
                'name' => '詳細',
                'width' => 50,
                'type' => 'list',
            ],
        ];

        $res = [];
        foreach ($choices as $choice) {
            $res[$choice] = $base_operation[$choice];
        }

        return $res;
    }
}
