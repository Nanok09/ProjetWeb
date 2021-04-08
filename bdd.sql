-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 08, 2021 at 01:40 PM
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
  `idLieu` int(11) NOT NULL,
  `utilisateur` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `utilisateur` int(11) NOT NULL COMMENT 'Id de l''utilisateur qui a donné la note',
  `note` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `photosLieux`
--

CREATE TABLE `photosLieux` (
  `id` int(11) NOT NULL,
  `idLieu` int(11) NOT NULL,
  `nomFichier` varchar(255) DEFAULT NULL
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
-- Indexes for dumped tables
--

--
-- Indexes for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD KEY `idLieu` (`idLieu`),
  ADD KEY `utilisateur` (`utilisateur`);

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
  ADD KEY `idLieu` (`idLieu`),
  ADD KEY `utilisateur` (`utilisateur`);

--
-- Indexes for table `photosLieux`
--
ALTER TABLE `photosLieux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idLieu` (`idLieu`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtilisateur` (`idUtilisateur`),
  ADD KEY `idCreneau` (`idCreneau`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messagesChat`
--
ALTER TABLE `messagesChat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`idLieu`) REFERENCES `lieux` (`id`),
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`utilisateur`) REFERENCES `utilisateurs` (`id`);

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
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`utilisateur`) REFERENCES `utilisateurs` (`id`);

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
