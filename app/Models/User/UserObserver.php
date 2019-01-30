<?php

namespace App\Models\User;

/**
 * Class UserObserver
 * Userモデルオブザーバークラス
 *
 * @package App\Models\User
 * @author yanahiro
 * @version 1.0.0
 */
class UserObserver
{
    /**
     * 保存時処理
     * @param $model
     * @return mixed
     */
    public function saving($model)
    {
        $model->name = $model->last_name . '　' . $model->first_name;
        return $model;
    }
}