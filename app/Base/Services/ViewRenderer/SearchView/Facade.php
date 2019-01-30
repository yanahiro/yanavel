<?php

namespace App\Base\Services\ViewRenderer\SearchView;

/**
 * Class Facade
 * @package App\Services\ViewRenderer\SearchView
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
        return 'searchview';
    }
}
