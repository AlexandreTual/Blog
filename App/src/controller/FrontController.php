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
        $posts = $this->postDAO->getAll();
        $this->view->render('post_list', ['posts' => $posts]);
    }

    public function post($id)
    {
        $post = $this->postDAO->getPost($id);
        $comments = $this->commentDAO->getCommentFromPost($id);
        $this->view->render('single', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function login($login)
    {
        /*si le champ submit est présent et que les champs username et password correspondent,
        on connecte l'utilisateur*/
        if (isset($login['submit'])) {
            if($this->userDAO->getLogin($login['username'], $login['password'])) {
                header('Location: index.php');
            } else {
                $errorM = 'Identifants incorrect';
                $message = Utils::messageAlert(false, null , $errorM);
                Utils::addFlashBag('message', $message);
            }
        }
        $this->view->render('login');
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

    public function deleteComment($idArt, $idComment, $idUser)
    {
        // caster les variables pour être sur d'avoir des entiers.
        $idArt = (int) $idArt;
        $idComment = (int) $idComment;
        $idUser = (int) $idUser;

        /*récupération du commentaire , pour comparer les userid.
        si les id correspondent on supprime le commentaire.*/
        $comment = $this->commentDAO->getComment($idComment);
        if (isset($idUser)) {
            if ($idUser === $comment->getUserId() OR $_SESSION['is_admin'] === 1) {
                $this->commentDAO->delete($idComment);

                // message mis en cache pour lecture sur le template
                $sucessM = 'Le commentaire à bien été supprimé';
                $errorM = 'Un problème est survenu lors de la suppression du commentaire.';
                $message = Utils::messageAlert(true, $sucessM, $errorM);
                Utils::addFlashBag('message', $message);
            } else {
                // message mis en cache pour lecture sur le template
                $errorM = 'Vous n\'avez pas le droit de supprimer ce commentaire.';
                $message = Utils::messageAlert(false , null, $errorM);
                Utils::addFlashBag('message', $message);
            }
        }
        header('Location: index.php?p=post&idArt='.$idArt);
    }

    public function updateComment($idArt, $idComment, $idUser, $commentPost)
    {
        // caster les variables pour être sur d'avoir des entiers.
        $idArt = (int) $idArt;
        $idComment = (int) $idComment;
        $idUser = (int) $idUser;


        //récupération du commentaire pour comparer les userId
        $comment = $this->commentDAO->getComment($idComment);

        if (($idUser === $comment->getUserId()) OR $_SESSION['is_admin'] === 1) {

            /* on compare les id
             si pas de submit on appel le template pour modifier le commentaire*/
            $this->view->render('update_comment', ['comment' => $comment]);

            if (isset($commentPost['submit'])) {
                // si présence du submit on enregistre en bdd.
                $update = $this->commentDAO->update($commentPost, $idComment);

                // message en fonction de la réussite de $update, mis en cache pour lecture sur le template.
                $sucessM = 'Le commentaire à bien été modifié';
                $errorM = 'Un problème est survenu lors de la modification du commentaire.';
                $message = Utils::messageAlert($update, $sucessM, $errorM);
                Utils::addFlashBag('message', $message);
                header('Location: index.php?p=post&idArt='.$idArt);
            }
        } else {
            // message mis en cache pour lecture sur le template
            $errorM = 'Vous n\'avez pas le droit de modifier ce commentaire.';
            $message = Utils::messageAlert(false, null, $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php?p=post&idArt='.$idArt);
        }
    }

}