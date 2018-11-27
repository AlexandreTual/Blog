<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/11/2018
 * Time: 13:14
 */

namespace app\src\controller;

use app\core\Utils;

class UserController extends Controller
{
    /**
     * @param $post
     * @param null $userId
     * @param null $key
     */
    public function registration($post, $userId = null, $key = null)
    {
        if (isset($post['submit'])) {
            // vérification de la présente de tout les champs attendus.
            if (Utils::checkField(['username', 'email', 'password', 'password2'], $post)) {
                $username = $post['username'];
                $email = $post['email'];
                $password1 = $post['password'];
                $password2 = $post['password2'];
                // vérification de l'absence du nom d'utilisateur dans la bdd.
                if (!$this->userDAO->getUser('username', $username)) {
                    // vérification de la validité de l'adresse mail.
                    if ((filter_var($email, FILTER_VALIDATE_EMAIL))
                        && (!$this->userDAO->getUser('email', $email))) {
                        // vérification de la longeur du mot de passe.
                        if (strlen($password1) >= 4) {
                            // vérification de l'égalité des mots de passe.
                            if ($password1 === $password2) {
                                // création d'un code unique afin de valider le compte par la suite
                                $validationKey = uniqid();
                                // cryptage du mot de passe
                                $password = sha1($password1);
                                // insertion des données dans la bdd.
                                $newUser = $this->userDAO->add($username, $email, $password, $validationKey);
                                $id = $this->userDAO->checkConnection()->lastInsertId();
                                if ($newUser) {
                                    Utils::sendMail('registration', $email, null, $username
                                        , $validationKey, $id);
                                    // envoi de l'email contenant le lien de validation de compte.
                                    Utils::messageSuccess('Nous vous remercions de vous être enregistré
                                    , un email vous à été envoyé afin de valider votre compte !', 'login');
                                } else {
                                    Utils::messageError('Une erreur c\'est produite lors de l\'enregistrement 
                                    de votre compte, veuillez réssayer s\'il vous plait !', 'login');
                                }
                            } else {
                                Utils::messageError('Les mots de passe ne sont pas identique.', 'login');
                            }
                        } else {
                            Utils::messageError('Votre mot de passe doit contenir au moins 4 caractères !'
                                , 'login');
                        }
                    } else {
                        Utils::messageError('L\'adresse mail existe déjà !', 'login');
                    }
                } else {
                    Utils::messageError('le nom d\'utilisateur est déjà pris !', 'login');
                }
            } else {
                Utils::messageError('Veuillez renseigner tout les champs.', 'login');
            }
        } elseif (!empty($userId) && !empty($key)) {
            $userId = (int)$userId;
            if ($userId != 0 && is_string($key)) {
                $user = $this->userDAO->getUser('id', $userId);
                if ($user->getValidationKey() === $key) {
                    $this->userDAO->update($user->getId(), $user->getPassword(), $user->getEmail(), $user->getquality()
                        , 'active', $user->getValidationKey());
                    Utils::messageSuccess('Félicitation votre compte est actif, vous pouvez vous identifier !'
                        , 'login');
                }
            }
        } else {
            $this->viewTwig->render('login.twig');
        }
    }

    /**
     * @param $post
     * @param null $userId
     * @param null $key
     */
    public function passwordUpdate($post, $userId = null, $key = null)
    {
        if (isset($post['submit']) && isset($post['password']) && isset($post['password2'])) {
            if ($post['password'] === $post['password2']) {
                $user = $this->userDAO->getUser('id', $userId);
                if ($user->getValidationKey() === $key) {
                    $password = sha1($post['password']);
                    $update = $this->userDAO->update($user->getId(), $password, $user->getEmail(),
                        $user->getquality(), $user->getStatus(), $user->getValidationKey());
                    session_destroy();
                    if ($update) {
                        Utils::messageSuccess('Votre mot de passe à été mis à jour, vous pouvez vous connecter !'
                            , 'login');
                    } else {
                        Utils::messageError('Une erreur c\'est produite veuillez recommencer.'
                            , 'update_password');
                    }
                }
            } else {
                $message = Utils::messageAlert(false, null
                    , 'Les mots de passes doivent être identique');
                Utils::addFlashBag('message', $message);
                header('Location: index.php?p=update_password&userId=' . $userId . '&key=' . $key);
            }
        } else {
            $get = $_GET ?: '';
            $this->viewTwig->render('update_password.twig', ['get' => $get]);
        }
    }

    /**
     * @param $post
     */
    public function passwordReset($post)
    {
        if (isset($post['submit']) && isset($post['email'])) {
            if ((filter_var($post['email'], FILTER_VALIDATE_EMAIL))
                && ($this->userDAO->getUser('email', $post['email']))) {
                $validationKey = uniqid();
                $user = $this->userDAO->getUser('email', $post['email']);
                $this->userDAO->update($user->getId(), $user->getPassword(), $user->getEmail(),
                    $user->getQuality(), $user->getStatus(), $validationKey);
                Utils::sendMail('update_password', $user->getEmail(), $user, null, $validationKey);
                Utils::messageSuccess('Opération réalisé avec success, un email vous a été envoyé !'
                    , 'login');
            } else {
                Utils::messageError('L\'adresse email n\existe pas !', 'reset_password');
            }
        } else {
            $get = $_GET ?: '';
            $this->viewTwig->render('update_password.twig', ['get' => $get]);
        }
    }

    /**
     * @param $userId
     * @param $status
     */
    public function updateUserStatus($userId, $status)
    {
        if (Utils::isAdmin()) {
            $userId = (int)$userId;
            $status = (int)$status;
            if (0 < $userId) {
                $user = $this->userDAO->getUser('id', $userId);
                $req = $this->userDAO->update($user->getId(), $user->getPassword(), $user->getEmail(),
                    $user->getquality(), $status, $user->getValidationKey());
                if ($req) {
                    Utils::messageSuccess('Status modifié !', 'admin');
                } else {
                    Utils::messageError('Erreur !! Status non modifié', 'admin');
                }
            }
        }
    }

    /**
     * @param $userId
     * @param $quality
     */
    public function updateUserQuality($userId, $quality)
    {
        if (Utils::isAdmin()) {
            $userId = (int)$userId;
            if (0 < $userId && is_string($quality)) {
                $user = $this->userDAO->getUser('id', $userId);
                $req = $this->userDAO->update($user->getId(), $user->getPassword(), $user->getEmail(),
                    $quality, $user->getStatus(), $user->getValidationKey());
                if ($req) {
                    Utils::messageSuccess('Qualité modifié !', 'admin');
                } else {
                    Utils::messageError('Erreur !! Status non modifié', 'admin');
                }
            }
        }
    }

    public function login($login)
    {

        // s'il n'y a pas de session avec un identifiant. on redirige vers le formulaire de connexion.
        if (!isset($_SESSION['userId'])) {
            /*si le champ submit est présent et que les champs username et password correspondent,
        on connecte l'utilisateur*/
            if (isset($login['submit'])) {
                if ($this->userDAO->getLogin($login['username'], $login['password'])) {
                    Utils::messageSuccess('Bienvenue ' . ucfirst($_SESSION['username']) . ' !', 'home');
                } else {
                    $errorM = 'Identifants incorrect ou compte inactif.';
                    $message = Utils::messageAlert(false, null, $errorM);
                    Utils::addFlashBag('message', $message);
                }
            }
            $this->viewTwig->render('login.twig', []);
        } else {
            $errorM = ucfirst($_SESSION['username']) . ' vous êtes déjà connecté !';
            $message = Utils::messageAlert(false, null, $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php');
        }
    }

    public function logout()
    {
        session_destroy();
        Utils::messageSuccess('Vous êtes Déconnecté !', 'home');
    }

}