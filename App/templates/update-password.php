<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15/11/2018
 * Time: 23:54
 */
$form = new \App\HTML\BootstrapForm($_POST);
\App\Core\Utils::echoFlashBag('message');
if (isset($_GET['userId']) && isset($_GET['key'])) {
    $_SESSION['userId'] = $_GET['userId'];
    $_SESSION['key'] = $_GET['key'];
    ?>
    <div class="text-center">
        <div class="offset-lg-4 col-lg-4">
            <form class="form-signin" action="index.php?p=update-password" method="post">
                <h1 class="h3 mb-3 font-weight-normal">Nouveau mot de passe</h1>
                <div class="my-auto">
                    <?=$form->input(null, 'password', ['type' => 'password'], null, null, 'required')?>
                    <?=$form->input('Saisissez un mot de passe indentique', 'password2', ['type' => 'password'], null, null, 'required')?>
                    <?= $form->submit('Valider le mot de passe', 'btn-primary btn-block')?>
                </div>
            </form>
        </div>
    </div>
<?php
} else {
    ?>
    <div class="text-center">
        <div class="offset-lg-4 col-lg-4">
            <form class="form-signin" action="index.php?p=update-password" method="post">
                <h1 class="h3 mb-3 font-weight-normal">Entrez votre adresse mail</h1>
                <?=$form->input(null, 'email', ['type' => 'text'], null, null,
                    'required', null, null, null, 'votre adresse mail')?>
                <?= $form->submit('Réinitialiser votre mot de passe', 'btn-primary btn-block')?>
            </form>
        </div>
    </div>
    <?php
}
?>



