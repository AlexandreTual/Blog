<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:57
 */

namespace App\src\controller;

use App\Core\Utils;
use App\src\DAO\CommentDAO;
use \App\src\DAO\PostDAO;
use \App\src\model\View;
use App\src\DAO\UserDAO;

class FrontController
{
    private $view;
    private $postDAO;
    private $commentDAO;
    private $userDAO;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->view = new View();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
    }

    public function home()
    {
        $this->view->render('home');
    }

    public function getPostList()
    {
        $posts = $this->postDAO->getAll();
        $this->view->render('post_list', ['posts' => $posts]);
    }

    public function post($id)
    {
        $post = $this->postDAO->getPost($id);
        $comments = $this->commentDAO->getCommentFromPost($id);
        $this->view->render('single', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function login($login)
    {
        /*si le champ submit est présent et que les champs username et password correspondent,
        on connecte l'utilisateur*/
        if (isset($login['submit'])) {
            if($this->userDAO->getLogin($login['username'], $login['password'])) {
                header('Location: index.php');
            } else {
                $errorM = 'Identifants incorrect';
                $message = Utils::messageAlert(false, null , $errorM);
                Utils::addFlashBag('message', $message);
            }
        }
        $this->view->render('login');
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
    }

}