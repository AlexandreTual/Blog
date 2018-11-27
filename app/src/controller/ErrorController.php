<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:27
 */

namespace app\src\controller;

use app\core\Utils;

class ErrorController extends Controller
{
    public function error($error)
    {
        $error = $error->getmessage();
        $this->viewTwig->render('error.twig', ['error' => $error]);
    }

    public function unknown()
    {
        $errorM = 'page inconnu !';
        $successM = null;
        $message = Utils::messageAlert(false, $successM, $errorM);
        Utils::addFlashBag('message', $message);
        header('Location: index.php');

    }
}