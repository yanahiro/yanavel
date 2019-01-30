<?php

namespace App\Models\User;

use App\Base\Services\ViewRenderer\FormView\FormElement;

/**
 * ユーザー管理フォーム
 *
 * @package App\Models\User
 * @author yanahiro
 * @version 1.0.0
 */
class UserForm extends FormElement
{
    /**
     * ベースフィールドの作成
     *
     * @return void
     */
    public function fields()
    {
        \Widget::head('user', 'ユーザー情報');

        \Widget::phidden('id')
            ->name('ID');

        \Widget::text('email')
            ->name('メールアドレス')
            ->before('envelope')
            ->maxlength(256)
            ->required();

        \Widget::password('password')
            ->name('パスワード')
            ->before('key')
            ->maxlength(256)
            ->required()
            ->helptext('（8文字以上16文字以内の半角英・数・記号）')
            ->subhelptext('※英･数･記のいずれか2種類の組み合わせでご入力ください。');

        \Widget::password('password_conf')
            ->name('パスワード(確認)')
            ->before('key')
            ->maxlength(256)
            ->required();

        \Widget::text('last_name')
            ->name('氏名(姓)')
            ->maxlength(128);

        \Widget::text('first_name')
            ->name('氏名(名)')
            ->maxlength(128);

        \Widget::text('last_name_kana')
            ->name('氏名カナ(姓)')
            ->maxlength(128);

        \Widget::text('first_name_kana')
            ->name('氏名カナ(名)')
            ->maxlength(128);
    }

    /**
     * create時フィールドの作成
     *
     */
    public function createFields()
    {
        \Widget::del('id');
    }

    /**
     * create確認時フィールドの作成
     *
     */
    public function createConfFields()
    {
        \Widget::del('id');
        \Widget::del('password_conf');
    }

    /**
     * update時フィールドの作成
     *
     */
    public function updateFields()
    {
        \Widget::change('password', 'required', false);
        \Widget::change('password_conf', 'required', false);
    }

    /**
     * update_conf時フィールドの作成
     *
     * @return void
     */
    public function updateConfFields()
    {
        \Widget::chameleon('password');
        \Widget::change('password', 'required', false);
        \Widget::del('password_conf');
    }

    /**
     * delete時フィールドの作成
     *
     */
    public function deleteConfFields()
    {
        \Widget::del('password');
        \Widget::del('password_conf');
    }
}
