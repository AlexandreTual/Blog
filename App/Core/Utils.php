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

    /*public static function  dropdown($label)
    {
        $drop = '<div class="input-group">
                  <input type="text" class="form-control" aria-label="Text input with dropdown button">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'. $label .'</button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Something else here</a>
                      <div role="separator" class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                  </div>
                 </div>';
        return $drop;
    }*/




}