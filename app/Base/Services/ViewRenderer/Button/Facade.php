<?php

namespace App\Base\Services\ViewRenderer\Button;

/**
 * Class Facade
 * @package App\Base\Services\ViewRenderer\Button
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
        return 'button';
    }
}
