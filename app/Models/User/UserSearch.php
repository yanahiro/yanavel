<?php namespace App\Models\User;

use App\Base\Services\ViewRenderer\SearchView\SearchElement;

/**
 * Class userSearch
 * ユーザー管理 検索項目クラス
 *
 * @package App\Models\User
 * @author yanahiro
 * @version 1.0.0
 */
class UserSearch extends SearchElement
{
    /**
     * 初期並び順
     *   カラム名を指定
     *   ※降順の場合カラム名にマイナスをつける ex:「'-id'」
     *
     * @var string
     */
    protected $order_init = 'id';

    /**
     * 並び順
     *
     * @var array
     */
    protected $order_permit = ['id', 'email', 'name'];

    /**
     * ベースフィールドの作成
     *
     * @return void
     */
    public function fields()
    {
        \Widget::text('id')
            ->name('ID')
            ->maxlength(30);

        \Widget::text('email')
            ->name('メールアドレス')
            ->like(['before', 'after'])
            ->maxlength(256);

        \Widget::text('name')
            ->name('氏名')
            ->like(['before', 'after'])
            ->maxlength(128);

    }
}
