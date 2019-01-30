<?php

namespace App\Models\User;

use App\Base\Eloquent\BaseEloquent;

/**
 * ユーザーEloquent
 * @package App\Models\AdminMenu
 * @author yanahiro
 * @version 1.0.0
 */
class UserEloquent extends BaseEloquent
{
    /**
     * テーブル名
     * @var string
     */
    protected $table = 'users';

    /**
     * NULL許可の項目
     *
     * @var array
     */
    protected $nullable = [];

    /**
     * パスワードをハッシュ化して保存
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if($value != "" && \Hash::needsRehash($value)) {
            $this->attributes['password'] = bcrypt($value);
        } else if($value != "" && !\Hash::needsRehash($value)) {
            $this->attributes['password'] = $value;
        }
    }

    public static function boot()
    {
        // オブザーバ登録
        static::observe(UserObserver::class);
    }

}