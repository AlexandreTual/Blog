<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:57
 */

namespace app\src\controller;
use app\core\Utils;

class FrontController extends Controller
{
    public function home()
    {
        $this->viewTwig->render('home.twig', []);
    }

    public function getPostList($category)
    {
        $posts = $this->postDAO->getAll('waiting', $category);
        $message = '';

        if (!$posts) {
            $message = 'Pas d\'article disponible pour le moment dans cette catégorie !<br> 
            N\'hésitez pas à découvrir nos autres catégories !';
        }
        $this->viewTwig->render('post_list.twig', ['posts' => $posts, 'message' => $message]);
    }

    public function post($postId)
    {
        $post = $this->postDAO->getPost($postId);
        if (!$post) {
            Utils::postWaiting();
        } else {
            if ($post->getPublish() == 'published' || Utils::isAdmin()) {
                $comments = $this->commentDAO->getCommentFromPost($postId);
                $this->viewTwig->render('single.twig', [
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

    public function addComment($comment, $idArt)
    {
        if (Utils::checkField(['content', 'author'], $comment)) {
            $idArt = (int)$idArt;
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

    public function updateComment($idComment, $idArt, $commentPost)
    {
        // caster les variables pour être sur d'avoir des entiers.
        $idArt = (int)$idArt;
        $idComment = (int)$idComment;
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
        if ((isset($idArt)) && Utils::isAdmin()) {
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

    public function senderMail($post)
    {
        if(Utils::checkField(['firstname', 'lastname', 'content', 'email'], $post)) {
            Utils::sendMail('contact', 'tual.alexandre@gmail.com', $post);
            Utils::messageSuccess('Votre message vient d\'être envoyé, vous serez contacté prochainement.','home' );
        } else {
            Utils::messageError('Veuillez remplir tout les champs pour envoyer votre message', 'home');
        }
    }

}