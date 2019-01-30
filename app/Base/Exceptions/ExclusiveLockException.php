<?php

namespace App\Base\Exception;

use RuntimeException;

/**
 * Class ExclusiveLockException
 * 楽観的排他エラー例外
 *
 * @package App\Base\Exception
 * @author yanahiro
 * @version 1.0.0
 */
class ExclusiveLockException extends RuntimeException
{

}
