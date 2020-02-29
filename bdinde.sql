-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 23, 2018 at 08:10 AM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdinde`
--

-- --------------------------------------------------------

--
-- Table structure for table `appartenir`
--

CREATE TABLE `appartenir` (
  `idJeux` int(11) NOT NULL,
  `idGenre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appartenir`
--

INSERT INTO `appartenir` (`idJeux`, `idGenre`) VALUES
(3, 1),
(3, 18),
(13, 6),
(13, 12);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `email` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `idRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`email`, `mdp`, `pseudo`, `idRole`) VALUES
('administrateur@administrateur.com', '$2y$10$CiXkJ8w.gyuQUj3jFoVKr..KwZS/OJtwGyIOchofGAGfq6KvdpX7C', 'Administrateur', 1),
('catouillard.benjamin@gmail.com', '$2y$10$MBc7KwvmQCHRYDnD9/EbEumP66TtAXNAzQiNOxgl3XR/NJW1H79W6', 'Tocardz', 1),
('client@client.com', '$2y$10$5T3CISkk5FK/4TGMix/zu.f.DLEswL5i4eIEIPYel2Mpo5dEum/gK', 'Client', 2);

-- --------------------------------------------------------

--
-- Table structure for table `commander`
--

CREATE TABLE `commander` (
  `id` int(11) NOT NULL,
  `idJeux` int(11) NOT NULL,
  `emailClient` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `disponible`
--

CREATE TABLE `disponible` (
  `idJeux` int(11) NOT NULL,
  `idCompatibilite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `disponible`
--

INSERT INTO `disponible` (`idJeux`, `idCompatibilite`) VALUES
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(3, 1),
(3, 4),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(13, 1),
(13, 2),
(13, 3),
(13, 7);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(10) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `libelle`) VALUES
(1, 'Action'),
(2, 'Plateforme'),
(3, 'TPS'),
(4, 'Aventure'),
(5, 'RPG'),
(6, 'Rogue-like'),
(7, 'Simulation'),
(8, 'Sport'),
(9, 'Course'),
(10, 'Rythme'),
(11, 'Stratégie tour par tour'),
(12, 'Stratégie en temps réel'),
(13, 'Gestion'),
(15, 'Hack\'n\'Slash'),
(16, 'Survival Horror'),
(17, 'FPS'),
(18, 'Shoot them Up'),
(19, 'Rail Shooter'),
(20, 'Beat them All');

-- --------------------------------------------------------

--
-- Table structure for table `jeux`
--

CREATE TABLE `jeux` (
  `id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jeux`
--

INSERT INTO `jeux` (`id`, `designation`, `description`, `prix`) VALUES
(1, 'The Binding of Isaac: Rebirth', 'The Binding of Isaac est un jeu de tir action RPG généré aléatoirement avec beaucoup d\'éléments rogue-like. ', 15),
(2, 'Iconoclasts', 'Incarnez Robin, une mécanicienne rebelle, et découvrez les secrets d’une planète à l\'agonie. ', 20),
(3, 'Cuphead', 'Cuphead, c\'est un jeu de plates-formes/action dans la pure veine « run and gun », avec un goût prononcé pour les combats de boss épiques.', 20),
(4, 'Flinthook', 'Vous êtes Flinthook, le capitaine de l\'espace ! Armé de votre puissant grappin, de vos étranges pouvoirs de ralenti et de votre fidèle pistolet plasma, frayez-vous un chemin au travers d\'un nombre infini de vaisseaux spatiaux assemblés aléatoirement, à la', 15),
(5, 'Stardew Valley', 'Stardew Valley est un jeu vidéo de simulation dans lequel le joueur doit gérer sa ferme.', 14),
(6, 'Undertale', 'Undertale propose de contrôler un enfant tombé dans l\'Underground, une grande région isolée sous la surface de la Terre, séparée de la surface par une barrière magique et peuplée de monstres', 10),
(7, 'Heartbound', 'Heartbound est un RPG non traditionnel à propos d\'un garçon, son chien et des secrets...', 8),
(8, 'Jotun', 'Jotun est un jeu d\'action et d\'exploration dessiné à la main dont le décor est planté dans la mythologie nordique.', 15),
(9, 'Super Meat Boy', 'Le fameux jeu de plateforme', 14),
(10, 'Hob', 'Transformez le monde de Hob ! Runic Games, le studio déjà primé pour Torchlight I et II vous présente son nouveau jeu d\'action/aventure. C\'est à vous de jouer. Créez votre propre monde.', 20),
(11, 'Playerunknown\'s Battlegrounds', 'Le fameux battle royale ', 30),
(12, 'The Red Strings Club', 'Situé dans un univers cyberpunk, Red Strings Club est une expérience narrative tournant autour des thèmes du bonheur et de la destinée et mêlant la poterie, la mixologie et l\'imitation de voix au téléphone.', 15),
(13, 'Faster Than Light (FTL)', 'Cette simulation de vaisseau spatial à la sauce rogue-like vous permet de partir à l\'aventure avec votre navire et son équipage à travers une galaxie générée aléatoirement.', 10),
(14, 'Rogue Legacy', 'Rogue-like 2D prenant place dans un château généré aléatoirement. Le joueur a le choix entre 8 classes de personnages différentes dont la mort est définitive.', 15),
(15, 'Fez', 'Gomez est une créature 2D vivant dans un monde 2D. Enfin, c\'est ce qu\'il croit...', 10);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `idJeux` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `idJeux`, `nom`) VALUES
(1, 13, 'FTL.jpg'),
(2, 15, 'fez.jpg'),
(3, 14, 'roguelegacy.jpg'),
(4, 3, 'cuphead.jpg'),
(5, 4, 'flinthook.jpg'),
(6, 7, 'heartbound.jpg'),
(7, 10, 'hob.jpg'),
(8, 2, 'iconoclasts.jpg'),
(9, 8, 'jotun.jpg'),
(10, 11, 'pubg.jpg'),
(11, 5, 'stardew_valley.jpg'),
(12, 9, 'super_meat_boy.jpg'),
(13, 1, 'boi_rebirth.jpg'),
(14, 12, 'The_Red_Strings_Club.jpg'),
(15, 6, 'undertale.png');

-- --------------------------------------------------------

--
-- Table structure for table `portabilite`
--

CREATE TABLE `portabilite` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `portabilite`
--

INSERT INTO `portabilite` (`id`, `type`) VALUES
(1, 'PC'),
(2, 'Mac'),
(3, 'Linux'),
(4, 'Xbox'),
(5, 'Playstation'),
(6, 'Switch'),
(7, 'iOS'),
(8, 'Android');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `libelle`) VALUES
(1, 'Administrateur'),
(2, 'Client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appartenir`
--
ALTER TABLE `appartenir`
  ADD PRIMARY KEY (`idJeux`,`idGenre`),
  ADD KEY `appartenir_genre` (`idGenre`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`email`),
  ADD KEY `client_role` (`idRole`);

--
-- Indexes for table `commander`
--
ALTER TABLE `commander`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commander_client` (`emailClient`),
  ADD KEY `commander_jeux` (`idJeux`);

--
-- Indexes for table `disponible`
--
ALTER TABLE `disponible`
  ADD PRIMARY KEY (`idJeux`,`idCompatibilite`),
  ADD KEY `disponible_compatibilite` (`idCompatibilite`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeux`
--
ALTER TABLE `jeux`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`,`idJeux`),
  ADD KEY `media_jeux` (`idJeux`);

--
-- Indexes for table `portabilite`
--
ALTER TABLE `portabilite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commander`
--
ALTER TABLE `commander`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `jeux`
--
ALTER TABLE `jeux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `portabilite`
--
ALTER TABLE `portabilite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `appartenir`
--
ALTER TABLE `appartenir`
  ADD CONSTRAINT `appartenir_genre` FOREIGN KEY (`idGenre`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `appartenir_jeux` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`id`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_role` FOREIGN KEY (`idRole`) REFERENCES `role` (`id`);

--
-- Constraints for table `commander`
--
ALTER TABLE `commander`
  ADD CONSTRAINT `commander_client` FOREIGN KEY (`emailClient`) REFERENCES `client` (`email`),
  ADD CONSTRAINT `commander_jeux` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`id`);

--
-- Constraints for table `disponible`
--
ALTER TABLE `disponible`
  ADD CONSTRAINT `disponible_compatibilite` FOREIGN KEY (`idCompatibilite`) REFERENCES `portabilite` (`id`),
  ADD CONSTRAINT `disponible_jeux` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`id`);

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_jeux` FOREIGN KEY (`idJeux`) REFERENCES `jeux` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
