<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:24
 */

session_start();
$this->title = 'Post';
?>
<h1>Mon blog</h1>
<div>
    <h2><?= htmlspecialchars($post->getTitle());?></h2>
    <h5><?= htmlspecialchars($post->getChapo());?></h5>
    <p><?= htmlspecialchars($post->getContent());?></p>
    <p><strong><?= htmlspecialchars($post->getAuthor());?></strong></p>
    <p>Crée le : <?= htmlspecialchars($post->getDateAdded());?><br>
        Modifié le : <?= htmlspecialchars($post->getDateAmended()) ?></p>
</div><br>
<div>
    <h4>Commentaire</h4>
    <?php
    foreach ($comments as $comment)
    {
    ?>
        <p><strong><?= htmlspecialchars($comment->getPseudo());?></strong></p>
        <p><?=htmlspecialchars($comment->getContent());?></p>
        <p>Posté le <?=htmlspecialchars($comment->getDateAdded());?><br>
        Modifié le <?= htmlspecialchars($comment->getDateAmended())?></p>
        <?php
    }
    ?>
</div>


