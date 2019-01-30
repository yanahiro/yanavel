<?php

namespace App\Base\Services\ViewRenderer\Traits;

/**
 * Base Parser
 * 解析処理
 *
 * @package App\Services\ViewRenderer\Traits
 * @author yanahiro
 * @version 1.0.0
 */
Trait Parser
{
    /**
     * 定義した配列を元にデータをパースする
     *
     * @param  array  $columns
     * @param  array  $data
     * @param  array  $init
     * @return array
     */
    public function parseData($columns, $data, $init=[])
    {
        $values = $init;
        foreach ($columns as $k => $v) {
            if (isset($v['parent'])) {
                $values[$k] = $this->parseParent($v['parent'], $k, $data);
            } else {
                $values[$k] = $data[$k];
            }
        }
        return $values;
    }

    /**
     * リレーションを張ったデータにアクセス
     *
     * @param  string  $parent
     * @param  string  $key
     * @param  array   $data
     * @return string
     */
    protected function parseParent($parent, $key, $data)
    {
        $parents = explode('.', $parent);
        $res = $data;
        foreach ($parents as $p) {
            $res = @$res[$p];
        }
        // 取れなかった場合はnull
        if (is_null($res)) {
            return null;
        }
        if (count($res) > 0) {
            // キーかぶりを防ぐため頭にシャープをつけてる場合置換
            $key = str_replace('#', '', $key);
            // issetだとセットされないのでこの書き方
            $return = @$res[$key];
            if (is_null($return)) {
                // 1対多などの場合
                if ($res instanceof \Illuminate\Database\Eloquent\Collection) {
                    $return = '';
                    foreach ($res as $r) {
                        $return .= @$r[$key];
                        $return .= ', ';
                    }
                    $return = mb_substr($return, 0, mb_strlen($return) - 2);
                }
            }
            return $return;
        }
        return null;
    }
}
