<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/11/2018
 * Time: 13:14
 */

namespace app\src\controller;

use app\core\Utils;

class CommentController extends Controller
{
    public function getCommentList()
    {
        if (Utils::isAdmin()) {
            $comments = $this->commentDAO->getComments('waiting');
            $this->viewTwig->render('manage_comment.twig', ['comments' => $comments]);
        }
    }

    public function publishComment($idComment, $publish)
    {
        if (Utils::isAdmin()) {
            $this->commentDAO->update($idComment, null, $publish);
            $successM = 'Le commentaire vient d\'être publié';
            $message = Utils::messageAlert(true, $successM, null);
            Utils::addFlashBag('message', $message);
            header('Location: index.php?p=manage_comment');
        }
    }

    public function addComment(array $comment, int $idArt)
    {
        if (Utils::checkField(['content', 'author'], $comment)) {
            if (is_string($comment['content']) && is_string($comment['author'])) {
                // insertion des différentes variables dans la bdd
                $insert = $this->commentDAO->add($comment, $idArt);
                // message mis en cache pour lecture sur le template
                $successM = 'Le commentaire à bien été ajouté';
                $errorM = 'Une erreur c\'est produite lors de l\'ajout du commentaire';
                $message = Utils::messageAlert($insert, $successM, $errorM);
                Utils::addFlashBag('message', $message);
                header('Location: index.php?p=post&idArt=' . $idArt);
            }
        }
    }

    public function updateComment(int $idComment, int $idArt, array $commentPost)
    {
        if (Utils::isAdmin()) {
            /* on compare les id
             si pas de submit on appel le template pour modifier le commentaire*/
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
            } else {
                $comment = $this->commentDAO->getComment($idComment);
                $this->viewTwig->render('update_comment.twig', ['comment' => $comment]);
            }
        } else {
            // message mis en cache pour lecture sur le template
            $errorM = 'Vous n\'avez pas le droit de modifier ce commentaire.';
            $message = Utils::messageAlert(false, null, $errorM);
            Utils::addFlashBag('message', $message);
            header('Location: index.php?p=post&idArt=' . $idArt);
        }
    }

    public function deleteComment($idArt, $idComment)
    {
        if ((isset($idArt)) && (Utils::isUser() || Utils::isAdmin())) {
            // caster les variables pour être sur d'avoir des entiers.
            $idArt = (int)$idArt;
            $idComment = (int)$idComment;
            $comment = $this->commentDAO->getComment($idComment);
            // si le commentaire n'existe pas on redirige vers la page d'accueil
            // sinon on supprime lecommentaire et on redirige vers l'article.
            if (!$comment) {
                Utils::actionRefused();
            } else {
                $this->commentDAO->delete($idComment);
                $successM = 'Le commentaire à bien été supprimé';
                Utils::messageSuccess($successM, 'post&idArt=' . $idArt);
            }
        } elseif (!isset($idArt) && Utils::isAdmin()) {
            $this->commentDAO->delete($idComment);
            header('Location: index.php?p=manage_comment');
        }
    }
}