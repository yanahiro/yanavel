<?php

namespace App\Base\Services\Breadcrumb;

use Illuminate\Support\ServiceProvider;

/**
 * Class BreadcrumbProvider
 * @package App\Base\Services\Breadcrumb
 * @author yanahiro
 * @version 1.0.0
 */
class BreadcrumbProvider extends ServiceProvider
{
    /**
     * 遅延ロード
     *
     * @var bool
     */
    protected $defer = true;

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
        $this->app->singleton('breadcrumb', function ($app) {
            return new Breadcrumb;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'breadcrumb',
        ];
    }
}
