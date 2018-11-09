<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:27
 */

namespace App\src\controller;

use App\src\model\View;
use App\Core\Utils;

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
        $errorM = 'page inconnu !';
        $successM = null;
        $message = Utils::messageAlert(false, $successM, $errorM);
        Utils::addFlashBag('message', $message);
        header('Location : index.php');

    }
}