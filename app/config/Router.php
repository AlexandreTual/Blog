<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:47
 */

namespace app\config;

use app\src\controller\AppController;
use app\src\controller\CategoryController;
use app\src\controller\CommentController;
use app\src\controller\ErrorController;
use app\src\controller\PostController;
use app\src\controller\UserController;
use Exception;

class Router
{
    private $appController;
    private $categoryController;
    private $commentController;
    private $errorController;
    private $postController;
    private $userController;

    public function __construct()
    {
        $this->appController = new AppController();
        $this->categoryController = new CategoryController();
        $this->commentController = new CommentController();
        $this->errorController = new ErrorController();
        $this->postController = new PostController();
        $this->userController = new UserController();
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
                    $this->appController->home();
                    break;
                case 'post_list':
                    $this->postController->getPostList(null);
                    break;
                case 'post':
                    $this->postController->post($_GET['idArt']);
                    break;
                case'category':
                    $this->postController->getPostList($_GET['category']);
                    break;
                case 'add_category':
                    $this->categoryController->addCategory($_POST);
                    break;
                case 'login':
                    $this->userController->login($_POST);
                    break;
                case 'logout':
                    $this->userController->logout();
                    break;
                case 'admin':
                    $this->appController->getAdmin();
                    break;
                case'add_post':
                    $this->postController->addPost($_POST);
                    break;
                case 'update_post':
                    $this->postController->updatePost($_GET['idArt'], $_POST);
                    break;
                case 'delete_post':
                    $this->postController->deletePost($_GET['idArt']);
                    break;
                case'publish_post':
                    $this->postController->updatePost($_GET['idArt'], $_POST, $_GET['publish']);
                    break;
                case'add_comment':
                    $this->commentController->addComment($_POST, $_GET['idArt']);
                    break;
                case 'delete_comment':
                    $this->commentController->deleteComment($_GET['idArt'], $_GET['idComment']);
                    break;
                case 'update_comment':
                    $this->commentController->updateComment($_GET['idComment'], $_GET['idArt'], $_POST);
                    break;
                case'publish_comment':
                    $this->commentController->publishComment($_GET['idComment'], $_GET['publish']);
                    break;
                case 'manage_comment':
                    $this->commentController->getCommentList();
                    break;
                case'registration':
                    $this->userController->registration($_POST, $_GET['userId'], $_GET['key']);
                    break;
                case 'reset_password':
                    $this->userController->passwordReset($_POST);
                    break;
                case 'update_password':
                    $this->userController->passwordUpdate($_POST, $_GET['userId'], $_GET['key']);
                    break;
                case 'update_user_status':
                    $this->userController->updateUserStatus($_GET['userId'], $_GET['status']);
                    break;
                case 'update_user_quality':
                    $this->userController->updateUserQuality($_GET['userId'], $_GET['quality']);
                    break;
                case'contact':
                    $this->appController->senderMail($_POST);
                    break;
                case'newsletter':
                    $this->appController->addNewsletter($_POST);
                    break;
                case'maintenance':
                    $this->appController->maintenance();
                    break;
                default:
                    $this->errorController->unknown();
            }
        } catch (Exception $error) {
            $this->errorController->error($error);
        }
    }
}
