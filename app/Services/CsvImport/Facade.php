<?php namespace App\Services\CsvImport;

/**
 * facade定義
 *
 * @author yanahiro
 * @version 2018.12.01
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * ファサード
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'csv_import';
    }
}
