<?php

namespace App\Base\Services\CustomSession\Once;

/**
 * Class Facade
 * @package App\Base\Services\DataUtil\Once
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
        return 'once';
    }
}
