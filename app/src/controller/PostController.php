<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/11/2018
 * Time: 13:14
 */

namespace app\src\controller;

use app\core\Utils;

class PostController extends Controller
{
    public function addPost($post)
    {
        if (Utils::isAdmin()) {
            if (isset($post['submit'])) {
                if (Utils::checkField(['title', 'chapo', 'content', 'category'], $post)) {
                    $post = $this->postDAO->add($post, $_SESSION['userId']);
                    $successM = 'Votre nouvel article à bien été créé !';
                    $message = Utils::messageAlert(true, $successM, null);
                    Utils::addFlashBag('message', $message);
                    header('Location: index.php?p=post&idArt=' . $post);
                } else {
                    $errorM = 'Veuillez définir tout les champs du formulaire !';
                    $message = Utils::messageAlert(false, null, $errorM);
                    Utils::addFlashBag('message', $message);
                }
            }
            $category = $this->categoryDAO->getCategory();
            $this->viewTwig->render('add_post.twig', ['category' => $category]);
        }
    }

    public function updatePost($postId, $post = null, $publish = null)
    {
        if (Utils::isAdmin()) {
            if ((isset($post['submit'])) || isset($publish)) {
                // on vérifie que tout les champs du formulaire sont présent et non vide.
                if (Utils::checkField(['title', 'chapo', 'content', 'category'], $post) || isset($publish)) {
                    // si la variable publish est présente
                    if (isset($publish)) {
                        //  on la modifie en fonction du parametre passé
                        $this->postDAO->update($postId, null, $publish);
                        header('Location: index.php?p=admin');
                    } else {
                        // si publish n'est pas présent on modifie le contenu de l'article
                        $this->postDAO->update($postId, $post);
                        header('Location: index.php?p=post&idArt=' . $postId);
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
            $post = $this->postDAO->getPost($postId);
            $category = $this->categoryDAO->getCategory();
            $this->viewTwig->render('update_post.twig', ['post' => $post,
                'category' => $category
            ]);
        }
    }

    public function deletePost(int $postId)
    {
        if (Utils::isAdmin()) {
            if (isset($postId)) {
                $post = $this->postDAO->delete($postId);
                $errorM = 'L\'article n\'a pu être supprimé !';
                $successM = 'L\'article à été supprimé !';
                $message = Utils::messageAlert($post, $successM, $errorM);
                Utils::addFlashBag('message', $message);
                header('Location: index.php?p=admin');
            }
        }
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
        if (false === $post = $this->postDAO->getPost($postId)) {
            Utils::postWaiting();
        }

        if ($post->getPublish() !== 'published' && false === Utils::isAdmin()) {
            return;
        }

        $comments = $this->commentDAO->getCommentFromPost($postId);

        $this->viewTwig->render('single.twig', [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}