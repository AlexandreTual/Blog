<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04/11/2018
 * Time: 20:53
 */

use App\Core\Utils;

Utils::echoFlashBag('message');
$form = new \App\HTML\BootstrapForm($_POST);
?>
<div class="text-center mb-3"><h1>Administration</h1></div>
<div class="mb-4"><h3>Gestion des articles</h3></div>
<div class="row ">
    <div class="mr-2">
        <p><a href="index.php?p=add-post" class="btn btn-primary">Ajouter un article</a>
            <?php if (!empty($comments)) {
            echo '<a href="index.php?p=manage-comment" class="btn btn-danger mr-3">Gestion des commentaires</a></p>';
        }?>
    </div>
    <div class="ml-2">
        <form action="index.php?p=add-category" method="post" class="form-inline">
            <div class="mr-2">
            <?=$form->input(null, 'name', ['type' => 'text'], null,null,
                null,null, null, null, 'Nouvelle catégorie ?')?>
            </div>
            <div class="input-group-append">
                <?=$form->submit('Créer', 'btn-success')?>
            </div>
        </form>

    </div>
</div>
<div class="row">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center" scope="col">Id</th>
            <th class="text-center" scope="col">Titre</th>
            <th class="text-center" scope="col">Auteur</th>
            <th class="text-center" scope="col">Date d'edition</th>
            <th class="text-center" scope="col">Dernière modification</th>
            <th class="text-center" scope="col">Catégories</th>
            <th class="text-center" scope="col">Publié</th>
            <th class="text-center" scope="col">Commentaires</th>
            <th class="text-center" colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td scope="row"><?= $post->getId() ?></td>
                <td><a href="index.php?p=post&idArt=<?= $post->getId() ?>"><?= ucfirst($post->getTitle()) ?></a></td>
                <td class="text-xl-center"><?= ucfirst($post->getAuthor()) ?></td>
                <td class="text-xl-center"><?= $post->getDateAdded() ?></td>
                <td class="text-xl-center"><?= $post->getDateAmended() ?></td>
                <td class="text-xl-center"><?= ucfirst($post->getCategory()) ?></td>
                <td class="text-xl-center"><?= $post->getPublish() ?></td>
                <td class="text-xl-center"><?= $post->getCommentsStatusNumber() ?></td>
                <td

                <div class="dropdown">
                    <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action sur l'article
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                        <a href="index.php?p=update-post&idArt=<?= $post->getId() ?>" class="dropdown-item">Modifier</a>
                        <a href="index.php?p=delete-post&idArt=<?= $post->getId() ?>" class="dropdown-item"
                           onclick="return(confirm('La suppression est définitive, êtes-vous sûr de vouloir continuer ?'));">Supprimer</a>
                        <?php if ($post->getPublish() == "published") {
                            ?>
                            <a href="index.php?p=publish-post&idArt=<?= $post->getId() ?>&publish=Waiting"
                               class="dropdown-item">Publier Off</a>
                            <?php
                        } else {
                            ?>
                            <a href="index.php?p=publish-post&idArt=<?= $post->getId() ?>&publish=published"
                               class="dropdown-item">Publier On</a></td>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<div class="row">
    <div class="my-4 col-lg-12"><h3>Gestion des utilisateurs</h3></div>
    <table class="table table-bordered col-lg-6">
        <thead>
        <tr>
            <th class="text-center" scope="col">Id</th>
            <th class="text-center" scope="col">nom</th>
            <th class="text-center" scope="col">Qualité</th>
            <th class="text-center" scope="col">Status</th>
            <th class="text-center" scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user):?>
        <tr>
            <td class="text-xl-center"><?=$user->getId()?></td>
            <td class="text-xl-center"><?=ucfirst($user->getUsername())?></td>
            <td class="text-xl-center"><?=$user->getquality()?></td>
            <td class="text-xl-center"><?php if ($user->getStatus()) {
                                                echo 'actif';
                                            } else {
                                                echo 'inactif';
                                            } ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action sur l'utilisateur
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php if (!$user->getStatus()):?>
                            <a class="dropdown-item" href="index.php?p=update-user-status&userId=<?= $user->getId()?>&status=1">
                                Activer compte</a>
                         <?php else:?>
                            <a class="dropdown-item" href="index.php?p=update-user-status&userId=<?= $user->getId()?>&status=0">
                                Désactiver compte</a>
                        <?php endif;?>
                        <?php if ('admin' === $user->getquality()):?>
                            <a class="dropdown-item" href="index.php?p=update-user-quality&userId=<?=$user->getId()?>&quality=user">
                                Utilisateur</a>
                        <?php else:?>
                            <a class="dropdown-item" href="index.php?p=update-user-quality&userId=<?=$user->getId()?>&quality=admin">
                                Administrateur</a>
                        <?php endif;?>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

