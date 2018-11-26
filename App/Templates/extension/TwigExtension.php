<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23/11/2018
 * Time: 23:03
 */
namespace app\templates\extension;
use app\src\dao\CategoryDAO;
use app\src\dao\PostDAO;
use Twig_SimpleFunction;
use app\core\Utils;

class TwigExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('getCategory', [$this, 'getCategory']),
            new Twig_SimpleFunction('getLastPost', [$this, 'getLastPost']),
            new Twig_SimpleFunction('echoFlashBag', [$this, 'echoFlashBag'])
        ];
    }

    public function getCategory()
    {
        $categoryDAO = new CategoryDAO();
        return $category = $categoryDAO->getCategory();
    }

    public function getLastPost()
    {
        $postDAO = new PostDAO();
        return $post = $postDAO->getLastPost( 4);
    }

    public function echoFlashBag()
    {
        $message = Utils::getFlashBag('message');
        if (!empty($message)) {
            return $message;
        }
    }
}