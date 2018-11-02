<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:57
 */

namespace App\src\controller;

use \App\src\DAO\PostDAO;
use \App\src\model\View;

class FrontController
{
    private $postDAO;
    private $view;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->view = new View();
    }


    public function getPostList()
    {
        $posts = $this->postDAO->getAll();
        $this->view->render('post_list', ['posts' => $posts]);
    }

    public function post($id)
    {
        $post = $this->postDAO->getPost($id);
        $this->view->render('single', [
            'post' => $post,
        ]);
    }

}