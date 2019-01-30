<?php

namespace App\Base\Services\Constant;

/**
 * Class Facade
 * @package App\Base\Services\Constant
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
        return 'constant';
    }
}
