<?php
/**
 * Файл начальной загрузки данных
 */

use app\core;

require __DIR__ . '/const.php';
require __DIR__ . '/autoload.php';    //файл автозагрузки
require __DIR__ . '/lib/DataBase.php';
require __DIR__ . '/lib/functions.php';

if(empty($_SESSION['user']))
{
    include_once "auth.php";
}
else
{
    core\Route::start();
}
