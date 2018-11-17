<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 23:31
 */

use App\Core\Utils;

Utils::echoFlashBag('message');
$this->title = 'Page d\'accueil';
$form = new \App\HTML\BootstrapForm($_POST);
//die(var_dump($_SESSION));
?>
<div class="row mb-5">
    <div class="col-sm-6">
        <img src="../public/img/stromtrooper.jpg" alt="stroomtroper" class="rounded-circle">
    </div>
    <div class="col-sm-6">
        <h2>Alexandre TUAL</h2><br>
        <strong>Développeur PHP / Symphony</strong><br>
        <blockquote>
            <p><em>Ayant connu diverse expériences professionnelle, mon parcours atypique apportera un plus dans vos projets...</em></p>
        </blockquote>
        <br>
        <p><pre>
            <strong><span style="font-size:14px"><span style="color:#f92672">public static function </span><span style="color:#009900">getBrain</span>(<em>$brain</em>)
            {
                <span style="color:#f92672">if </span>(<span style="color:#f92672">isset</span>(<em>$brain</em>)) {
                    <span style="color:#f92672">echo </span><span style="color:#f39c12">&#39;On va y arriver !&#39;</span>;
                } <span style="color:#f92672">else </span>{
                    <span style="color:#f92672">echo </span><span style="color:#f39c12">&#39;Cela risque d\'&ecirc;tre un peu plus long&#39;</span>;
                }
            }</span></strong>
        </pre></p>
    </div>
</div>
<div class="row mt-5">
    <div class="col-lg-6">
        <div class="row">
            <div class="text-center col-lg-12 mb-4"><h4>Vous avez un projet ou souhaitez me contacter ?</h4></div>
        </div>
        <div class="col-lg-12">
            <form action="index.php?p=contact"method="post">
                <div class="row">
                    <div class="col-lg-6"><?= $form->input('Votre nom', 'firstname', ['type' => 'text'],null,null, true) ?></div>
                    <div class="col-lg-6"><?= $form->input('Votre prénom', 'lastname', ['type' => 'text'], null,null, true) ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?= $form->input('Votre message', 'content', ['type' => 'textarea'],null,null, true) ?>
                    </div>
                </div>
                <div class="row align-items-end">
                    <div class="col-lg-8"><?= $form->input('Votre email', 'email',['type' => 'text'],null,null, true) ?></div>
                    <div class="col-lg-4"><?= $form->submit('Envoyer', 'btn-outline-success btn-block')?></div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row justify-content-center">
            <div class="text-center mb-4">
                <h4>Réseaux sociaux </h4>
                <p><em>Si souhaitez me suivre ou simplement jeter un oeil à mes profils</em></p>
            </div>
        </div>
        <div class="row justify-content-center">
            <script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
            <script type="IN/MemberProfile" data-id="http://www.linkedin.com/in/alexandre-tual-277b37162"
                    data-format="inline" data-related="false"></script>
        </div>
         <div class="row mt-4 justify-content-center">
             <div class="mr-3">
                 <a href="https://github.com/AlexandreTual">
                     <img src="../public/img/Github.png" alt="logo github"></a>
             </div>
             <div class="ml-5">
                 <a href="https://twitter.com/AlexandreTual?ref_src=twsrc%5Etfw">
                     <img src="../public/img/Twitter.png" alt="Logo Twitter" class="mr-3"></a>
             </div>

        </div>
    </div>
</div>


