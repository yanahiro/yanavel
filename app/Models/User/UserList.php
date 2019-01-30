<?php namespace App\Models\User;

use App\Base\Services\ViewRenderer\ListView\ListElement;

/**
 * Class userList
 * ユーザー管理リスト
 *
 * @package App\Models\Master\AdminUser
 * @author yanahiro
 * @version 1.0.0
 */
class UserList extends ListElement
{
    /**
     * ベースカラムの作成
     *
     * @return array
     */
    public function makeBaseColomns()
    {
        return [
            'id' => [
                'name' => 'ID',
                'width' => 50,
            ],
            'email' => [
                'name' => 'メールアドレス',
            ],
            'name' => [
                'name' => '氏名(姓)',
            ],
        ];
    }

    /**
     * ベース操作の作成
     *
     * @return array
     */
    public function makeBaseOperations()
    {
        return $this->baseOperations(['create', 'update', 'delete']);
    }
}
