<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:47
 */

namespace App\config;

use App\src\controller\FrontController;
use App\src\controller\ErrorController;

use \Exception;

class Router
{
    private $frontController;
    private $errorController;


    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
    }


    public function run()
    {
        try {
            if (isset($_GET['p'])) {
                $page = $_GET['p'];
            } else {
                $page = 'listPost';
            }

            switch ($page) {
                case 'listPost':
                    $this->frontController->getPostList();
                    break;
                case 'post':
                    $this->frontController->post($_GET['idArt']);
                    break;
                default:
                    $this->errorController->unknown();
            }
        } catch (Exception $e) {
            $this->errorController->error();
        }
    }
}
