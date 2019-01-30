<?php

use Illuminate\Database\Seeder;
use App\Models\AdminMenu\AdminMenuEloquent;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_admin_menu')->delete();

        Eloquent::unguard();

        $menus = [
            [
                'parent_menu_id' => null,
                'level' => '1',
                'menu_name' => '管理者管理',
                'url' => '/user',
                'icon' => 'user',
                'active' => '0',
                'overview' => '',
                'service' => '3',
                'display_order' => '010100',
                'is_show_menu' => '1',
                'is_head_office' => '1'
            ],
            [
                'parent_menu_id' => null,
                'level' => '1',
                'menu_name' => '案件管理',
                'url' => '/project',
                'icon' => 'check-circle',
                'active' => '0',
                'overview' => '',
                'service' => '3',
                'display_order' => '010200',
                'is_show_menu' => '1',
                'is_head_office' => '1'
            ],
            [
                'parent_menu_id' => null,
                'level' => '1',
                'menu_name' => '取引先管理',
                'url' => '/client',
                'icon' => 'address-book',
                'active' => '0',
                'overview' => '',
                'service' => '3',
                'display_order' => '010300',
                'is_show_menu' => '1',
                'is_head_office' => '1'
            ],
            [
                'parent_menu_id' => null,
                'level' => '1',
                'menu_name' => '○○管理',
                'url' => '/client',
                'icon' => 'address-book',
                'active' => '0',
                'overview' => '',
                'service' => '3',
                'display_order' => '010400',
                'is_show_menu' => '1',
                'is_head_office' => '1'
            ],
            [
                'parent_menu_id' => null,
                'level' => '1',
                'menu_name' => '◆◆管理',
                'url' => '/client',
                'icon' => 'address-book',
                'active' => '0',
                'overview' => '',
                'service' => '3',
                'display_order' => '010500',
                'is_show_menu' => '1',
                'is_head_office' => '1'
            ],
            [
                'parent_menu_id' => null,
                'level' => '1',
                'menu_name' => '××管理',
                'url' => '/client',
                'icon' => 'address-book',
                'active' => '0',
                'overview' => '',
                'service' => '3',
                'display_order' => '010600',
                'is_show_menu' => '1',
                'is_head_office' => '1'
            ],
        ];

        // 管理者情報
        foreach ($menus as $key => $menu) {
            AdminMenuEloquent::create($menu);
        };

        Eloquent::reguard();
    }
}
