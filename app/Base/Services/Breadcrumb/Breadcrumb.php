<?php

namespace App\Base\Services\Breadcrumb;

/**
 * パンくずクラス
 * @package App\Services\DataUtil\Breadcrumb
 * @author yanahiro
 * @version 1.0.0
 */
class Breadcrumb
{
    /**
     * データ
     *
     * @var array
     */
    protected $breadcrumb = [];

    /**
     * 現在の位置
     *
     * @var string
     */
    protected $now;

    /**
     * パンくず要素のセット
     *
     * @param  string $key
     * @param  string $name
     * @param  srting $a
     * @param  srting $icon
     * @return this
     */
    public function push($key, $name, $a = '', $icon = '')
    {
        $this->breadcrumb[$key]['name'] = $name;
        if ($a != '') {
            $this->breadcrumb[$key]['a'] = $a;
        }
        if ($icon != '') {
            $this->breadcrumb[$key]['icon'] = $icon;
        }
        return $this;
    }

    /**
     * パンくず要素の削除
     *
     * @param  string $key
     * @return this
     */
    public function pop($key)
    {
        unset($this->breadcrumb[$key]);
        return $this;
    }

    /**
     * 現在の位置セット
     *
     * @param  string $key
     * @return array
     */
    public function now($key)
    {
        $this->now = $key;
    }

    /**
     * 最後を取得
     *
     * @return array
     */
    public function last()
    {
        $keys = array_keys($this->breadcrumb);
        $key = $keys[count($keys) - 1];
        return $this->breadcrumb[$key];
    }

    /**
     * 1個前を取得
     *
     * @return array
     */
    public function before()
    {
        $keys = array_keys($this->breadcrumb);
        $key = $keys[count($keys) - 2];
        return $this->breadcrumb[$key];
    }

    /**
     * パンくず出力用に配列を整形
     *
     * @param  string $key
     * @return array
     */
    public function render()
    {
        foreach ($this->breadcrumb as $key => &$bc) {
            if (isset($bc['icon'])) {
                $bc['name'] = '<i class="fa fa-'.$bc['icon'].'"></i>';
            }
            if ($this->now == $key) {
                $bc['now'] = true;
            } else {
                $bc['now'] = false;
            }
            // 最後のパンくずはリンクを取る
            if ($bc === end($this->breadcrumb)) {
                unset($this->breadcrumb[$key]['a']);
            }
        }
        return $this->breadcrumb;
    }
}
