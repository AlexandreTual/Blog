<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09/11/2018
 * Time: 22:47
 */
\App\Core\Utils::echoFlashBag('message');
?>

<div class="text-center"><h2>Gestionnaire des commentaires </h2></div><br>

<table class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center" scope="col">Id</th>
        <th class="text-center" scope="col">Content</th>
        <th class="text-center" scope="col">Auteur</th>
        <th class="text-center" scope="col">date de création</th>
        <th class="text-center" colspan="2" >Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($comments AS $comment):?>
        <tr>
            <th class="text-center"><?=$comment->getId()?></th>
            <th class="text-center"><?=$comment->getContent()?></th>
            <th class="text-center"><?=$comment->getUsername()?></th>
            <th class="text-center"><?=$comment->getDateAdded()?></th>

            <th><div class="dropdown text-center">
                    <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action sur le commentaire
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a href="index.php?p=publish-comment&&idComment=<?=$comment->getId()?>&publish=valid"
                           class="dropdown-item">Valider</a>
                        <a href="index.php?p=delete-comment&idComment=<?=$comment->getId()?>"
                           class="dropdown-item"
                           onclick="return(confirm('La suppression est définitive, êtes-vous sûr de vouloir continuer ?'));">
                            Supprimer</a></th>
                    </div>
            </div>
        </tr>
    <?php endforeach;?>
    </tbody>

</table>
