<?php

namespace app\src\controller;

use app\core\Utils;

class AppController extends Controller
{
    public function home()
    {
        $this->viewTwig->render('home.twig', []);
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

    public function addNewsletter($post)
    {
        if (isset($post['submit'])) {
            if (Utils::checkField(['email'], $post)) {
                if ((filter_var($post['email'], FILTER_VALIDATE_EMAIL))
                    && (!$this->userDAO->getNewsletter($post['email']))) {
                    $this->userDAO->addNewsletter($post['email']);
                    header('Location: index.php');
                } else {
                    header('Location: index.php');
                }
            } else {
                header('Location: index.php');
            }
        } else {
            header('Location: index.php');
        }
    }

    public function getAdmin()
    {
        if (Utils::isAdmin()) {
            $posts = $this->postDAO->getAll('all', null, true);
            $comments = $this->commentDAO->getComments('waiting');
            $users = $this->userDAO->getAllUser();
            $this->viewTwig->render('admin.twig', ['posts' => $posts, 'comments' => $comments, 'users' => $users]);
        } else {
            header('Location: index.php');
        }
    }



    public function maintenance()
    {
        $this->viewTwig->render('maintenance.twig', []);
    }
}