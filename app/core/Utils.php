<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23/10/2018
 * Time: 14:39
 */

namespace app\core;

abstract class Utils
{
    /**
     * Retourne la valeur enregistrée en session et l'efface
     */
    public static function getFlashBag($key)
    {
        if (isset($_SESSION['flashbag'][$key])) {
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

    public static function messageAlert($conditionBoolean, $successMessage, $errorMessage)
    {
        if (isset($conditionBoolean) && $conditionBoolean) {
            $message = '<div class="alert alert-success" role="alert">' . $successMessage . '</div>';
        } else {
            $message = '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
        }
        return $message;
    }

    /**
     * Ajoute une valeur dans une session tampon
     */
    public static function addFlashBag($key, $value = true)
    {
        $_SESSION['flashbag'][$key] = $value;
    }

    public static function isAdmin()
    {
        if (isset($_SESSION['quality']) && $_SESSION['quality'] === 'admin') {
            return true;
        } else {
            $errorM = 'Accès refusé !';
            $message = Utils::messageAlert(false, null, $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php');
        }
    }

    public static function isUser()
    {
        if (isset($_SESSION['quality']) && $_SESSION['quality'] === 'user') {
            return true;
        } else {
            $errorM = 'Accès refusé !';
            $message = Utils::messageAlert(false, null, $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php');
        }
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
        header('Location: index.php?p=post_list');
    }

    public static function messageError($message, $redirection)
    {
        $errorM = $message;
        $message = Utils::messageAlert(false, null, $errorM);
        Utils::addFlashBag('message', $message);
        header('Location: index.php?p=' . $redirection);
    }

    public static function messageSuccess($message, $redirection)
    {
        $successM = $message;
        $message = Utils::messageAlert(true, $successM, null);
        Utils::addFlashBag('message', $message);
        header('Location:index.php?p=' . $redirection);
    }

    public static function sendMail($html, $recipient = null, $post = null, $username = null, $validationKey = null, $id = null)
    {
        if ($html === 'contact') {
            $message = '<html>
                        <head></head>
                        <body>
                        <p>nom : '.$post['lastname'].'<br>
                        prénom : '.$post['firstname'].'<br>
                        <br>'.nl2br($post['content']).'</p>
                        </body>
                        </html>';
        } elseif ($html === 'registration') {
            $object = 'Enregistrement de compte';
            $message = '<html>
                        <head></head>
                        <body>
                        <p>Hey <strong>' . ucfirst($username) . '</strong>,</p>
                        <p>Nous sommes fier que vous ayez choisi de vous inscrire sur notre blog</p>
                        <p>Pour activer votre compte, cliquer sur le lien ci-dessous:</p>
                        <a href="http://localhost/BLog/ProjetBlog/app/public/index.php?p=registration&userId=' . $id . '&key=' . $validationKey . '">Activation de compte</a>
                        <p>Vous retrouverez régulièrement des articles traitant de mon parcours en tant developpeur PHP</p>
                        <p>Cordialement<br>
                        <em>Le blogggeur</em></p>
                        </body>
                        </html>';
        } elseif ($html === 'update_password') {
            $object = 'Réinitialisation de mot de passe';
            $message = '<html>
                        <head></head>
                        <body>
                        <p>Hey <strong>' . ucfirst($post->getUsername()) . '</strong>,</p>
                        <p>Une demande de réinitialisation de mot de passe nous est parvenue.<br>
                        Si ce n\'est pas vous qui avez effectué cette demande, ne tenez pas compte de cet email.</p>
                        <p>Sinon pour mettre à jour votre mot de passe, cliquer sur le lien ci-dessous:</p>
                        <a href="http://localhost/BLog/ProjetBlog/app/public/index.php?p=update_password&userId=' . $post->getId() . '&key=' . $validationKey . '">Mettre à jour le mot de passe.</a><br>
                        <p>Cordialement<br>
                        <em>Le blogggeur</em></p>
                        </body>
                        </html>';
        }
        $to = $recipient;
        $charset = "UTF-8";
        $break_line = "\r\n";
        $boundary = "-----=".md5(rand());
        $topic = $object;
        $message_html = $message ;
        $message_txt = strip_tags($message_html);
        $headers = "From: \"" . $username . "\"<" . $recipient . ">" . $break_line;
        $headers.= "Reply-to: \"" . $username . "\" <" . $recipient . ">" . $break_line;
        $headers.= "MIME-Version: 1.0" . $break_line;
        $headers.= "Content-Type: multipart/alternative;" . $break_line . " boundary=\"" . $boundary . "\"" . $break_line;
        $message = $break_line . $boundary . $break_line;
        $message .= "Content-Type: text/plain; charset=\"$charset\"" . $break_line;
        $message .= "Content-Transfer-Encoding: 8bit" . $break_line;
        $message .= $break_line . $message_txt . $break_line;
        $message .= $break_line . "--" . $boundary . $break_line;
        $message .= "Content-Type: text/html; charset=\"$charset\"" . $break_line;
        $message .= "Content-Transfer-Encoding: 8bit" . $break_line;
        $message .= $break_line . $message_html . $break_line;
        $message .= $break_line . "--" . $boundary . "--" . $break_line;
        $message .= $break_line . "--" . $boundary . "--" . $break_line;
        (mail($to, $topic, $message, $headers));
    }
}