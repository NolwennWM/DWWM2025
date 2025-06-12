-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : bddsql
-- Généré le : mer. 11 juin 2025 à 08:42
-- Version du serveur : 11.7.2-MariaDB-ubu2404
-- Version de PHP : 8.2.28

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`username`, `email`, `password`, `createdAt`) VALUES
('Pierre', 'pi@gmail.com', '$2y$10$GYkr/Yws666DAA0aVA2AZ.NrhXnlVhC4dA1k1J/C31AA.XWXNcbyi', '2025-06-10 09:37:29'),
('Maurice', 'momo@gmail.com', '$2y$10$GYkr/Yws666DAA0aVA2AZ.NrhXnlVhC4dA1k1J/C31AA.XWXNcbyi', '2025-06-11 07:30:24');

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`message`, `createdAt`, `editedAt`, `idUser`) VALUES
('Mon super message', '2025-06-10 11:03:19', NULL, (SELECT `idUser` FROM `users` WHERE `username` = "Pierre")),
('Un autre message très interessant', '2025-06-10 11:03:38', NULL, (SELECT `idUser` FROM `users` WHERE `username` = "Pierre"));

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
