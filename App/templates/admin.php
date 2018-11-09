<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04/11/2018
 * Time: 20:53
 */
use App\Core\Utils;
Utils::echoFlashBag('message');
?>
<div class="text-center"><h1>Administration</h1></div>

    <p><a href="index.php?p=add-post" class="btn btn-primary">Ajouter un article</a></p>

<table class="table table-bordered">

    <thead>
    <tr>
        <th class="text-center" scope="col">Id</th>
        <th class="text-center" scope="col">Titre</th>
        <th class="text-center" scope="col">Auteur</th>
        <th class="text-center" scope="col">Date d'edition</th>
        <th class="text-center" scope="col">Dernière modification</th>
        <th class="text-center" scope="col">Publié</th>
        <th class="text-center" colspan="2" >Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post):?>
    <tr>
        <th scope="row"><?=$post->getId()?></th>
        <td><a href="index.php?p=post&idArt=<?=$post->getId()?>"><?=ucfirst($post->getTitle())?></a></td>
        <td><?=ucfirst($post->getAuthor())?></td>
        <td><?=$post->getDateAdded()?></td>
        <td><?=$post->getDateAmended()?></td>
        <td><?=$post->getPublish()?></td>
        <td>
            <a href="index.php?p=update-post&idArt=<?=$post->getId()?>" class="btn btn-outline-warning">Modifier</a>
            <a href="index.php?p=delete-post&idArt=<?=$post->getId()?>" class="btn btn-outline-danger" onclick="return(confirm('La suppression est définitive, êtes-vous sûr de vouloir continuer ?'));">Supprimer</a>
            <?php if ($post->getPublish() == 1) {
                ?>
                <a href="index.php?p=publish-post&idArt=<?=$post->getId()?>&publish=2" class="btn btn-outline-success">Publier Off</a></td>
                <?php
            } else {
                ?>
                <a href="index.php?p=publish-post&idArt=<?=$post->getId()?>&publish=1" class="btn btn-outline-success">Publier On</a></td>
                <?php
            }
            ?>



    </tr>
    </tbody>
    <?php endforeach;?>
</table>
