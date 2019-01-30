<?php namespace App\Services\Setup\DataImport;

use Illuminate\Support\ServiceProvider;

/**
 *
 * data_import操作クラス
 * サービスプロバイダでシングルトンとして登録
 *
 * @author yanahiro
 * @version 2018.12.01
 */
class CsvImportProvider extends ServiceProvider
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
        $this->app->singleton('csv_import', function ($app) {
            return new CsvImport;
        });
    }
}
