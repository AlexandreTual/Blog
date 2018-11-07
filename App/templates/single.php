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

<h1>Mon blog</h1>

<div>
    <h2><?= htmlspecialchars(ucfirst($post->getTitle()));?></h2>
    <h5><?= htmlspecialchars($post->getChapo());?></h5>
    <p><?= htmlspecialchars($post->getContent());?></p>
    <p><strong><?= htmlspecialchars(ucfirst($post->getAuthor()));?></strong></p>
    <p>Crée le : <?= htmlspecialchars($post->getDateAdded());?><br>
        Modifié le : <?= htmlspecialchars($post->getDateAmended()) ?></p>
</div>
<div>
    <h4>Commentaires</h4>
    <?php



    foreach ($comments as $comment)
    {
    ?>
        <p><strong><?= htmlspecialchars(ucfirst($comment->getUsername()));?></strong></p>
        <p><?=htmlspecialchars($comment->getContent());?></p>
        <p>Posté le : <?=htmlspecialchars($comment->getDateAdded());?><br>
        Modifié le :<?= htmlspecialchars($comment->getDateAmended())?><br><?php


    }
    ?>
</div>



