-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 09 sep. 2020 à 10:23
-- Version du serveur :  5.6.49-cll-lve
-- Version de PHP : 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sf_omnis`
--

-- --------------------------------------------------------

--
-- Structure de la table `institut`
--

CREATE TABLE `institut` (
  `id` int(11) NOT NULL,
  `sigle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denomination` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `institut`
--

INSERT INTO `institut` (`id`, `sigle`, `denomination`) VALUES
(1, 'ISCF', 'Institut Supérieur de Comptabilité et de Finances'),
(2, 'ISCRH', 'Institut Supérieur de Communication et de Ressources Humaines'),
(3, 'ISI-NTIC', 'Institut Supérieur d\'Informatique et des NTIC'),
(4, 'ISMCI', 'Institut Supérieur de Management et de Commerce International');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `institut`
--
ALTER TABLE `institut`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `institut`
--
ALTER TABLE `institut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
