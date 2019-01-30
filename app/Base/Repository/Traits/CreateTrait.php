<?php

namespace App\Base\Repository\Traits;

/**
 * 登録処理 Traitクラス
 * 登録する際の関数を定義する
 *
 * @package App\Base\Repository\Traits
 * @author yanahiro
 * @version 1.0.0
 */
trait CreateTrait
{
    /**
     * データ登録処理
     *
     * @param $data
     * @param array $add
     * @return mixed
     */
    public function create($data, $add = [])
    {
        return $this->eloquent->create($this->eloquent->makePost($data, $add));
    }
}