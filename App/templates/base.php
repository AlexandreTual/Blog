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
    <link href="../../vendor/twitter/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'include/nav.php';?>
<div id="content" class="container" style="padding-top: 100px;">
    <?= $content ?>
</div>

<script src="../../vendor/components/jquery/jquery.min.js"></script>
<script src="../../vendor/twitter/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../vendor/ckeditor/ckeditor/ckeditor.js"></script>
<script src="../public/js/test.js"></script>

<script>CKEDITOR.replace('chapoPost');</script>
<script>CKEDITOR.replace('contentPost');</script>

<?php include 'include/footer.php';?>
</body>
</html>
