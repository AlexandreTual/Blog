<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:39
 */

use App\config\Router;
use App\config\Autoloader;

define('ROOT', dirname(__DIR__));

require ROOT.'/config/Autoloader.php';
Autoloader::register();

$router = new Router();
$router->run();