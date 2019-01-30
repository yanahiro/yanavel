<?php

namespace App\Base\Services\CustomSession\UnitSession;

/**
 * 同空間上でセッション保持してを扱うクラス
 * 別空間→元の空間に遷移した場合
 * セッションが破棄されていることを保証する
 *
 * @author yanahiro
 * @since 2017.10.10
 */

class UnitSession
{
    /**
     * プレフィックス
     *
     * @var string
     */
    const PREFIX = 'us';

    /**
     * 空間保持用プレフィックス
     *
     * @var string
     */
    const UNIT = '__us';

    /**
     * データ
     *
     * @var array
     */
    protected $data = [];

    /**
     * 空間名
     *
     * @var string
     */
    protected $space;

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        // セッションを取得する
        $this->data = \Session::get(self::PREFIX);
    }

    /**
     * 初期化
     *
     * @return bool
     */
    public function init()
    {
        // 前回このセッションが有る
        if($this->has(self::UNIT)) {
            // 空間名をセット
            $this->space = $this->get(self::UNIT);
        }
        return true;
    }

    /**
     * 今の空間名をセットする
     * この時名前が前回と異なる場合は
     * セッションとデータを一度破棄しリセットする
     *
     * @param  string $space
     * @return bool
     */
    public function space($space)
    {
        if($this->space != $space) {
            $this->destory();
            $this->set(self::UNIT, $space);
            $this->space = $space;
        }
        return true;
    }

    /**
     * データのセット
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value=true)
    {
        \Session::put(self::PREFIX.'.'.$key, $value);
        $this->data[$key] = $value;
    }

    /**
     * データのゲット
     *
     * @param  string $key
     * @return array
     */
    public function get($key)
    {
        return $this->data[$key];
    }

    /**
     * データの有無
     *
     * @param  string $key
     * @return bool
     */
    public function has($key)
    {
        if(isset($this->data[$key])) {
            return true;
        }
        return false;
    }

    /**
     * データの破棄
     *
     * @return void
     */
    public function destory()
    {
        unset($this->data);
        $this->data = [];
        \Session::forget(self::PREFIX);
    }

    /**
     * データのゲット
     *
     * @return array
     */
    public function name()
    {
        return $this->get(self::UNIT);
    }
}
