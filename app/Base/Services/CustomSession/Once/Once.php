<?php

namespace App\Base\Services\CustomSession\Once;

/**
 * Class Once
 * 1回きりのセッションを扱うクラス
 *
 * @package App\Base\Services\CustomSession\Once
 * @author yanahiro
 * @version 1.0.0
 */
class Once
{
    /**
     * prefix
     */
    const PREFIX = 'once';

    /** Data @var array */
    protected $data = [];

    /**
     * コンストラクタ
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * データの初期化
     * @return bool
     */
    public function init()
    {
        $this->data = \Session::pull(self::PREFIX);
        return true;
    }

    /**
     * データの初期化をせずに取得
     * @return bool
     */
    public function no()
    {
        $this->data = \Session::get(self::PREFIX);
        return true;
    }

    /**
     * データの設定
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value = true)
    {
        \Session::push(self::PREFIX.'.'.$key, $value);
        $this->data[$key] = $value;
    }

    /**
     * データの取得
     * @param  string $key
     * @return array
     */
    public function get($key)
    {
        if ($this->has($key)) {
            if (is_array($this->data[$key]) && isset($this->data[$key][0])) {
                return $this->data[$key][0];
            } else {
                return $this->data[$key];
            }
        }
        return null;
    }


    /**
     * データのゲット+削除
     * @param  string $key
     * @return array
     */
    public function pull($key)
    {
        $value = $this->get($key);
        $this->destory();
        return $value;
    }

    /**
     * データの有無
     * @param  string $key
     * @return bool
     */
    public function has($key)
    {
        if (isset($this->data[$key])) {
            return true;
        }
        return false;
    }

    /**
     * データのクリア
     * @param  string $key
     * @return void
     */
    public function clear($key)
    {
        \Session::forget(self::PREFIX.'.'.$key);
    }

    /**
     * データの破棄
     * @return void
     */
    public function destory()
    {
        unset($this->data);
        $this->data = [];
        \Session::forget(self::PREFIX);
    }

}
