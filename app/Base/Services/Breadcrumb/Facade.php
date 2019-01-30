<?php

namespace App\Base\Services\Breadcrumb;

/**
 * Class Facade
 * @package App\Base\Services\Breadcrumb
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
        return 'breadcrumb';
    }
}
