-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 27 nov. 2018 à 20:16
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `monblog`;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'actualité'),
(3, 'culture'),
(4, 'sport'),
(7, 'développement web');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date_added` datetime NOT NULL,
  `publish` varchar(10) DEFAULT 'waiting',
  `post_id` int(11) DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment___f` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `date_added`, `publish`, `post_id`, `author`) VALUES
(132, 'Bonjour à tous !!', '2018-11-23 23:08:48', 'valid', 33, 'demo'),
(133, 'Je suis un commentaire !!', '2018-11-23 23:09:22', 'valid', 33, 'Alex'),
(134, 'J\'aime bien les zombies avec du ketchup !!', '2018-11-23 23:09:50', 'valid', 33, 'Carlos'),
(135, 'Je suis un article !!', '2018-11-26 10:58:40', 'valid', 33, 'demo'),
(136, 'Je m\'appelle Morgan !!!', '2018-11-26 11:14:00', 'valid', 33, 'Morgan');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_email_uindex` (`email`),
  UNIQUE KEY `newsletter_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_amended` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `publish` varchar(20) DEFAULT 'waiting',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts___fk` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `chapo`, `content`, `date_added`, `date_amended`, `category_id`, `publish`, `user_id`) VALUES
(33, 'Ceci est un article qui fait peur !! ', '<p>Nous vous parlerons de <em>zombie</em> dans une langue mort....</p>\r\n', '<div id=\"brains\">\r\n<div id=\"lipsum\" style=\"display:block\">\r\n<p>Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel maleficia? De apocalypsi gorger omero undead survivor dictum mauris. Hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. Qui animated corpse, cricket bat max brucks terribilem incessu zomby. The voodoo sacerdos flesh eater, suscitat mortuos comedere carnem virus. Zonbi tattered for solum oculi eorum defunctis go lum cerebro. Nescio brains an Undead zombies. Sicut malus putrid voodoo horror. Nigh tofth eliv ingdead.</p>\r\n\r\n<p>Cum horribilem walking dead resurgere de crazed sepulcris creaturis, zombie sicut de grave feeding iride et serpens. Pestilentia, shaun ofthe dead scythe animated corpses ipsa screams. Pestilentia est plague haec decaying ambulabat mortuos. Sicut zeder apathetic malus voodoo. Aenean a dolor plan et terror soulless vulnerum contagium accedunt, mortui iam vivam unlife. Qui tardius moveri, brid eof reanimator sed in magna copia sint terribiles undeath legionis. Alii missing oculis aliorum sicut serpere crabs nostram. Putridi braindead odores kill and infect, aere implent left four dead.</p>\r\n\r\n<p>Lucio fulci tremor est dark vivos magna. Expansis creepy arm yof darkness ulnis witchcraft missing carnem armis Kirkman Moore and Adlard caeruleum in locis. Romero morbo Congress amarus in auras. Nihil horum sagittis tincidunt, zombie slack-jawed gelida survival portenta. The unleashed virus est, et iam zombie mortui ambulabunt super terram. Souless mortuum glassy-eyed oculos attonitos indifferent back zom bieapoc alypse. An hoc dead snow braaaiiiins sociopathic incipere Clairvius Narcisse, an ante? Is bello mundi z?</p>\r\n\r\n<p>In Craven omni memoria patriae zombieland clairvius narcisse religionis sunt diri undead historiarum. Golums, zombies unrelenting et Raimi fascinati beheading. Maleficia! Vel cemetery man a modern bursting eyeballs perhsaps morbi. A terrenti flesh contagium. Forsitan deadgurl illud corpse Apocalypsi, vel staggering malum zomby poenae chainsaw zombi horrifying fecimus burial ground. Indeflexus shotgun coup de poudre monstra per plateas currere. Fit de decay nostra carne undead. Poenitentiam violent zom biehig hway agite RE:dead p&oelig;nitentiam! Vivens mortua sunt apud nos night of the living dead.</p>\r\n\r\n<p>Whyt zomby Ut fames after death cerebro virus enim carnis grusome, viscera et organa viventium. Sicut spargit virus ad impetum, qui supersumus flesh eating. Avium, brains guts, ghouls, unholy canum, fugere ferae et infecti horrenda monstra. Videmus twenty-eight deformis pale, horrenda daemonum. Panduntur brains portae rotting inferi. Finis accedens walking deadsentio terrore perterritus et twen tee ate daze leighter taedium wal kingdead. The horror, monstra epidemic significant finem. Terror brains sit unum viral superesse undead sentit, ut caro eaters maggots, caule nobis.</p>\r\n</div>\r\n\r\n<div id=\"lipsumFade\">&nbsp;</div>\r\n</div>\r\n\r\n<div id=\"content\">&nbsp;</div>\r\n', '2018-11-13 12:37:35', NULL, 3, 'published', 1),
(39, 'Comment faire une bonne conception de site Web', '<p>Pr&eacute;sentation des bonnes m&eacute;thodes pour la r&eacute;alisation d&#39;un site web</p>\r\n', '<p>Pour certaines entreprises, Internet c&#39;est l&#39;endroit o&ugrave; elle se retrouve - c&#39;est faire office de si&egrave;ge social d&#39;une soci&eacute;t&eacute; hors ligne. Il est donc important de pratiquer les principes de la bonne conception Web et par-dessus tout, leurs sites devraient s&#39;adresser &agrave; un maximum de visiteurs et surtout qu&#39;ils puissent vendre au plus grand nombre possible de personnes.<br />\r\n<br />\r\nLes concepteurs devraient toujours s&#39;assurez-vous d&#39;avoir une navigation claire de leurs sites Web. Leurs menus de navigation devraient demeurer concis et pr&eacute;cis afin que les visiteurs sachent bien naviguer sur leurs sites sans confusion.<br />\r\n<br />\r\nPourquoi r&eacute;duire le nombre d&#39;images sur un site? Les images rendent le chargement d&#39;un site tr&egrave;s lent et plus souvent qu&#39;autrement, elles sont inutiles. Si les concepteurs jugent que les images demeurent essentielles sur leurs sites, ils devraient s&#39;assurer de les optimiser en utilisant un programme de retouche d&#39;images afin qu&#39;elles soient d&#39;une taille minimale.<br />\r\n<br />\r\nLes concepteurs garderont leurs paragraphes de texte d&#39;une longueur raisonnable. Si un paragraphe est trop long, il faut la scinder en paragraphes distincts, afin que les blocs de texte n&#39;apparaissent pas trop grands. Ceci est important, car un bloc de texte qui est trop grand repoussera les visiteurs &agrave; la lecture du contenu.<br />\r\n<br />\r\nIls devront s&#39;assurer aussi que leurs sites Web se conforment aux normes Web de www.w3.org, ainsi s&#39;assurer que leurs codes HTML soient compatibles avec tous les navigateurs. Il se pourrait que leurs sites apparaissent superbes sur Internet Explorer, mais horribles sur Firefox et Opera, s&#39;ils ne prennent pas le temps de faire les tests sur d&#39;autres navigateurs, ils vont perdre un grand nombre de visiteurs potentiels sur leurs sites.<br />\r\n<br />\r\nDurant la conception de leurs sites, les concepteurs &eacute;viteront d&#39;utiliser les langages script sauf si c&#39;est absolument n&eacute;cessaire. La lourdeur de certains scripts va ralentir le temps de chargement de leurs sites et m&ecirc;me se planter sur certains navigateurs. Aussi, les scripts ne sont pas tous support&eacute;s par les navigateurs.<br />\r\n<br />\r\nEnfin, tout en respectant le principe d&#39;un site bien structur&eacute;, vous allez attirer un meilleur trafic vers votre site Web. Cependant, pour que le tout demeure concluant pour vous, vous allez devoir r&eacute;aliser des tests.</p>\r\n', '2018-11-26 13:36:12', NULL, 7, 'published', 1),
(40, 'Comment réduire le temps de chargement grâce à l\'optimisation d\'image', '<p>Qui n&#39;a jamais raler car le site qu&#39;il voulait visiter mettait du temps &agrave; charger ??</p>\r\n', '<p>Depuis quelques ann&eacute;es Internet haute vitesse se trouve en constante progression, mais une grande partie de la population utilise encore les connexions par modem comme dans le bon vieux temps. Il serait donc judicieux de les compter sur l&#39;&eacute;quation lorsque vous concevrez votre site Web et ceci est une consid&eacute;ration tr&egrave;s importante, vous devriez le concevoir pour les utilisateurs de modems, ainsi r&eacute;duire le temps de chargement de votre site.<br />\r\n<br />\r\nG&eacute;n&eacute;ralement, tout le texte sur votre site web sera charg&eacute; dans un temps tr&egrave;s court m&ecirc;me avec une connexion par modem. Le coupable des sites lents de chargement sont essentiellement de grandes images sur leurs sites, donc, il est tr&egrave;s important de trouver un &eacute;quilibre entre l&#39;utilisation d&#39;images, cependant, assurez-vous dans avoir suffisamment pour attirer les utilisateurs et ne pas trop en mettre pour r&eacute;duire le temps de chargement de votre site.<br />\r\n<br />\r\nVous devriez aussi diminuer les grandeurs de vos images, ce que je veux dire, c&#39;est d&#39;utiliser un logiciel de retouche d&#39;image pour &eacute;liminer les informations inutiles sur vos images, et, en partant de cela, r&eacute;duisez efficacement le volume de fichier de votre image sans affecter son apparence.<br />\r\n<br />\r\nSi vous utilisez Photoshop, il sera &eacute;vident pour vous lorsque vous allez enregistrer une image au format JPEG, une bo&icirc;te de dialogue appara&icirc;tra et vous permettra de choisir la &quot;qualit&eacute;&quot; de l&#39;image JPEG - normalement un r&eacute;glage de 8 &agrave; 10 est assez bon, car elle permettra de pr&eacute;server la qualit&eacute; de votre image, tout en l&#39;enregistrant dans un fichier de petite taille. Si vous n&#39;avez pas de Photoshop, il existe de nombreux compresseurs d&#39;image en ligne gratuit (Gimp est le logiciel tout d&eacute;sign&eacute;) que vous pouvez t&eacute;l&eacute;charger et utiliser pour r&eacute;duire la taille de vos images.<br />\r\n<br />\r\nD&#39;autre part, vous pouvez choisir d&#39;enregistrer vos images au format PNG pour obtenir la meilleure qualit&eacute; &agrave; la moindre taille du fichier. Vous pouvez &eacute;galement enregistrer vos images au format GIF - les logiciels de retouche d&#39;image enl&egrave;vent tous les informations de couleur qui ne sont pas utilis&eacute;es dans votre image, vous donnant donc la plus petite taille de fichier possible. Toutefois, avec l&#39;enregistrement au format GIF la qualit&eacute; de votre image peut-&ecirc;tre compromise, alors faites votre choix &agrave; bon escient !</p>\r\n', '2018-11-26 13:39:19', '2018-11-26 14:09:05', 7, 'published', 1),
(41, 'Ancestral Earth', '<p>Une web s&eacute;rie en devenir !</p>\r\n', '<p>Ancestral Earth c&#39;est quoi ?<br />\r\n<br />\r\nAncestral Earth est une Web-S&eacute;rie amateur r&eacute;alis&eacute;e par Pierre Baptiste Venturini et Thomas Mucchielli sous l&#39;association Arcanis Production, une association de r&eacute;alisation de court m&eacute;trage toute nouvelle en r&eacute;gion PACA.<br />\r\nM&ecirc;me si cette web s&eacute;rie est jeune, elle ne cesse de monter en puissance et fait parler d&#39;elle peu &agrave; peu.<br />\r\n<br />\r\nMais qu&#39;est-ce qu&#39;une web s&eacute;rie ?<br />\r\n<br />\r\nUne web s&eacute;rie comme son nom l&#39;indique s&#39;apparente &agrave; une s&eacute;rie t&eacute;l&eacute; &agrave; la diff&eacute;rence qu&#39;elle est diffus&eacute; sur le net avant de l&#39;&ecirc;tre sur TV. L&#39;avantage du net, c&#39;est sa libert&eacute; d&#39;expression. Ainsi, amateurs et professionnels se c&ocirc;toient dans le monde des Web S&eacute;ries !<br />\r\n<br />\r\nRevenons en &agrave; Ancestral Earth, quel en est l&#39;histoire ?<br />\r\n<br />\r\nBas&eacute; sur un univers fantastique jonglant entre notre monde et un monde parall&egrave;le domin&eacute; par la magie et les armes, on d&eacute;couvre une histoire qui appara&icirc;t comme banale &agrave; premi&egrave;re vu mais tr&egrave;s vite plusieurs intrigues se posent visant &agrave; perdre le spectateur qui essaye de rassembler les pi&egrave;ces du puzzle que forme cette web s&eacute;rie. Vous vous laisserez envo&ucirc;t&eacute; par la l&eacute;g&egrave;ret&eacute; et l&#39;humour omnipr&eacute;sent des &eacute;pisodes et les personnages au caract&egrave;re unique vous ferons passer un bon moment tout &ccedil;a gratuitement. Et si jamais l&#39;aventure vous plait vraiment, vous pourrez m&ecirc;me retrouver l&#39;&eacute;quipe de tournage dans de nombreuses conventions dans toute la France !<br />\r\n<br />\r\nL&#39;histoire commence avec Jack, un ancien prisonnier lib&eacute;r&eacute; sous conditions ,qui doit retrouver Konrad, un scientifique qui a malencontreusement &eacute;tait t&eacute;l&eacute;port&eacute; dans le monde parall&egrave;le en question. Que vas t-il advenir de nos deux h&eacute;ros ? Je vous laisse le d&eacute;couvrir avec la liste des &eacute;pisodes !</p>\r\n', '2018-11-26 13:42:33', NULL, 3, 'published', 1),
(42, 'Faut-il mettre une maison en vente à la veille de Noël ?', '<p>Vous &ecirc;tes en qu&ecirc;te de la p&eacute;riode la plus propice pour vendre ? Lisez cet article et vous saurez tout..</p>\r\n', '<p>Les f&ecirc;tes de No&euml;l approchent et presque tous les propri&eacute;taires se posent des questions : &lsquo;&#39;Faut-il laisser le bien immobilier sur le march&eacute; ou le retirer jusqu&#39;&agrave; une meilleure p&eacute;riode ?&#39;&#39;, &lsquo;&#39;Faut-il mettre une maison en vente aujourd&#39;hui ou attendre jusqu&#39;au printemps ? &lsquo;&#39; Vendre ou ne pas vendre votre propri&eacute;t&eacute; &agrave; la fin de l&#39;ann&eacute;e ? Cela d&eacute;pend non seulement de votre situation personnelle, mais aussi de la situation du march&eacute; immobilier. Mais il y a quelques raisons pour lesquelles il peut &ecirc;tre une bonne id&eacute;e de mettre votre bien en vente &agrave; la veille des f&ecirc;tes de No&euml;l.<br />\r\n<br />\r\nG&eacute;n&eacute;ralement les acheteurs potentiels croient que les f&ecirc;tes ne sont pas propices &agrave; des achats importants. En cette p&eacute;riode tout le monde est occup&eacute;: soir&eacute;es, repas de No&euml;l, cadeaux ou voyages, etc. La visite des propri&eacute;t&eacute;s avec un agent immobilier entre en contradiction avec &lsquo;&#39;l&#39;horaire charg&eacute;&#39;&#39; du cong&eacute;. Mais les saisons traditionnelles de vente sont d&eacute;termin&eacute;es par la disponibilit&eacute; des offres. Celui qui s&#39;occupe de cette question s&eacute;rieusement est toujours &agrave; la recherche d&#39;un bien immobilier. Il peut regarder des offres convenables sur Internet &agrave; n&#39;importe quelle saison. Les acheteurs responsables font tout leur effort et ils ne prennent pas de cong&eacute; avant que leur projet ne soit concr&eacute;tis&eacute;.<br />\r\n<br />\r\nSi votre maison est d&eacute;j&agrave; sur le march&eacute; depuis quelques mois, plusieurs acheteurs le consid&egrave;rent comme &#39;&#39;un bien d&eacute;fectueux&#39;&#39;. En ce cas il est temps de prendre des mesures. Par exemple, faites un bon rabais de No&euml;l ou organisez une action de No&euml;l.<br />\r\n<br />\r\nD&#39;habitude, au mois de janvier, il y a peu d&#39;offres sur le march&eacute; immobilier parce que la plupart des vendeurs attendent le printemps qu&#39;ils croient la meilleure saison de vente. Pourtant, il existe les personnes qui sont pr&ecirc;tes &agrave; acheter une maison en hiver. Certains ont le d&eacute;sir de devenir propri&eacute;taire apr&egrave;s avoir compt&eacute; l&#39;argent qu&#39;ils avaient donn&eacute; au loueur. Il y a ceux qui se font la promesse d&#39;investir plus et de d&eacute;penser moins. Enfin, il est possible qu&#39;un riche parent ait offert une grande somme d&#39;argent pour acheter une maison de r&ecirc;ve.<br />\r\n<br />\r\nDonc, si vous pensez s&eacute;rieusement vendre votre propri&eacute;t&eacute;, toutes les p&eacute;riodes de l&#39;ann&eacute;e sont bonnes.</p>\r\n', '2018-11-26 14:12:34', NULL, 1, 'published', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `quality` varchar(255) NOT NULL DEFAULT 'user',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `validation_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `quality`, `status`, `validation_key`) VALUES
(1, 'demo', '89e495e7941cf9e40e6980d14a16bf023ccd4c91', '', 'admin', 1, NULL),
(10, 'alex', '60c6d277a8bd81de7fdde19201bf9c58a3df08f4', '', 'user', 1, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment___f` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `posts___fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
