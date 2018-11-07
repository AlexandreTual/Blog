<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:27
 */

namespace App\src\controller;

use App\src\model\View;

class ErrorController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function error($e) {
        $this->view->render('error', ['e' => $e]);
    }

    public function unknown() {
        $this->view->render('unknown');
    }
}