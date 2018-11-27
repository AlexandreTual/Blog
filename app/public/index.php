<?php
/*
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:39
 */

use app\config\Router;
require '../../vendor/autoload.php';
session_start();
define('ROOT', dirname(__DIR__));

$router = new Router();
$router->run();