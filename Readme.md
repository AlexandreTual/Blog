**Projet Blog**

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/7402b90ba5a945abb2cf1ed766846380)](https://app.codacy.com/app/AlexandreTual/Blog?utm_source=github.com&utm_medium=referral&utm_content=AlexandreTual/Blog&utm_campaign=Badge_Grade_Dashboard)

Dans le cadre de la formation "Développeur d'application PHP / Symphony" 
j'ai réalisé un blog en PHP orienté objet.

Le projet est en PHP 7.2.

Mysql est utilisé pour ce projet.

J'ai utilisé l'IDE phpstorm.


**Pour installer le projet**

Pour cloner le projet  à partir du repository gitHub, utilisez la commande suivante dans le terminal de votre IDE, de linux, dans git bash etc.

`git clone https://github.com/AlexandreTual/Blog.git`

Si vous souhaitez le faire manuellement vous pouvez télécharger le dossier.zip et extraire les données directement sur votre ordinateur.

* Installez composer  https://getcomposer.org/download/
* Mettez à jour le projet en utilisant le composer.json et la commande suivante:
 `php composer.phar update`
 
Les librairies suivantes doivent avoir été installé par composer:
 * ckeditor
 * twig
 * twitter/bootstrap
 
 
Une fois le projet installé sur votre ordinateur, il faut créer la base de données:
 * Cherchez le fichier blog.sql situé dans le dossier sql
 * Importez-le dans phpmyadmin par exemple.
 (*Des données test sont insérés lors de la création*)
 
Mettez à jour les informations du fichier dev.php situé dans le dossier app/config, pour accéder a votre base de données.
 * votre identifiant 
 * votre mot de passe
 * le nom de votre base de données (*rien a faire si vous n'avez pas modifié le .sql*)
 
Pour utiliser les fonctionnalités de l'application qui envoient des mails il est nécessaire de configurer votre serveur wamp comme ceci:
 
https://www.copier-coller.com/envoyer-des-mails-en-local-avec-wamp/
 
Pour laragon, XAMPP,  EasyPHP ou Vagrant et j'en oublie, je vous laisse aller voir sur google.
 
La dernière étape consistera à modifier l'adresse mail situé dans le fichier AppController, situé dans app/src/controller à la ligne 17.
Remplacez-la par l'adresse mail sur laquelle vous souhaitez recevoir les mails de contact.
 
L'installation est finie vous pouvez utiliser le blog !!
 
 
 
 
 





 
