<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13/11/2018
 * Time: 16:44
 */

namespace App\src\controller;

use App\src\DAO\CommentDAO;
use App\src\DAO\PostDAO;
use App\src\DAO\UserDAO;
use App\src\DAO\CategoryDAO;
use App\src\model\View;

class Controller
{
    protected $view;
    protected $postDAO;
    protected $commentDAO;
    protected $userDAO;
    protected $categoryDAO;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
        $this->view = new View();
        $this->categoryDAO = new CategoryDAO();
    }
}