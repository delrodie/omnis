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
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `id` int(11) NOT NULL,
  `institut_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`id`, `institut_id`, `libelle`, `slug`) VALUES
(1, 1, 'Diplôme de Technicien Supérieur-Finances et Comptabilité', 'diplome-de-technicien-superieur-finances-et-comptabilite'),
(2, 1, 'Brevet de Technicien Supérieur Finances Comptabilité et Gestion des Entreprises', 'brevet-de-technicien-superieur-finances-comptabilite-et-gestion-des-entreprises'),
(3, 1, 'Licence Professionnelle Audit et Contrôle de Gestion', 'licence-professionnelle-audit-et-controle-de-gestion'),
(4, 1, 'Licence Professionnelle Techniques Comptables et Financières', 'licence-professionnelle-techniques-comptables-et-financieres'),
(5, 1, 'Licence Professionnelle Fiscalité des Entreprises et des Collectivités', 'licence-professionnelle-fiscalite-des-entreprises-et-des-collectivites'),
(6, 1, 'Ingénierie Comptable et Financière', 'ingenierie-comptable-et-financiere'),
(7, 1, 'Master Ingénierie Comptable et Financière', 'master-ingenierie-comptable-et-financiere'),
(8, 1, 'Master Audit et Contrôle de Gestion', 'master-audit-et-controle-de-gestion'),
(9, 1, 'Master Fiscalité des Entreprises et des Collectivités', 'master-fiscalite-des-entreprises-et-des-collectivites'),
(10, 2, 'Diplôme de Technicien Supérieur des Ressources Humaines', 'diplome-de-technicien-superieur-des-ressources-humaines'),
(11, 2, 'Diplôme de Technicien Supérieur Publicité', 'diplome-de-technicien-superieur-publicite'),
(12, 2, 'Diplôme de Technicien Supérieur Infographie et Multimédia', 'diplome-de-technicien-superieur-infographie-et-multimedia'),
(13, 2, 'Brevet de Technicien Supérieur Ressources Humaines et Communication', 'brevet-de-technicien-superieur-ressources-humaines-et-communication'),
(14, 2, 'Licence Professionnelle Gestion des Ressources Humaines', 'licence-professionnelle-gestion-des-ressources-humaines'),
(15, 2, 'Licence Professionnelle Communication Publicitaire', 'licence-professionnelle-communication-publicitaire'),
(16, 2, 'Licence Professionnelle Infographie et Multimédia', 'licence-professionnelle-infographie-et-multimedia'),
(17, 2, 'Master Gestion des Ressources Humaines', 'master-gestion-des-ressources-humaines'),
(18, 2, 'Master Communication Publicitaire', 'master-communication-publicitaire'),
(19, 3, 'Diplôme de Technicien Supérieur Informatique', 'diplome-de-technicien-superieur-informatique'),
(20, 3, 'Brevet de Technicien Supérieur Informatique et Développeur d\'Application', 'brevet-de-technicien-superieur-informatique-et-developpeur-d-application'),
(21, 3, 'Ingénieur Informatique', 'ingenieur-informatique'),
(22, 3, 'Master Informatique', 'master-informatique'),
(23, 4, 'Diplôme de Technicien Supérieur Action Commerciale', 'diplome-de-technicien-superieur-action-commerciale'),
(24, 4, 'Diplôme de Technicien Supérieur Logistique', 'diplome-de-technicien-superieur-logistique'),
(25, 4, 'Brevet de Technicien Supérieur Gestion Commerciale', 'brevet-de-technicien-superieur-gestion-commerciale'),
(26, 4, 'Brevet de Technicien Supérieur Logistique', 'brevet-de-technicien-superieur-logistique'),
(27, 4, 'Licence Professionnelle Management des Opérations Logistiques', 'licence-professionnelle-management-des-operations-logistiques'),
(28, 4, 'Licence Professionnelle Marketing et Négociation', 'licence-professionnelle-marketing-et-negociation'),
(29, 4, 'Licence Professionnelle Commerce International', 'licence-professionnelle-commerce-international'),
(30, 4, 'Licence Professionnelle Gestion des Moyens Généraux', 'licence-professionnelle-gestion-des-moyens-generaux'),
(31, 4, 'Licence Professionnelle Logistique Humanitaire et Diplomatique', 'licence-professionnelle-logistique-humanitaire-et-diplomatique'),
(32, 4, 'Licence Professionnelle Administration des Entreprises', 'licence-professionnelle-administration-des-entreprises'),
(33, 4, 'Ingénieur Commerce Export', 'ingenieur-commerce-export'),
(34, 4, 'Ingénieur Management des Opérations Logistiques', 'ingenieur-management-des-operations-logistiques'),
(35, 4, 'Master Management des Opérations Logistiques', 'master-management-des-operations-logistiques'),
(36, 4, 'Master Marketing et Stratégies', 'master-marketing-et-strategies'),
(37, 4, 'Master Commerce International', 'master-commerce-international'),
(38, 4, 'Master Administration des Entreprises', 'master-administration-des-entreprises');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2ED05D9EACF64F5F` (`institut_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD CONSTRAINT `FK_2ED05D9EACF64F5F` FOREIGN KEY (`institut_id`) REFERENCES `institut` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
