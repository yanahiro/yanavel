<?php

namespace App\Base\Services\ViewRenderer\Widget;

/**
 * Class Facade
 * @package App\Services\RenderUtil\Widget
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
        return 'widget';
    }
}
