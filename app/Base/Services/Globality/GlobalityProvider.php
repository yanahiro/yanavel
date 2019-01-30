<?php

namespace App\Base\Services\Globality;

use Illuminate\Support\ServiceProvider;

class GlobalityProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('globality', function ($app) {
            return new Globality();
        });
    }
}
