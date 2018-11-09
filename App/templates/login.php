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
<div class="text-center"><h1>Authentification</h1></div>

<form action="../public/index.php?p=login" method="post">
        <?= $form->input('Utilisateur', 'username')?>
        <?= $form->input('Mot de passe', 'password', ['type' => 'password'])?>
        <?= $form->submit('Valider')?>
</form>
<a href="../public/index.php">page d'accueil</a>
