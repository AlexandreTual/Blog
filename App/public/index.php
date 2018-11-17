<?php
/*
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:39
 */

use App\config\Autoloader;
use App\config\Router;

session_start();
define('ROOT', dirname(__DIR__));
require ROOT . '/config/Autoloader.php';

Autoloader::register();

$router = new Router();
$router->run();