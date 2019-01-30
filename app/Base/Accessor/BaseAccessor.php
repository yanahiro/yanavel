<?php

namespace App\Base\Accessor;

/**
 * Accessor 基底クラス
 * 受け取った配列で定義したkeyの値を保持するクラス
 * 関数($hoge->aaa)と同様の記載で値のget・setが可能
 *
 * 定義していない不要な定数は設定させない為の制御クラス
 *
 * @package App\Base\Accessor
 * @author yanahiro
 * @version 1.0.0
 */
class BaseAccessor
{
    protected $var = [];
    
    /**
     * 
     * @param type $array
     */
    public function __construct($array)
    {
        $this->var = $array;
    }

    /**
     * getter(マジックメソッド)
     * 存在するキーの場合にプロパティの値を取得する
     * @param type $name
     * @return type
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->var)) {
            return $this->var[$name];
        }
        return null;
    }

    /**
     * setter(マジックメソッド)
     * 存在するキーの場合にプロパティの値を設定する
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->var)) {
            $this->var[$name] = $value;
        }
    }
    
    /**
     * 配列を返却する
     * @return array
     */
    public function toArray()
    {
        return $this->var;
    }
    
}
