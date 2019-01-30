<?php

namespace App\Base\Services\ViewRenderer\ListView;

/**
 * Class Facade
 * @package App\Services\ViewRenderer\ListView
 * @author yanahiro
 * @version 1.0.0
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
        return 'listview';
    }
}
