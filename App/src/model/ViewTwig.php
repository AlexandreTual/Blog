<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18/11/2018
 * Time: 14:21
 */

namespace App\src\model;

use Twig_Loader_Filesystem;
use Twig_Environment;

class ViewTwig
{
    private $viewTwig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem('../templates');
        $this->viewTwig = new Twig_Environment($loader, ['debug' => true]);
        $this->viewTwig->addExtension( new \Twig_Extension_Debug());
    }

    public function render($template, $data = null)
    {
        echo $this->viewTwig->render($template, $data);
    }




}