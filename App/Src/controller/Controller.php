<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13/11/2018
 * Time: 16:44
 */

namespace app\src\controller;

use app\src\dao\CommentDAO;
use app\src\dao\PostDAO;
use app\src\dao\UserDAO;
use app\src\dao\CategoryDAO;
use app\src\model\View;
use app\src\model\ViewTwig;

class Controller
{
    protected $view;
    protected $postDAO;
    protected $commentDAO;
    protected $userDAO;
    protected $categoryDAO;
    protected $viewTwig;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->viewTwig = new ViewTwig();
    }
}