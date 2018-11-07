<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07/11/2018
 * Time: 00:03
 */

use App\HTML\BootstrapForm;
$form = new BootstrapForm($_POST);
?>
<h1>Modification de commentaire</h1>

<h3>votre commentaire</h3>

<p><?=htmlspecialchars($comment->getContent());?></p>
<p>Posté le : <?=htmlspecialchars($comment->getDateAdded());?><br>
    Modifié le :<?= htmlspecialchars($comment->getDateAmended())?><br>

<form action="index.php?p=update-comment&idArt=<?=$comment->getPostId()?>&idComment=<?=$comment->getId()?>" method="post">
    <?= $form->input('Contenu à modifier', 'content', ['type' => 'textarea'], true, htmlspecialchars($comment->getContent())) ?>
    <?= $form->submit('Soumettre')?>
</form>

