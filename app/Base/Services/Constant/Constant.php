<?php

namespace App\Base\Services\Constant;

/**
 * 定数を集めたクラス
 * 所定のディレクトリにconfigのような
 * 配列をリターンするものを用意し読む
 * サービスプロバイダでシングルトンとして登録
 *
 * @package App\Base\Services\Constant
 * @author yanahiro
 * @version 1.0.0
 */
class Constant
{
    const CONST_DIR = 'constant';

    public $constant;

    public function get($key)
    {
        $spl = explode('.', $key);
        if (empty($this->constant[$spl[0]])) {
            $this->constant[$spl[0]] = include_once(base_path(self::CONST_DIR.'/'.$spl[0].'.php'));
        }
        $res = $this->constant;
        foreach ($spl as $s) {
            if (isset($res[$s])) {
                $res = $res[$s];
            } else {
                return null;
            }
        }
        return $res;
    }
}
