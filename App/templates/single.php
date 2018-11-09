<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:24
 */
use App\HTML\BootstrapForm;
use App\Core\Utils;

$this->title = 'Post';
Utils::echoFlashBag('message');
?>

<div class="text-center"><h1>Article</h1></div>

<div>
    <h2><?= htmlspecialchars(ucfirst($post->getTitle()));?></h2>
    <h5><?= htmlspecialchars($post->getChapo());?></h5>
    <p><?= htmlspecialchars($post->getContent());?></p>
    <p><strong><?= htmlspecialchars(ucfirst($post->getAuthor()));?></strong></p>
    <p>Crée le : <?= htmlspecialchars($post->getDateAdded());?><br><?php
        if (!empty($post->getDateAmended())) {
        ?>
        Modifié le : <?= htmlspecialchars($post->getDateAmended())?></p>
        <?php
        }
        ?>
</div>
<div>
    <h4>Commentaires</h4>
    <?php
    if (isset($_SESSION['userId']) && (is_int($_SESSION['userId']) > 0)) {
        $form = new BootstrapForm($_POST);
        ?>
        <form action="index.php?p=add-comment&idArt=<?=$post->getId()?>" method="post">
            <?=$form->input('Nouveau commentaire', 'content', ['type' => 'textarea']);?>
            <?=$form->submit('Soumettre');?>
        </form>
        <?php
    }


    foreach ($comments as $comment)
    {
    ?>
        <p><strong><?= htmlspecialchars(ucfirst($comment->getUsername()));?></strong></p>
        <p><?=htmlspecialchars(ucfirst($comment->getContent()));?></p>
        <p>Posté le : <?=htmlspecialchars($comment->getDateAdded());?><br><?php
            if (!empty($comment->getDateAmended())) {
            ?>
            Modifié le : <?= htmlspecialchars($comment->getDateAmended())?></p>
            <?php
                    }

        if(isset($_SESSION['userId']) && (( $_SESSION['userId'] === $comment->getUserId()) OR $_SESSION['is_admin'] === 1)) {?>
            <a href="index.php?p=delete-comment&idArt=<?=$comment->getPostId()?>&idComment=<?=$comment->getId()?>">Supprimer</a>
            <a href="index.php?p=update-comment&idArt=<?=$comment->getPostId()?>&idComment=<?=$comment->getId()?>">Modifier</a></p>
            <?php
        }

    }
    ?>
</div>



