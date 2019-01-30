<?php

namespace App\Http\Request\Admin;

use App\Base\Request\BaseFormRequest;

class UserFormRequest extends BaseFormRequest
{

    /**
     * リクエスト定義
     */
    protected function requestRules()
    {
        return [
            'id' => '',
            'email' => 'required|email',
            'password' => 'required',
            'password_conf' => 'required_with:password|same:password',
            'last_name' => '',
            'first_name' => '',
            'last_name_kana' => '',
            'first_name_kana' => '',
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'ID',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_conf' => 'パスワード（確認）',
            'last_name' => '姓',
            'first_name' => '名',
            'last_name_kana' => '姓（カナ）',
            'first_name_kana' => '名（カナ）',
        ];

    }

    protected function updateChangeRules($rules)
    {
        // パスワードのチェックはしない
        $rules['password'] = '';
        return $rules;
    }


}