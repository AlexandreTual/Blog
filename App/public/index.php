<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:39
 */

session_start();
use App\config\Router;
use App\config\RouterAdmin;
use App\config\Autoloader;

define('ROOT', dirname(__DIR__));

require ROOT.'/config/Autoloader.php';
Autoloader::register();

$router = new Router();

/*if (isset($_SESSION['auth'] === )) {
    $router .= admin/new RouterAdmin();
}*/
$router->run();