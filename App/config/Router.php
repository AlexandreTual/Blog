<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:47
 */

namespace App\config;

use App\src\controller\BackController;
use App\src\controller\FrontController;
use App\src\controller\ErrorController;

use \Exception;

class Router
{
    private $frontController;
    private $errorController;
    private $backController;


    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
        $this->backController = new BackController();
    }


    public function run()
    {
        try {
            if (isset($_GET['p'])) {
                $page = $_GET['p'];
            } else {
                $page = 'home';
            }

            switch ($page) {
                case 'home':
                    $this->frontController->home();
                    break;
                case 'post-list':
                    $this->frontController->getPostList();
                    break;
                case 'post':
                    $this->frontController->post($_GET['idArt']);
                    break;
                case 'login':
                    $this->frontController->login($_POST);
                    break;
                case 'logout':
                    $this->frontController->logout();
                    break;

                default:
                    $this->errorController->unknown();
            }
        } catch (Exception $e) {
            $this->errorController->error($e);
        }
    }
}
