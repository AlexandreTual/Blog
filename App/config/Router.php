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
                case 'admin':
                    $this->backController->getAdmin();
                    break;
                case'add-comment':
                    $this->frontController->addComment($_POST, $_GET['idArt'], $_SESSION['userId']);
                    break;
                case 'delete-comment':
                    $this->frontController->deleteComment($_GET['idArt'], $_GET['idComment'], $_SESSION['userId']);
                    break;
                case 'update-comment':
                    $this->frontController->updateComment($_GET['idArt'], $_GET['idComment'], $_SESSION['userId'], $_POST);
                    break;
                case'add-post':
                    $this->backController->addPost($_POST);
                    break;
                case 'update-post':
                    $this->backController->updatePost($_GET['idArt'], $_POST);
                    break;
                case 'delete-post':
                    $this->backController->deletePost($_GET['idArt']);
                    break;
                case'publish-post':
                    $this->backController->updatePost($_GET['idArt'], $_POST, $_GET['publish']);
                    break;
                case'button-tag':
                default:
                    $this->errorController->unknown();
            }
        } catch (Exception $e) {
            $this->errorController->error($e);
        }
    }
}
