<?php

namespace App\Base\Services\CustomSession\UnitSession;

/**
 * Class Facade
 * @package App\Services\DataUtil\UnitSession
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
        return 'unitsession';
    }
}
