<?php
namespace App\src\controller;

use App\src\DAO\PostDAO;
use App\src\model\View;
use App\src\DAO\CommentDAO;


class BackController
{
    private $view;
    private $postDAO;
    private $commentDAO;

    public function __construct()
    {
        $this->view = new View();
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();


    }







}