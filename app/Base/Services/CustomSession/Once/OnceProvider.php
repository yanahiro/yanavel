<?php

namespace App\Base\Services\CustomSession\Once;

use Illuminate\Support\ServiceProvider;

/**
 * Class OnceProvider
 * シングルトンとして登録
 *
 * @package App\Base\Services\CustomSession\Once
 * @author yanahiro
 * @version 1.0.0
 */
class OnceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->singleton('once', function ($app) {
            return new Once();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
