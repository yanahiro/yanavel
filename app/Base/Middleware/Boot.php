<?php

namespace App\Base\Middleware;

/**
 * 前処理
 * 基本思想として必ずリクエスト毎に呼び出される処理
 * 前処理で共通的に処理を行いたい場合に処理を記載
 *
 * Once, UnitSessionサービスを利用している処理は
 * 必ず呼び出す必要あり
 *
 * @package App\Base\Middleware
 * @author yanahiro
 * @version 1.0.0
 */
class Boot
{
    public function handle($request, \Closure $next)
    {
        // Onceサービスの初期化
        \Once::init();
        // 機能Sessionの初期化
        \UnitSession::init();

        // トランザクションの開始
        \DB::beginTransaction();

        return $next($request);
    }
}