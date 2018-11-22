<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:47
 */

namespace App\config;

use App\src\controller\BackController;
use App\src\controller\ErrorController;
use App\src\controller\FrontController;
use Exception;

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
                case 'post_list':
                    $this->frontController->getPostList(null);
                    break;
                case 'post':
                    $this->frontController->post($_GET['idArt']);
                    break;
                case'category':
                    $this->frontController->getPostList($_GET['category']);
                    break;
                case 'add_category':
                    $this->backController->addCategory($_POST);
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
                case'add_post':
                    $this->backController->addPost($_POST);
                    break;
                case 'update_post':
                    $this->backController->updatePost($_GET['idArt'], $_POST);
                    break;
                case 'delete_post':
                    $this->backController->deletePost($_GET['idArt']);
                    break;
                case'publish_post':
                    $this->backController->updatePost($_GET['idArt'], $_POST, $_GET['publish']);
                    break;
                case'add_comment':
                    $this->frontController->addComment($_POST, $_GET['idArt']);
                    break;
                case 'delete_comment':
                    $this->frontController->deleteComment($_GET['idArt'], $_GET['idComment']);
                    break;
                case 'update_comment':
                    $this->frontController->updateComment($_GET['idComment'], $_GET['idArt'], $_POST);
                    break;
                case'publish_comment':
                    $this->backController->publishComment($_GET['idComment'], $_GET['publish']);
                    break;
                case 'manage_comment':
                    $this->backController->GetCommentList();
                    break;
                case'registration':
                    $this->backController->registration($_POST, $_GET['userId'], $_GET['key']);
                    break;
                case 'reset_password':
                    $this->backController->PasswordReset($_POST);
                    break;
                case 'update_password':
                    $this->backController->PasswordUpdate($_POST, $_GET['userId'], $_GET['key']);
                    break;
                case 'update_user_status':
                    $this->backController->updateUserStatus($_GET['userId'], $_GET['status']);
                    break;
                case 'update_user_quality':
                    $this->backController->updateUserQuality($_GET['userId'], $_GET['quality']);
                    break;
                case'contact':
                    $this->frontController->SenderMail($_POST);
                    break;
                default:
                    $this->errorController->unknown();
            }
        } catch (Exception $e) {
            $this->errorController->error($e);
        }
    }
}
