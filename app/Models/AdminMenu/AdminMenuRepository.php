<?php

namespace App\Models\AdminMenu;

use App\Base\Repository\BaseRepository;

/**
 * 管理メニューリポジトリ
 *
 * @package App\Models\AdminMenu
 * @author yanahiro
 * @version 1.0.0
 */
class AdminMenuRepository extends BaseRepository
{
    /**
     * @param string $app_base_url
     * @return array
     */
    public function getMenu($app_base_url = '')
    {
        // 管理者のメニュー取得
        $menus = $this->eloquent::active()
            ->orderBy('level', 'DESC')
            ->orderBy('display_order')
            ->get();

        $bufs = [];
        $level = 1;
        $app = null;

        // 配列(Eloquent)を展開
        foreach($menus as $menu) {
            if ($level < $menu->level) {
                $level = $menu->level;
            }

            $bufs[$menu->level][$menu->id]['self'] = $menu;
            if ($menu->url == $app_base_url) {
                $app = $menu;
            }
        }

        // 使いやすいデータに整形
        while ($level > 1) {
            $make = [];
            foreach ($bufs[$level-1] as $menu_id => $val) {
                foreach ($bufs[$level] as $menu_id2 => $val2) {
                    if ($val2['self']->parent_menu_id == $menu_id) {
                        $make[$menu_id]['child'][$menu_id2] = $val2;
                    }
                }
                $make[$menu_id]['self'] = $val['self'];
            }
            $bufs[$level-1] = $make;
            $level--;
        }

        $parent_id = null;
        $apps = [];
        if (isset($bufs[1])) {
            foreach ($bufs[1] as $menu_id => $val) {
                $ret = $this->makeAdminParent($val, $menu_id, $app_base_url);
                if (!is_null($ret)) {
                    $parent_id = $ret;
                }
                //$apps[$val['self']['type']][$menu_id] = $val;
                $apps[$menu_id] = $val;
            }
        }

        return [$app, $apps, $parent_id];
    }

    /**
     * 親の取得
     * 参照値渡しで
     * 親のパスをリターンするようにも
     *
     * @param array $val
     * @param string $parent_menu_id
     * @param string $app_base_url
     * @return string
     */
    private function makeAdminParent(&$val, $parent_menu_id, $app_base_url)
    {
        $ret = null;
        if(isset($val['child']))
        {
            foreach($val['child'] as $menu_id2 => &$val2)
            {
                // 親IDをセット（'.'区切り、自分も含む）
                $val2['parent_id'] = $parent_menu_id.'.'.$menu_id2;
                if($val2['self']->url == $app_base_url)
                {
                    $ret = $val2['parent_id'];
                }

                $ret2 = $this->makeAdminParent($val2, $val2['parent_id'], $app_base_url);
                if(!is_null($ret2))
                {
                    $ret = $ret2;
                }
            }
        }
        return $ret;
    }
}
