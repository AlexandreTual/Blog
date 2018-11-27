<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13/11/2018
 * Time: 16:44
 */

namespace app\src\controller;

use app\src\dao\CategoryDAO;
use app\src\dao\CommentDAO;
use app\src\dao\PostDAO;
use app\src\dao\UserDAO;
use app\src\model\ViewTwig;

class Controller
{
    protected $categoryDAO;
    protected $commentDAO;
    protected $postDAO;
    protected $userDAO;
    protected $view;
    protected $viewTwig;

    public function __construct()
    {
        $this->categoryDAO = new CategoryDAO();
        $this->commentDAO = new CommentDAO();
        $this->postDAO = new PostDAO();
        $this->userDAO = new UserDAO();
        $this->viewTwig = new ViewTwig();
    }
}