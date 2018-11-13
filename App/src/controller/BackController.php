<?php
namespace App\src\controller;

use App\src\DAO\PostDAO;
use App\src\model\User;
use App\src\model\View;
use App\src\DAO\CommentDAO;
use App\src\DAO\UserDAO;
use App\Core\Utils;


class BackController
{
    private $view;
    private $postDAO;
    private $commentDAO;
    private $userDAO;

    public function __construct()
    {
        $this->view = new View();
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
    }

    public function getAdmin()
    {
        if (Utils::isAdmin()) {
            $posts = $this->postDAO->getAll('all', true);
            $comments = $this->commentDAO->getComments('waiting');
            $this->view->render('admin', ['posts' => $posts, 'comments' => $comments]);
        } else {
            header('Location: index.php');
        }
    }


    public function addPost($post)
    {
        if (Utils::isAdmin()) {

            if (isset($post['submit'])) {

                if (Utils::checkField(['title', 'chapo','content', 'author'], $post)) {
                    $post = $this->postDAO->add($post);

                    $successM = 'Votre nouvel article à bien été crée !';
                    $message = Utils::messageAlert(true, $successM, null);
                    Utils::addFlashBag('message', $message);

                    header('Location: index.php?p=post&idArt='.$post);
                } else {
                    $errorM = 'Veuillez définir tout les champs du formulaire !';
                    $message = Utils::messageAlert(false, null, $errorM);
                    Utils::addFlashBag('message', $message);

                }
            } $this->view->render('add-post');
        }
    }

    public function updatePost($id, $post = null, $publish = null)
    {
        if (Utils::isAdmin()) {
            if ((isset($post['submit'])) || isset($publish)) {
                // on vérifie que tout les champs du formulaire sont présent et non vide.
                if (Utils::checkField(['title','chapo', 'content', 'author'], $post) || isset($publish)) {
                    // si la variable publish est présente
                    if (isset($publish)) {
                        //  on la modifie en fonction du parametre passé
                        $this->postDAO->update($id, null, $publish);
                        header('Location: index.php?p=admin');

                    } else {
                        // si publish n'est pas présent on modifie le contenu de l'article
                        $this->postDAO->update($id, $post);
                        header('Location: index.php?p=post&idArt='.$id);
                    }
                } else {
                    $errorM = 'Veuillez remplir tout les champs du formulaire !';
                    $successM = null;
                    $message = Utils::messageAlert(false, $successM, $errorM);
                    Utils::addFlashBag('message', $message);
                }

            }
            // si la session admin est connecté mais qu'il n'y a pas de soumission de formulaire
            // on appel le l'article pour remplir le formulaire de modification
            $post = $this->postDAO->getPost($id);
            $this->view->render('update-post', ['post' =>$post]);
        }
    }

    public function deletePost($id)
    {
        if (Utils::isAdmin()) {
            if (isset($id)) {
                $id = (int) $id;
                $post = $this->postDAO->delete($id);

                $errorM = 'L\'article n\'a pu être supprimé !';
                $successM = 'L\'article à été supprimé !';
                $message = Utils::messageAlert($post, $successM, $errorM);
                Utils::addFlashBag('message', $message);
                header('Location: index.php?p=admin');
            }
        }
    }

    public function GetCommentList()
    {
        if (Utils::isAdmin()) {
            $comments = $this->commentDAO->getComments('waiting');
            $this->view->render('manage_comment', ['comments' => $comments]);
        }

    }

    public function publishComment($idComment, $publish)
    {
        if (Utils::isAdmin()) {
            $this->commentDAO->update($idComment, null, $publish);

            $successM = 'Le commentaire vient d\'être publié';
            $message = Utils::messageAlert(true, $successM, null);
            Utils::addFlashBag('message', $message);
            header('Location: index.php?p=manage-comment');
        }
    }

    public function registration($post, $userId = null, $activ = null)
    {
        if (isset($post['submit'])) {
            // vérification de la présente de tout les champs attendus.
            if (Utils::checkField(['username','email', 'password', 'password2'],$post)) {
                $username = $post['username'];
                $email = $post['email'];
                $pass1 = $post['password'];
                $pass2 = $post['password2'];

                // vérification de l'absence du nom d'utilisateur dans la bdd.
                if (!$this->userDAO->getUser(null,$username)) {
                    // vérification de la validité de l'adresse mail.
                    if ((filter_var($email, FILTER_VALIDATE_EMAIL)) && (!$this->userDAO->getUser(null, null, $email))) {
                        // vérification de la longeur du mot de passe.
                            if (strlen($pass1) >= 6) {
                                // vérification de l'égalité des mots de passe.
                                if ($pass1 === $pass2) {
                                    // création d'un code unique afin de valider le compte par la suite
                                    $status = uniqid();
                                    // cryptage du mot de passe
                                    $password = sha1($pass1);
                                    // insertion des données dans la bdd.
                                    $newUser = $this->userDAO->add($username, $email, $password, $status);
                                    $id = $this->userDAO->checkConnection()->lastInsertId();
                                    if ($newUser) {
                                        Utils::sendMail('tual.alexandre@gmail.com', $username, $status, $id);

                                        // envoi de l'email contenant le lien de validation de compte.

                                        Utils::messageSuccess('Nous vous remercions de vous être enregistré, un email vous à été envoyé afin de valider votre compte !', 'login');
                                    } else {
                                        Utils::messageError('Une erreur c\'est produite lors de l\'enregistrement de votre compte, veuillez réssayer s\'il vous plait !', 'login');
                                    }
                                } else {
                                    Utils::messageError('Les mots de passe ne sont pas identique.', 'login');
                                }
                            } else {
                                Utils::messageError('Votre mot de passe doit contenir au moins 6 caractères !', 'login');
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
        } elseif (!empty($userId) && !empty($activ)) {
                $userId = (int) $userId;
            if ($userId != 0 && is_string($activ)) {
                $user = $this->userDAO->getUser($userId);
                if ($user->getStatus() === $activ) {
                    $this->userDAO->update($user->getId(), 'actif');
                    Utils::messageSuccess('Félicitation votre compte est actif, vous pouvez vous identifier !', 'login');
                }
            }
        } else {
            die('lol');
            $this->view->render('login');
        }



    }










}