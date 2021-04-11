-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 11, 2021 at 12:36 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `idLieu` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `edited` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `commentaires`
--

INSERT INTO `commentaires` (`id`, `idLieu`, `idUtilisateur`, `message`, `timestamp`, `edited`) VALUES
(1, 1, 4, 'blablabla', '2021-04-11 10:15:10', 0),
(3, 1, 5, 'bla', '2021-04-11 10:35:28', 0),
(4, 1, 4, 'blablabla2', '2021-04-11 10:27:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `creneaux`
--

CREATE TABLE `creneaux` (
  `id` int(11) NOT NULL,
  `idLieu` int(11) NOT NULL,
  `debut` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `capacite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lieux`
--

CREATE TABLE `lieux` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `adresse` text NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `sport` varchar(30) NOT NULL,
  `prive` tinyint(1) NOT NULL,
  `createur` int(11) NOT NULL,
  `prix` float NOT NULL,
  `capacite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lieux`
--

INSERT INTO `lieux` (`id`, `nom`, `description`, `adresse`, `latitude`, `longitude`, `sport`, `prive`, `createur`, `prix`, `capacite`) VALUES
(1, 'terrain1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation', 'Addresse 1', 50.6166, 3.164, 'basket', 1, 5, 1, 10),
(2, 'terrain2', 'description', 'Addresse 2', 51.6166, 3.064, 'tennis', 1, 4, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `messagesChat`
--

CREATE TABLE `messagesChat` (
  `id` int(11) NOT NULL,
  `auteur` int(11) NOT NULL,
  `destinataire` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `idLieu` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL COMMENT 'Id de l''utilisateur qui a donné la note',
  `note` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`idLieu`, `idUtilisateur`, `note`, `timestamp`) VALUES
(2, 4, 3, '2021-04-11 10:03:15');

-- --------------------------------------------------------

--
-- Table structure for table `photosLieux`
--

CREATE TABLE `photosLieux` (
  `id` int(11) NOT NULL,
  `idLieu` int(11) NOT NULL,
  `nomFichier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idCreneau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `timeInscription` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `password`, `nom`, `prenom`, `email`, `timeInscription`, `admin`) VALUES
(4, 'matt', 'test', 'nom', 'pre', 'plotton.matthieu@gmail.com', '2021-04-11 10:36:02', 0),
(5, 'pseudo', 'motdepasse', 'nom', 'prenom', 'test@gmail.com', '2021-04-11 08:28:03', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idLieu` (`idLieu`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Indexes for table `creneaux`
--
ALTER TABLE `creneaux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idLieu` (`idLieu`);

--
-- Indexes for table `lieux`
--
ALTER TABLE `lieux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createur` (`createur`);

--
-- Indexes for table `messagesChat`
--
ALTER TABLE `messagesChat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auteur` (`auteur`),
  ADD KEY `destinataire` (`destinataire`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD UNIQUE KEY `unique_note` (`idLieu`,`idUtilisateur`),
  ADD KEY `idLieu` (`idLieu`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Indexes for table `photosLieux`
--
ALTER TABLE `photosLieux`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomFichier` (`nomFichier`),
  ADD KEY `idLieu` (`idLieu`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reservation` (`idUtilisateur`,`idCreneau`),
  ADD KEY `idUtilisateur` (`idUtilisateur`),
  ADD KEY `idCreneau` (`idCreneau`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `creneaux`
--
ALTER TABLE `creneaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lieux`
--
ALTER TABLE `lieux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messagesChat`
--
ALTER TABLE `messagesChat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photosLieux`
--
ALTER TABLE `photosLieux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`idLieu`) REFERENCES `lieux` (`id`),
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `creneaux`
--
ALTER TABLE `creneaux`
  ADD CONSTRAINT `creneaux_ibfk_1` FOREIGN KEY (`idLieu`) REFERENCES `lieux` (`id`);

--
-- Constraints for table `lieux`
--
ALTER TABLE `lieux`
  ADD CONSTRAINT `lieux_ibfk_1` FOREIGN KEY (`createur`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `messagesChat`
--
ALTER TABLE `messagesChat`
  ADD CONSTRAINT `messagesChat_ibfk_1` FOREIGN KEY (`auteur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `messagesChat_ibfk_2` FOREIGN KEY (`destinataire`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`idLieu`) REFERENCES `lieux` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `photosLieux`
--
ALTER TABLE `photosLieux`
  ADD CONSTRAINT `photosLieux_ibfk_1` FOREIGN KEY (`idLieu`) REFERENCES `lieux` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`idCreneau`) REFERENCES `creneaux` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
