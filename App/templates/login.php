<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 22:50
 */

use App\Core\Utils;
use App\HTML\BootstrapForm;

$form = new BootstrapForm($_POST);
Utils::echoFlashBag('message');
?>
<div class="row ">
    <div class="col-sm-5">
        <h2 class="text-center">Authentification</h2><br>
        <form action="../public/index.php?p=login" method="post">
            <?= $form->input('Utilisateur', 'username') ?>
            <?= $form->input('Mot de passe', 'password', ['type' => 'password']) ?>
            <div class="form-inline">
                <?= $form->submit('Valider', 'btn-primary') ?>
                <a href="index.php?p=update-password" class="ml-5">Mot de passe oublié ?</a>
            </div>

        </form>
    </div>
    <div class="offset-sm-2 col-sm-5">
        <h2 class="text-center">Inscription</h2><br>
        <form action="../public/index.php?p=registration" method="post" novalidate>
            <?= $form->input('Utilisateur', 'username') ?>
            <?= $form->input('Email', 'email') ?>
            <?= $form->input('Mot de passe', 'password', ['type' => 'password']) ?>
            <?= $form->input('Vérification du mot de passe', 'password2', ['type' => 'password']) ?>
            <?= $form->submit('Valider', 'btn-primary') ?>
        </form>
    </div>
</div>




