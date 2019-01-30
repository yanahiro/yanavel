<?php

namespace App\Base\Services\ViewRenderer;

use Illuminate\Support\ServiceProvider;
use App\Base\Services\ViewRenderer\Button\Button;
use App\Base\Services\ViewRenderer\FormView\FormRender;
use App\Base\Services\ViewRenderer\ListView\ListRender;
use App\Base\Services\ViewRenderer\SearchView\SearchRender;
use App\Base\Services\ViewRenderer\SearchView\Dictionary;
use App\Base\Services\ViewRenderer\Widget\Widget;

/**
 * Class RenderUtilProvider
 *
 * @package App\Base\Services\ViewRenderer
 * @author yanahiro
 * @version 1.0.0
 */
class RenderUtilProvider extends ServiceProvider
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
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->singleton('listview', function ($app) {
            return new ListRender();
        });
		$this->app->singleton('formview', function ($app) {
            return new FormRender;
        });
		$this->app->singleton('searchview', function ($app) {
            return new SearchRender(new Dictionary);
        });
		$this->app->singleton('widget', function ($app) {
            return new Widget;
        });
		$this->app->singleton('button', function ($app) {
            return new Button();
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
            'listview', 'formview', 'searchview', 'widget', 'button',
        ];
    }
}
