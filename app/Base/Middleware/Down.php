<?php

namespace App\Base\Middleware;

/**
 * 後処理
 * 基本思想として必ずリクエスト毎に呼び出される処理
 * 後処理で共通的に処理を行いたい場合に処理を記載
 *
 * @package App\Base\Middleware
 * @author yanahiro
 * @version 1.0.0
 */
class Down
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        // DB制御
        // DBをrollbackしたい場合は\Globality::dbErrorを設定しておく
        if (\Globality::hasDBError()) {
            \DB::rollback();
        } else {
            \DB::commit();
        }

        return $response;
    }
}