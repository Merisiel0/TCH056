-- dumping data for table `coaches`
INSERT INTO `coaches` (`name`) VALUES
('Tous'),
('Jean Dupont'),
('Marc Lefevre'),
('Sophie Martin'),
('Pierre Rousseau'),
('Claire Lefevre'),
('Olivier Dufresne'),
('Alain Petit'),
('Isabelle Bernard'),
('Marie Leclerc'),
('Jacques Leroy'),
('Michel Roche'),
('Thomas Gauthier');

-- dumping data for table `locations`
INSERT INTO `locations` (`name`) VALUES
('Tous'),
('Intérieur'),
('Extérieur');

-- dumping data for table `levels`
INSERT INTO `levels` (`name`) VALUES
('Tous'),
('Débutant'),
('Intermédiaire'),
('Avancé'),
('Expert');

-- dumping data for table `users`
INSERT INTO `users` (`first_name`, `last_name`, `username`, `password`) 
VALUES ('Test', 'User', 'testuser', '1234');

-- dumping data for table `activities` with updated foreign keys
INSERT INTO `activities` (`id`, `name`, `description`, `image`, `level_id`, `coach_id`, `schedule_day`, `schedule_time`, `location_id`) VALUES
(1, 'Boxe', 'La boxe est un sport de combat dans lequel deux participants s\'affrontent en utilisant uniquement leurs poings.', './assets/sports/tile007.jpg', 1, 1, 'Lundi', '18h - 19h', 1),
(2, 'Cyclisme', 'Le cyclisme consiste à se déplacer sur un vélo, que ce soit en compétition ou pour le loisir.', './assets/sports/tile006.jpg', 5, 2, 'Mardi', '10h - 11h', 2),
(3, 'Escrime', 'L\'escrime est un sport de combat qui utilise des armes blanches, comme le fleuret, l\'épée et le sabre.', './assets/sports/tile017.jpg', 2, 3, 'Jeudi', '15h - 16h', 1),
(4, 'Football', 'Le football est un sport collectif où deux équipes s\'affrontent pour marquer des buts avec un ballon rond.', './assets/sports/tile000.jpg', 3, 4, 'Vendredi', '17h - 18h', 2),
(5, 'Gym', 'Le gym dispose de différents appareils et d\'un équipement spécialisé permettant de faire des exercices.', './assets/sports/tile019.jpg', 5, 5, 'Lundi', '9h - 10h', 1),
(6, 'Handball', 'Le handball est un sport collectif où deux équipes de sept joueurs essaient de marquer des buts.', './assets/sports/tile005.jpg', 2, 6, 'Mardi', '14h - 15h', 1),
(7, 'Hockey', 'Le hockey sur glace est un sport d\'équipe joué sur une patinoire.', './assets/sports/tile015.jpg', 4, 7, 'Samedi', '16h - 17h', 2),
(8, 'Mini-golf', 'Le mini-golf est une version réduite du golf avec des obstacles.', './assets/sports/tile012.jpg', 5, 8, 'Dimanche', '10h - 11h', 2),
(9, 'Natation', 'La natation est un sport qui consiste à se déplacer dans l\'eau.', './assets/sports/tile002.jpg', 1, 9, 'Mercredi', '14h - 15h', 1),
(10, 'Tennis', 'Le tennis est un sport de raquette où deux ou quatre joueurs s\'affrontent.', './assets/sports/tile001.jpg', 2, 10, 'Vendredi', '16h - 17h', 2),
(11, 'Tir à l\'arc', 'Le tir à l\'arc est un sport de précision.', './assets/sports/tile009.jpg', 3, 11, 'Mercredi', '17h - 18h', 2),
(12, 'Volleyball', 'Le volleyball est un sport d\'équipe.', './assets/sports/tile021.jpg', 2, 12, 'Lundi', '11h - 12h', 1);

ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

