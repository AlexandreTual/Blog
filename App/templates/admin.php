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
<div>
   <p><a href="index.php?p=add-post" class="btn btn-primary">Ajouter un article</a>
       <?php if (!empty($comments)) {
       echo '<a href="index.php?p=manage-comment" class="btn btn-danger">Gestion des commentaires</a></p>';
       } ?>

</div>


<table class="table table-bordered">

    <thead>
    <tr>
        <th class="text-center" scope="col">Id</th>
        <th class="text-center" scope="col">Titre</th>
        <th class="text-center" scope="col">Auteur</th>
        <th class="text-center" scope="col">Date d'edition</th>
        <th class="text-center" scope="col">Dernière modification</th>
        <th class="text-center" scope="col">Publié</th>
        <th class="text-center" scope="col">Commentaires</th>
        <th class="text-center" colspan="2" >Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post):?>

    <tr>
        <th scope="row"><?=$post->getId()?></th>
        <td><a href="index.php?p=post&idArt=<?=$post->getId()?>"><?=ucfirst($post->getTitle())?></a></td>
        <td class="text-xl-center"><?=ucfirst($post->getAuthor())?></td>
        <td class="text-xl-center"><?=$post->getDateAdded()?></td>
        <td class="text-xl-center"><?=$post->getDateAmended()?></td>
        <td class="text-xl-center"><?=$post->getPublish()?></td>
        <td class="text-xl-center"><?=$post->getCommentsStatusNumber()?></td>
        <td

            <div class="dropdown">
                <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action sur l'article
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                        <a href="index.php?p=update-post&idArt=<?=$post->getId()?>" class="dropdown-item">Modifier</a>
                        <a href="index.php?p=delete-post&idArt=<?=$post->getId()?>" class="dropdown-item" onclick="return(confirm('La suppression est définitive, êtes-vous sûr de vouloir continuer ?'));">Supprimer</a>
                        <?php if ($post->getPublish() == 1) {
                            ?>
                            <a href="index.php?p=publish-post&idArt=<?=$post->getId()?>&publish=Waiting" class="dropdown-item">Publier Off</a>
                            <?php
                        } else {
                            ?>
                            <a href="index.php?p=publish-post&idArt=<?=$post->getId()?>&publish=published" class="dropdown-item">Publier On</a></td>
                            <?php
                        }
                        ?>
                </div>
            </div>
    </tr>
    <?php endforeach;?>
    </tbody>

</table>


