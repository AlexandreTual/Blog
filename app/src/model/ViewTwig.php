<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18/11/2018
 * Time: 14:21
 */

namespace app\src\model;

use app\templates\extension\TwigExtension;
use Twig_Environment;
use Twig_Extensions_Extension_Text;
use Twig_Loader_Filesystem;

class ViewTwig
{
    private $viewTwig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem('../templates');
        $this->viewTwig = new Twig_Environment($loader, ['debug' => true]);
        $this->viewTwig->addGlobal('session', $_SESSION);
        $this->viewTwig->addExtension( new TwigExtension());
        $this->viewTwig->addExtension(new Twig_Extensions_Extension_Text() );
        $this->viewTwig->addExtension( new \Twig_Extension_Debug());
    }

    public function render($template, $data = null)
    {
        echo $this->viewTwig->render($template, $data);
    }
}