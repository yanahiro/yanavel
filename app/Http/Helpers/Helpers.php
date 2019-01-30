<?php

/**
 * Helpers内にあるphpファイルをincludeする
 */
$path = dirname(__FILE__);
foreach(scandir($path) as $file)
{
    $full = $path.'/'.$file;
    if (is_file($full)) {
        include_once($full);
    }
}
