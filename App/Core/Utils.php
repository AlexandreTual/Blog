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

    public static function messageError($message, $redirection)
    {
        $errorM = $message;
        $message = Utils::messageAlert(false, null, $errorM);
        Utils::addFlashBag('message', $message);
        header('Location: index.php?p='.$redirection);
    }

    public static function messageSuccess($message, $redirection)
    {
        $successM = $message;
        $message = Utils::messageAlert(true, $successM, null);
        Utils::addFlashBag('message', $message);
        header('Location: index.php?p='.$redirection);
    }

    public static function sendMail($recipient, $username, $activationKey, $id)
    {
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $recipient)) {
            $break_line = "\r\n";
        } else {
            $break_line = "\n";
        }

        $message_html = '<html>
                        <head></head>
                        <body>
                        <p>Hey <strong>'. ucfirst($username) .'</strong>,</p>
                        <p>Nous sommes fier que vous ayez choisi de vous inscrire sur notre blog</p>
                        <p>Pour activer votre compte, cliquer sur le lien ci-dessous:</p>
                        <a href="http://localhost/BLog/ProjetBlog/App/public/index.php?p=registration&userId=' . $id . '&activ=' . $activationKey . '">Activation de compte</a>
                        <p>Vous retrouverez régulièrement des articles traitant de mon parcours en tant developpeur PHP</p>
                        <p>Cordialement<br>
                        <em>Le blogggeur</em></p>
                        </body>
                        </html>';

        $boundary = "-----=".md5(rand());

        $topic = "hey mon ami !";
        //Création du header de l'email.
        $header = "From: \"Tual Alexandre\" <".$recipient.">".$break_line;
        $header.= "Reply-to: \"Alexandre TUAL\" <tual.alexandre@gmail.com>".$break_line;
        $header.= "MIME-version: 1.0".$break_line;
        $header.= "Content-type: multipart/alternative;".$break_line." boundary=\"$boundary\"".$break_line;

        $message = $break_line."--".$boundary.$break_line;
        //Ajout du message au format HTML.
        $message .= "Content-Type: text/html; charset=\"ISO-8859-1\"".$break_line;
        $message .= "Content-Transfer-Encoding: 8bit".$break_line;
        $message .= $break_line.$message_html.$break_line;

        //On ferme la boundary alternative.
        $message.=$break_line."--".$boundary."--".$break_line;

        mail($recipient,$topic,$message,$header);
    }






}