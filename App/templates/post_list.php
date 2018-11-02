<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:21
 */

session_start();
$this->title = 'PostsList';
?>
    <h1>Mon blog</h1>

        <?php
        foreach ($posts as $post) {
            ?>
            <div>
                <h2><a href="../public/index.php?p=post&idArt=<?= htmlspecialchars($post->getId());?>"><?= htmlspecialchars(ucfirst($post->getTitle())); ?></a></h2>
                <p><?= htmlspecialchars($post->getContent());?></p>
                <p><strong><?= htmlspecialchars(ucfirst($post->getAuthor()));?></strong></p>
                <p>Crée le : <?= htmlspecialchars($post->getDateAdded());?><br>
                    Modifié le : <?= htmlspecialchars($post->getDateAmended())?></p>
            </div>
            <br>
            <?php
        }
        ?>