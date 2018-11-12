<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07/11/2018
 * Time: 15:56
 */

use App\HTML\BootstrapForm;
use App\Core\Utils;
$form = new BootstrapForm($_POST);
Utils::echoFlashBag('message');
?>

<div class="text-center"><h1>Modification d'un article</h1></div>

<form action="index.php?p=update-post&idArt=<?=$post->getId()?>" method="post">
    <?=$form->input('Titre', 'title', ['type' => 'text'], true, $post->getTitle(), true)?>
    <?=$form->input('Chapô', 'chapo', ['type' => 'textarea'],true, $post->getChapo(), true, null, null, 'chapoPost')?>
    <?=$form->input('Contenu de l\'article', 'content', ['type' => 'textarea'], true, $post->getContent(),true,7, null, 'contentPost')?>
    <?=$form->input('Auteur', 'author', ['type' => 'text'],true, $post->getAuthor(), true)?>
    <?=$form->submit('Valider')?>
</form>