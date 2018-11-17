<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 14/11/2018
 * Time: 11:43
 */
use App\Core\Utils;
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="navbar-brand" href="index.php?p=post-list">blog</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Catégories</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a href="index.php?p=category&category=1" class="dropdown-item">Actualité</a>
                    <a href="index.php?p=category&category=2" class="dropdown-item">Tutoriel</a>
                    <a href="index.php?p=category&category=3" class="dropdown-item">Culture</a>
                </div>
            </li>
        <?php if (isset($_SESSION['quality'])) {?>
            <li class="nav-item dropdown float-right">
                <a class="nav-link dropdown-toggle" href="" id="dropdown01"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon Compte</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01"><?php
                    if (isset($_SESSION['quality']) && $_SESSION['quality'] === 'admin') {
                        echo '<a class="dropdown-item" href="index.php?p=admin">Administration</a>';
                    } ?>
                    <a href="index.php?p=logout" class="dropdown-item btn btn-outline-danger">Deconnexion</a>
                </div>
            </li>
        <?php } else {
            echo '<a href="../public/index.php?p=login" class="btn btn-outline-success">Se connecter</a>';
        } ?>
        </ul>
    </div>
</nav>

