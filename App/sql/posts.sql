CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_amended` datetime
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Posts (`id`, `title`, `content`, `author`, `date_added`, `date_amended`) VALUES
(1, 'Voici mon premier article', 'Mon super blog est en construction.', 'Alex', '2018-01-01', null),
(2, 'Un deuxième article', 'Je continue à ajouter du contenu sur mon blog.', 'Alex', '2018-01-05', '2018-01-07'),
(3, 'Mon troisième article', 'Mon blog est génial !!!', 'Alex', '2018-01-10', null);

ALTER TABLE Posts
  ADD PRIMARY KEY (`id`);

ALTER TABLE Posts
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;