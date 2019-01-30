<?php

namespace App\Base\Services\Constant;

use Illuminate\Support\ServiceProvider;

/**
 * Class ConstantProvider
 * @package App\Base\Services\Constant
 * @author yanahiro
 * @version 1.0.0
 */
class ConstantProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // シングルトンとしてクラスを生成
        $this->app->singleton('constant', function ($app) {
            return new Constant();
        });
    }
}
