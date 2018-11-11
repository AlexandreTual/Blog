<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23/10/2018
 * Time: 14:39
 */

namespace App\Core;


abstract class Utils
{

    /**
     * @param $str
     * @return array|string
     * explode sur "_", ucfirst sur chaque mots puis retourne un string
     */
    public static function ucfToUnder($str)
    {
        if (strpos($str, '_')) {
        $str = explode('_', $str);
        $str = array_map(function($e) { return ucfirst($e); }, $str);
        $str = implode($str);
        }
        return $str;
    }

    /**
     * @param $data
     * @return string
     */
    public static function displayHtmlSecure($data)
    {
        return $data  = htmlspecialchars($data);
    }

    public static function messageAlert($conditionBoolean, $successMessage , $errorMessage )
    {
        if (isset($conditionBoolean) && $conditionBoolean === true) {
            $message = '<div class="alert alert-success" role="alert">'. $successMessage . '</div>';
        } else {
            $message = '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
        }
        return $message;
    }

    /**
     * Ajoute une valeur dans une session tampon
     */
    public static function addFlashBag($key, $value = true) {

        $_SESSION['flashbag'][$key] = $value;
    }

    public static function echoFlashBag($key)
    {
        $message = Utils::getFlashBag($key);

        if(!empty($message)){
            echo $message;
        }
    }

    /**
     * Retourne la valeur enregistrée en session et l'efface
     */
    public static function getFlashBag($key) {

        if(isset($_SESSION['flashbag'][$key])) {

            $flashbag = $_SESSION['flashbag'][$key];

            unset($_SESSION['flashbag'][$key]);

            return $flashbag;
        }
        return false;
    }

    public static function checkField(array $keys, array $data)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $data) || !isset($data[$key]) || empty($data[$key])) {
                return false;
            }
        }
        return true;
    }

    public static function isUser()
    {
        if (isset($_SESSION['userId'])) {
            return true;
        } else {
            $errorM = 'Accès refusé ! Mais n\'hésitez pas à vous connecter';
            $message = Utils::messageAlert(false, null, $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php?p=login');
        }
    }

    public static function isAdmin()
    {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
            return true;
        } else {
            $errorM = 'Accès refusé !';
            $message = Utils::messageAlert(false, null, $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php');
        }
    }

    public static function LastUrl()
    {
        $p = $_REQUEST;
        $url ='';
        foreach ($p as $k => $v) {
            $url .=  $k.'='.$v.'&';
        }
        return $url;

    }

    public static function actionRefused()
    {
        $errorM = 'Cette action n\'est pas possible, vous avez été redirigez vers la page d\'accueil !';
        $message = Utils::messageAlert(false, null, $errorM);
        Utils::addFlashBag('message', $message);
        header('Location: index.php');
    }

    public static function postWaiting()
    {
        $errorM = 'Cet article n\'est pas disponible, mais n\'hésitez pas à lire nos autres articles !';
        $message = Utils::messageAlert(false, null, $errorM);
        Utils::addFlashBag('message', $message);
        header('Location: index.php?p=post-list');
    }






}