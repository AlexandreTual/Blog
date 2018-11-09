<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:18
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title><?= $title ?></title>

<!-- Bootstrap core CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js">
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">home</a>
    <a class="navbar-brand" href="index.php?p=post-list">blog</a><?php
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
        echo '<a class="navbar-brand" href="index.php?p=admin">Administration</a><br>';
    }?>
    <div class="navbar-form navbar-right inline-form">

        <?php if (isset($_SESSION['userId'])) {
            echo '<a href="index.php?p=logout" class="btn btn-outline-danger my-2 my-sm-0" >Deconnexion</a>';
        } else {
            echo '<a href="../public/index.php?p=login" class="btn btn-outline-success my-2 my-sm-0">Se connecter</a>';
        }
        ?>
    </div>

</nav>

<div id="content" class="container" style="padding-top: 100px;">
    <?= $content ?>
</div>

</body>
</html>
