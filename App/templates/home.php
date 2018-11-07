<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 23:31
 */
$this->title = 'Page d\'accueil';
if(!empty($message)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <?= $message ?>
    </div>
    <?php
}
?>

<h1>Page d'accueil</h1>

<a href="index.php?p=post-list">Blog</a><br>




