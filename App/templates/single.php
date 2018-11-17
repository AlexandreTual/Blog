<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:24
 */

use App\Core\Utils;
use App\HTML\BootstrapForm;

$this->title = 'Post';
Utils::echoFlashBag('message');
$form = new BootstrapForm($_POST);
?>
<div class="text-center"><h1><?= htmlspecialchars(ucfirst($post->getTitle())); ?></h1><br></div>

<div>
    <h5><?= $post->getChapo(); ?></h5>
    <p><em>Catégorie: <?=ucfirst($post->getCategory())?></em></p>
    <p><?= $post->getContent(); ?></p>
    <p><strong><?= htmlspecialchars(ucfirst($post->getAuthor())); ?></strong></p>
    <p>Crée le : <?= htmlspecialchars($post->getDateAdded()); ?><br><?php
        if (!empty($post->getDateAmended())) {
        ?>
        Modifié le : <?= htmlspecialchars($post->getDateAmended()) ?></p>
    <?php
    }
    ?>
</div>
<div class="col-sm-4">
    <h4>Commentaires</h4>
    <form action="index.php?p=add-comment&idArt=<?=$post->getId()?>" method="post">
        <?= $form->input('Nouveau commentaire', 'content', ['type' => 'textarea']); ?>
        <?= $form->input('Nom', 'username', ['type' => 'text']); ?>
        <?= $form->submit('Soumettre', 'btn-secondary'); ?>
    </form>
</div>
<div class="col-sm-4">
    <?php
    foreach ($comments as $comment) { ?>
        <div class="row p-3 mb-2 border border-secondary rounded">
            <p class="col-sm-12"><strong><?= htmlspecialchars(ucfirst($comment->getUsername())); ?></strong></p>
            <p class="col-sm-12"><?= htmlspecialchars(ucfirst($comment->getContent())); ?></p>
            <p class="col-sm-12">Posté le : <?= htmlspecialchars($comment->getDateAdded()); ?><br><?php
                if (!empty($comment->getDateAmended())) {
                ?>
                Modifié le : <?= htmlspecialchars($comment->getDateAmended()) ?></p>
            <?php
            }
            if (isset($_SESSION['quality']) && $_SESSION['quality'] == true) { ?>
                <a href="index.php?p=delete-comment&idArt=<?=$comment->getPostId()?>&idComment=<?= $comment->getId() ?>">Supprimer</a>
                <a href="index.php?p=update-comment&idArt=<?=$comment->getPostId()?>&idComment=<?= $comment->getId() ?>">Modifier</a></p>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
