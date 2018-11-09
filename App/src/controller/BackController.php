<?php
namespace App\src\controller;

use App\src\DAO\PostDAO;
use App\src\model\View;
use App\src\DAO\CommentDAO;
use App\Core\Utils;


class BackController
{
    private $view;
    private $postDAO;
    private $commentDAO;

    public function __construct()
    {
        $this->view = new View();
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();


    }

    public function getAdmin()
    {
        if (Utils::isAdmin()) {
            $posts = $this->postDAO->getAll(3);
            $this->view->render('admin', ['posts' => $posts]);
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
                    var_dump($message);
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








}