<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 23:31
 */
use App\Core\Utils;
$this->title = 'Page d\'accueil';
Utils::echoFlashBag('message');
?>

<h1>Page d'accueil</h1>

<a href="index.php?p=post-list">Blog</a><br>
