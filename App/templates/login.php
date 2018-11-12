<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 22:50
 */

use \App\HTML\BootstrapForm;
use App\Core\Utils;
$form = new BootstrapForm($_POST);
Utils::echoFlashBag('message');
?>
<div class="row ">
    <div class="col-sm-5">
        <h2 class="text-center">Authentification</h2><br>
        <form action="../public/index.php?p=login" method="post">
            <?= $form->input('Utilisateur', 'username')?>
            <?= $form->input('Mot de passe', 'password', ['type' => 'password'])?>
            <?= $form->submit('Valider')?>
        </form>
    </div>
    <div class="offset-sm-2 col-sm-5">
        <h2 class="text-center">Inscription</h2><br>
        <form action="../public/index.php?p=registration" method="post">
            <?= $form->input('Utilisateur', 'username')?>
            <?= $form->input('Email', 'email')?>
            <?= $form->input('Mot de passe', 'password', ['type' => 'password'])?>
            <?= $form->input('Vérification du mot de passe', 'password2', ['type' => 'password'])?>
            <?= $form->submit('Valider')?>
        </form>
    </div>
</div>


