<?php

namespace App\Base\Services\CustomSession\UnitSession;

use Illuminate\Support\ServiceProvider;

/**
 * Class SpaceProvider
 * シングルトンとして登録
 *
 * @package App\Services\DataUtil\Space
 * @author yanahiro
 * @version 1.0.0
 */
class UnitSessionProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('unitsession', function ($app) {
            return new UnitSession();
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
