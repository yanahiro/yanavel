<?php

namespace App\Base\Services\Globality;

/**
 * Class Globality
 * グローバルに扱える変数を保持するクラス
 * Session上不要やView側へ連携する際に使用
 *
 * @package App\Base\Services\Globality
 * @author yanahiro
 * @version 1.0.0
 */
class Globality
{
    /**
     * データ
     * @var array
     */
    protected $data = [];

    /**
     * エラーコード
     * @var array
     */
    protected $errorCodes = [];

    /**
     * エラーフラグ
     * @var bool
     */
    protected $error = false;

    /**
     * DBエラーフラグ
     */
    protected $db_error = false;

    /**
     * データの設定
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value)
    {
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
            return $this->data[$key];
        }
        return null;
    }

    /**
     * データの存在チェック
     * @param  string $key
     * @return array
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * エラーのセット
     * エラーコードもセットできる
     *
     * @return string $code
     * @return void
     */
    public function error($code = null)
    {
        if (!is_null($code)) {
            $this->errorCodes[] = $code;
        }
        $this->error = true;
    }

    /**
     * DBエラーのセット
     * DBエラーのフラグを立てる
     * ※trueに設定するとStop.php(middleware)で
     * DBのロールバックが可能
     */
    public function dbError()
    {
        $this->db_error = true;
    }

    /**
     * エラーのチェック
     * @return bool
     */
    public function hasError()
    {
        return $this->error;
    }

    /**
     * DBエラーのチェック
     * @return bool
     */
    public function hasDBError()
    {
        return $this->db_error;
    }

    /**
     * エラーコードの取得
     *
     * @return string
     */
    public function getErrors()
    {
        return $this->errorCodes;
    }
}
