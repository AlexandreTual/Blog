<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:57
 */

namespace App\src\controller;

use App\Core\Utils;
use App\src\DAO\CommentDAO;
use \App\src\DAO\PostDAO;
use \App\src\model\View;
use App\src\DAO\UserDAO;

class FrontController
{
    private $view;
    private $postDAO;
    private $commentDAO;
    private $userDAO;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->view = new View();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
    }

    public function home()
    {
        $this->view->render('home');
    }

    public function getPostList()
    {
        $posts = $this->postDAO->getAll('waiting');
        $this->view->render('post_list', ['posts' => $posts]);
    }

    public function post($id)
    {
        $post = $this->postDAO->getPost($id);

        if ($post == null ) {
            Utils::postWaiting();
        } else {
            if ($post->getPublish() == 'published' || Utils::isAdmin()) {
                $comments = $this->commentDAO->getCommentFromPost($id);
                $this->view->render('single', [
                    'post' => $post,
                    'comments' => $comments
                ]);
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
                if($this->userDAO->getLogin($login['username'], $login['password'])) {

                    Utils::messageSuccess('Bienvenue '.ucfirst($_SESSION['username']). ' !','');
                    $successM = 'Bienvenue '.ucfirst($_SESSION['username']). ' !';
                    $message = Utils::messageAlert(true, $successM , null);
                    Utils::addFlashBag('message', $message);
                    header('Location: index.php');

                } else {
                    $errorM = 'Identifants incorrect ou compte inactif.';
                    $message = Utils::messageAlert(false, null , $errorM);
                    Utils::addFlashBag('message', $message);
                }
            }
            $this->view->render('login');
        } else {
            $errorM = ucfirst($_SESSION['username']).' vous êtes déjà connecté !';
            $message = Utils::messageAlert(false, null , $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php');
        }


    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
    }

    public function Comment($idComment)
    {
        $idComment = (int) $idComment;
        $comment = $this->commentDAO->getComment($idComment);
        return $comment;
    }

    public function addComment($comment, $idArt, $userId)
    {
        if (Utils::isUser()) {
            $idArt = (int) $idArt;
            // insertion des différentes variables dans la bdd
            $insert = $this->commentDAO->add($comment , $idArt, $userId);

            // message mis en cache pour lecture sur le template
            $successM = 'Le commentaire à bien été ajouté';
            $errorM = 'Une erreur c\'est produite lors de l\'ajout du commentaire';
            $message = Utils::messageAlert($insert, $successM, $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php?p=post&idArt='.$idArt);
        }
    }

    public function updateComment($idComment, $idArt, $commentPost)
    {
        if (Utils::isUser()) {
            // caster les variables pour être sur d'avoir des entiers.
            $idArt = (int)$idArt;
            $idComment = (int)$idComment;

            //récupération du commentaire pour comparer les userId
            $comment = $this->commentDAO->getComment($idComment);

            if (($_SESSION['userId'] === $comment->getUserId()) || Utils::isAdmin()) {

                /* on compare les id
                 si pas de submit on appel le template pour modifier le commentaire*/
                $this->view->render('update_comment', ['comment' => $comment]);

                if (isset($commentPost['submit'])) {

                    if (Utils::checkField(['content'], $commentPost)) {
                        // si présence du submit et du champ content on enregistre en bdd.
                        $update = $this->commentDAO->update($idComment, $commentPost);

                        // message en fonction de la réussite de $update, mis en cache pour lecture sur le template.
                        $sucessM = 'Le commentaire à bien été modifié';
                        $errorM = 'Un problème est survenu lors de la modification du commentaire.';
                        $message = Utils::messageAlert($update, $sucessM, $errorM);
                        Utils::addFlashBag('message', $message);
                        header('Location: index.php?p=post&idArt=' . $idArt);
                    }
                }
            } else {
                // message mis en cache pour lecture sur le template
                $errorM = 'Vous n\'avez pas le droit de modifier ce commentaire.';
                $message = Utils::messageAlert(false, null, $errorM);
                Utils::addFlashBag('message', $message);
                header('Location: index.php?p=post&idArt=' . $idArt);
            }
        }
    }

    public function deleteComment($idArt, $idComment)
    {
        if (Utils::isUser()) {

            if ((isset($idArt) && (isset($idComment))) || Utils::isAdmin() ){

                // caster les variables pour être sur d'avoir des entiers.
                $idArt = (int) $idArt;
                $idComment = (int) $idComment;

                /*récupération du commentaire , pour comparer les userid.
                si les id correspondent on supprime le commentaire.*/
                $comment = $this->commentDAO->getComment($idComment);
                // si le commentaire n'existe pas on redirige vers la page d'accueil
                if ($comment == null) {
                    Utils::actionRefused();

                } else {
                    if ($_SESSION['userId'] === $comment->getUserId() && $idArt != 0 ) {

                        $this->commentDAO->delete($idComment);
                        $successM = 'Le commentaire à bien été supprimé';
                        $message = Utils::messageAlert(true, $successM, null);
                        Utils::addFlashBag('message', $message);
                        header('Location: index.php?p=post&idArt='.$idArt);

                    } elseif (Utils::isAdmin()) {

                        $this->commentDAO->delete($idComment);
                        $successM = 'Le commentaire à bien été supprimé';
                        $message = Utils::messageAlert(true, $successM, null);
                        Utils::addFlashBag('message', $message);
                        header('Location: index.php?p=manage-comment');
                    }
                }
            } else {
                Utils::actionRefused();
            }

        } elseif (!isset($idArt) && Utils::isAdmin()) {
            $this->commentDAO->delete($idComment);
            header('Location: index.php?p=manage-comment');
        }
    }






}