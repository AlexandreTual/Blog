<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:21
 */
\App\Core\Utils::echoFlashBag('message');
$this->title = 'PostsList';
?>
    <h1>Mon blog</h1>

        <?php
        foreach ($posts as $post) {
            ?>
            <div>
                <h2><a href="../public/index.php?p=post&idArt=<?= htmlspecialchars($post->getId());?>"><?= htmlspecialchars(ucfirst($post->getTitle())); ?></a></h2>
                <h5><?= $post->getChapo();?></h5>
                <a href="../public/index.php?p=post&idArt=<?= htmlspecialchars($post->getId());?>">lire l'article...</a>
                <p>Crée le : <?= htmlspecialchars($post->getDateAdded());?><br><?php

                    if (!empty($post->getDateAmended())) {
                        ?>
                        Modifié le : <?= htmlspecialchars($post->getDateAmended())?></p>
                        <?php
                    }
                    ?>
            </div>
            <br>
            <?php
        }
        ?>