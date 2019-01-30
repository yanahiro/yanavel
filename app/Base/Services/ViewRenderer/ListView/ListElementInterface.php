<?php

namespace App\Base\Services\ViewRenderer\ListView;

/**
 * Interface ListElementInterface
 * @package App\Services\ViewRenderer\ListView
 * @author yanahiro
 * @version 1.0.0
 */
interface ListElementInterface
{

    public function setRepository($repo);

    /**
     * Eloquentのセット
     *
     * @param    $eloquent
     * @return this
     */
    public function setEloquent($eloquent);

    /**
     * ベースのカラム作成
     *
     * @return array
     */
    public function makeBaseColomns();

    /**
     * ベースの操作作成
     *
     * @return array
     */
    public function makeBaseOperations();
}
