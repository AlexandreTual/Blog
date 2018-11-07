<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04/11/2018
 * Time: 20:53
 */
?>
<h1>Administration</h1>

<table class="table table-bordered">

    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Titre</th>
        <th scope="col">Auteur</th>
        <th scope="col">Date d'edition</th>
        <th scope="col">Dernière modification</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post):?>
    <tr>
        <th scope="row"><?=$post->getId()?></th>
        <td><?=$post->getTitle()?></td>
        <td><?=$post->getAuthor()?></td>
        <td><?=$post->getDateAdded()?></td>
        <td><?=$post->getDateAmended()?></td>
    </tr>
    </tbody>
    <?php endforeach;?>
</table>
