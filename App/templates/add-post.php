<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07/11/2018
 * Time: 12:15
 */

use App\HTML\BootstrapForm;
use App\Core\Utils;
$form = new BootstrapForm($_POST);
Utils::echoFlashBag('message');
?>

<div class="text-center"><h1>Création d'un nouvel article</h1></div>

<form action="index.php?p=add-post" method="post" novalidate>
    <?=$form->input('Titre', 'title', ['type' => 'text'],false, null, true)?>
    <?=$form->input('Chapô', 'chapo', ['type' => 'textarea'],false, null, true, null, null, 'chapoPost')?>
    <?=$form->input('Contenu de l\'article', 'content', ['type' => 'textarea'],false, null, true, 7, null, 'contentPost')?>
    <?=$form->input('Auteur', 'author', ['type' => 'text'],false, null, true)?>
    <?=$form->submit('Valider')?>
</form>

