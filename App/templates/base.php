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
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">Navbar</a>
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
