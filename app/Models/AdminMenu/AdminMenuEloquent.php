<?php

namespace App\Models\AdminMenu;

use App\Base\Eloquent\BaseEloquent;

/**
 * 管理メニューEloquent
 * @package App\Models\AdminMenu
 * @author yanahiro
 * @version 1.0.0
 */
class AdminMenuEloquent extends BaseEloquent
{
    /**
     * テーブル名
     * @var string
     */
    protected $table = 'mst_admin_menu';

    /**
     * NULL許可の項目
     *
     * @var array
     */
    protected $nullable = [];

    /**
     * アクティブメニュー取得のスコープ
     * 有効なメニューを全件取得する
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed AdminMenuEloquent
     */
    public function scopeActive($query)
    {
        return $query->where('is_show_menu', '=', 1)
            ->whereNull('deleted_at');
    }
}