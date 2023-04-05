-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 04 avr. 2023 à 19:26
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `consort`
--
CREATE DATABASE IF NOT EXISTS `consort` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `consort`;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(70) NOT NULL,
  `admin_photo` varchar(255) DEFAULT 'avatar1.png',
  `telephone` varchar(50) DEFAULT NULL,
  `fonction` varchar(50) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `badge_consort` varchar(255) NOT NULL DEFAULT 'admin_badge.png',
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom`, `prenom`, `adresse`, `email`, `password`, `admin_photo`, `telephone`, `fonction`, `badge`, `ville`, `pays`, `signature`, `badge_consort`) VALUES
(1, 'Tonde', 'Souleymane', 'Cocody', 'tondesoulco@gmail.com', '$2y$10$gXD.VF8L/OKJ4XzsNDN4iuXv4B5e1CoqCScey8ijfPJAWHXXVrhki', '641ed6dcb1d1a2.72273714.jpg', '0546472006', 'DG', 'super admin', NULL, NULL, '!carrisme sans humilité', 'admin_badge');

-- --------------------------------------------------------

--
-- Structure de la table `delegue`
--

CREATE TABLE IF NOT EXISTS `delegue` (
  `id_delegue` int(11) NOT NULL AUTO_INCREMENT,
  `matDelegue` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT 'no_file.png',
  `telephone` varchar(50) DEFAULT NULL,
  `fonction` varchar(50) DEFAULT NULL,
  `badge` varchar(255) DEFAULT 'déconnecté',
  `date_entree` date DEFAULT current_timestamp(),
  `date_depart` date DEFAULT NULL,
  `badge_consort` varchar(255) NOT NULL DEFAULT 'badge_delegue.png',
  PRIMARY KEY (`id_delegue`,`matDelegue`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `delegue`
--

INSERT INTO `delegue` (`id_delegue`, `matDelegue`, `nom`, `prenom`, `adresse`, `email`, `photo`, `telephone`, `fonction`, `badge`, `date_entree`, `date_depart`, `badge_consort`) VALUES
(1, '13263316H', 'Tonde', 'Souleymane', 'Abidjan', 'tondesoulco@gmail.com', '641d9cce35ea24.62258122.jpg', '0546472006', 'Delegue', 'deconnecté', NULL, NULL, 'badge_delegue.png'),
(2, 'oude700101', 'Ouffouet', 'Dexquis', 'Abidjan', 'ouffouetdexquis@gmail.com', 'no_file.png', '4521475488', 'delegue', 'deconnecté', '2023-03-18', NULL, 'badge_delegue.png'),
(4, 'asje700101', 'Assy ', 'jean agnimel', 'Abidjan', 'assyjeanagnimel@gmail.com', 'no_file.png', '0154212521', 'delegue', 'déconnecté', '2023-03-19', '2023-04-01', 'badge_delegue.png'),
(5, 'SOWHAB0230', 'sow ', 'Habi', 'Abidjan', 'abi@gmail.com', 'no_file.png', '4521475488', 'delegue', 'déconnecté', '2023-03-22', NULL, 'badge_delegue.png');

-- --------------------------------------------------------

--
-- Structure de la table `delegue_zone_produit`
--

CREATE TABLE IF NOT EXISTS `delegue_zone_produit` (
  `id_delegue` int(11) NOT NULL,
  `id_zone` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  PRIMARY KEY (`id_delegue`,`id_zone`,`id_produit`),
  KEY `id_zone` (`id_zone`),
  KEY `id_produit` (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `delegue_zone_produit`
--

INSERT INTO `delegue_zone_produit` (`id_delegue`, `id_zone`, `id_produit`) VALUES
(1, 1, 9),
(1, 2, 9),
(1, 3, 14),
(1, 4, 8),
(2, 1, 3),
(2, 1, 5),
(4, 2, 6),
(5, 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `demande_delegue`
--

CREATE TABLE IF NOT EXISTS `demande_delegue` (
  `id_demande` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `lettre` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'en attente',
  PRIMARY KEY (`id_demande`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gamme_produit`
--

CREATE TABLE IF NOT EXISTS `gamme_produit` (
  `id_gamme` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(50) NOT NULL,
  `id_laboratoire` int(11) NOT NULL,
  PRIMARY KEY (`id_gamme`),
  KEY `id_laboratoire` (`id_laboratoire`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `gamme_produit`
--

INSERT INTO `gamme_produit` (`id_gamme`, `categorie`, `id_laboratoire`) VALUES
(1, 'Soin de la peau', 1),
(2, 'cosmétiques', 2),
(3, 'Vaccin-Antidote', 3),
(4, 'Plaquettes médicaments', 4),
(5, 'hygiène féminine', 6),
(6, 'Santé physique', 5),
(7, 'Désinfectant', 7);

-- --------------------------------------------------------

--
-- Structure de la table `laboratoire`
--

CREATE TABLE IF NOT EXISTS `laboratoire` (
  `id_laboratoire` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `pays` varchar(50) NOT NULL,
  `etat` varchar(255) NOT NULL DEFAULT 'fonctionnel',
  PRIMARY KEY (`id_laboratoire`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `laboratoire`
--

INSERT INTO `laboratoire` (`id_laboratoire`, `nom`, `adresse`, `pays`, `etat`) VALUES
(1, 'Best skin', 'San-pedro', 'CI', 'Fonctionnel'),
(2, 'Cosmaker', 'Bobo-dioulasso', 'Burkina Faso', 'Fonctionnel'),
(3, 'Science Lab', 'Nice', 'France', 'Fonctionnel'),
(4, 'Comprimer\'Station', 'Soubre', 'CI', 'Fonctionnel'),
(5, 'Health\'s Care', 'Cocody', 'CI', 'Fonctionnel'),
(6, 'WomenNeed', 'Ougua', 'Burkina Faso', 'Fonctionnel'),
(7, 'Desinfect-center', 'Abidjan', 'cI', 'Fonctionnel');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_delegue` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `vu_admin` tinyint(1) NOT NULL DEFAULT 0,
  `vu_delegue` tinyint(1) NOT NULL DEFAULT 0,
  `destinataire` enum('admin','delegue') NOT NULL,
  `reponse` text DEFAULT NULL,
  `h_reponse` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_delegue` (`id_delegue`),
  KEY `id_admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `id_delegue`, `id_admin`, `message`, `date`, `vu_admin`, `vu_delegue`, `destinataire`, `reponse`, `h_reponse`) VALUES
(1, 1, 1, 'salut cher administrateur', '2023-03-21 13:41:21', 1, 1, 'admin', 'ca va et toi?', '2023-03-22 01:31:11'),
(2, 4, 1, 'Tu me reçois? bonne nuit', '2023-03-21 22:28:07', 1, 0, 'admin', 'chaooooooo.... ultimatum', '2023-03-22 02:58:17'),
(3, 2, 1, 'ici Ouffouet, j\'espere que ca va.', '2023-03-21 22:28:07', 1, 0, 'admin', 'bonne nuit bro', '2023-03-22 02:19:38'),
(6, 4, 1, 'Bonjour bro', '2023-03-22 04:44:02', 1, 0, 'delegue', NULL, NULL),
(7, 4, 1, 'Bonjour bro', '2023-03-22 04:45:08', 1, 0, 'delegue', NULL, NULL),
(8, 1, 1, 'Bonjour bro', '2023-03-22 07:51:31', 1, 1, 'delegue', 'fhum', '2023-03-25 16:07:34'),
(9, 1, 1, 'hello', '2023-03-22 08:31:34', 1, 1, 'delegue', 'jksd', '2023-03-25 13:47:55'),
(10, 1, 1, 'hghgnkhh', '2023-03-22 08:35:45', 1, 1, 'delegue', 'hein???', '2023-03-25 16:07:45'),
(11, 2, 1, 'essaie', '2023-03-22 08:54:15', 1, 0, 'delegue', NULL, NULL),
(12, 2, 1, 'toto bien??', '2023-03-22 08:54:28', 1, 0, 'delegue', NULL, NULL),
(13, 2, 1, 'Perfecto', '2023-03-22 08:56:40', 1, 1, 'delegue', 'jhj', '2023-03-24 14:02:07'),
(14, 2, 1, 'salaud ', '2023-03-22 12:49:56', 1, 1, 'delegue', 'ou et toi', '2023-03-24 13:53:57'),
(15, 5, 1, 'salut petiteee', '2023-03-22 12:53:09', 1, 0, 'delegue', 'comment ca va ?', NULL),
(16, 1, 1, 'gkhk', '2023-03-22 13:29:20', 1, 1, 'delegue', 'fhum', '2023-03-25 16:07:54'),
(17, 5, 1, 'salut', '2023-03-22 13:44:56', 1, 0, 'delegue', NULL, NULL),
(18, 1, 1, 'Salut, tu fais quoi en ligne??', '2023-03-24 12:59:30', 1, 1, 'delegue', 'rien', '2023-03-25 16:07:26'),
(19, 2, 1, 'On mourra', '2023-03-24 13:57:11', 1, 1, 'delegue', 'je te suis', '2023-03-24 13:57:42'),
(20, 1, 1, 'salut', '2023-03-25 13:23:34', 1, 1, 'delegue', 'ndkw', '2023-03-25 13:24:13'),
(21, 1, 1, 'Bonjour bro', '2023-03-25 13:32:29', 1, 1, 'delegue', 'comment tu vas???', '2023-03-25 14:01:20'),
(22, 1, 1, 'je vais bien et toi commenrt tu vas j\'espere que bien', '2023-03-25 14:20:07', 1, 1, 'delegue', 'je vais bien aussi', '2023-03-25 14:21:42'),
(23, 1, 1, 'tout va bien\'?', '2023-03-25 15:58:00', 1, 1, 'delegue', 'oui', '2023-03-25 16:07:12'),
(24, 1, 1, 'à moi maintenant', '2023-03-25 16:08:28', 1, 1, 'admin', 'ok', '2023-03-25 18:25:53'),
(25, 1, 1, 'c\'est bien comme ca ', '2023-03-25 18:26:08', 1, 1, 'delegue', 'Bonjour', '2023-03-30 11:27:31');

-- --------------------------------------------------------

--
-- Structure de la table `modification`
--

CREATE TABLE IF NOT EXISTS `modification` (
  `id_modification` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `modification` varchar(255) NOT NULL,
  `id_delegue` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_modification`),
  KEY `fk_delegue_id` (`id_delegue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `modification`
--

INSERT INTO `modification` (`id_modification`, `date`, `modification`, `id_delegue`, `status`) VALUES
(1, '2023-03-24 13:51:26', 'Le delegue a changé sa photo de profile ', 1, 'vu');

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` int(11) NOT NULL,
  `nouvelle` text NOT NULL,
  `cle` varchar(255) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  PRIMARY KEY (`id_news`),
  KEY `id_admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`id_news`, `id_admin`, `nouvelle`, `cle`, `date`) VALUES
(1, 1, 'Un nouveau produit a été ajouté: Aloes', 'product_avatar.jpg', '2023-03-23'),
(2, 1, 'Un nouveau produit a été ajouté: Naturally', '641c3785d209a4.51196150.jpeg', '2023-03-23'),
(3, 1, 'Un nouveau produit a été ajouté: uriage', '641c39500b4ab0.98482491.jpeg', '2023-03-23'),
(4, 1, 'Un nouveau produit a été ajouté: Exfoliant doux', '641c3a238ff381.64124200.jpeg', '2023-03-23'),
(5, 1, 'Un nouveau produit a été ajouté: Gel nettoyant', '641c3ad9508461.20434931.jpeg', '2023-03-23'),
(6, 1, 'Un nouveau produit a été ajouté: Masque purifiant', '641c3b5d0c0b32.59669617.jpeg', '2023-03-23'),
(7, 1, 'Un nouveau produit a été ajouté: Nivea', '641c3c856904a9.78214446.jpeg', '2023-03-23'),
(8, 1, 'Un nouveau produit a été ajouté: Vaccin contre la grippe', '641c3e822d8d81.68574399.jpeg', '2023-03-23'),
(9, 1, 'Un nouveau produit a été ajouté: Anti-venin', '641c3f8ca4c693.48954012.jpeg', '2023-03-23'),
(10, 1, 'Un nouveau produit a été ajouté: Anti cyanure', '641c4011c5a9a8.10534186.jpeg', '2023-03-23'),
(11, 1, 'Un nouveau produit a été ajouté: Réactine', '641c40b82b1753.28935332.jpeg', '2023-03-23'),
(12, 1, 'Un nouveau produit a été ajouté: Saforelle', '641c41c53da053.47610550.jpeg', '2023-03-23'),
(13, 1, 'Un nouveau produit a été ajouté: Massage gun', '641c457e397866.06243325.jpeg', '2023-03-23');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produit` varchar(50) NOT NULL,
  `id_gamme` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `photo_produit` varchar(255) NOT NULL DEFAULT 'product-avatar.jpg',
  PRIMARY KEY (`id_produit`),
  KEY `id_gamme` (`id_gamme`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom_produit`, `id_gamme`, `description`, `photo_produit`) VALUES
(3, 'Naturally', 1, 'crème de nuit', '641c3785d209a4.51196150.jpeg'),
(4, 'uriage', 1, ' Riche en minéraux grâce à l\'eau thermale d\'Uriage présente dans sa composition, elle permet également d\'assouplir la peau et d\'entretenir durablement son élasticité', '641c39500b4ab0.98482491.jpeg'),
(5, 'Exfoliant doux', 1, 'élimine les cellules mortes accumulées à la surface de la peau afin de révéler une peau plus lisse et lumineuse', '641c3a238ff381.64124200.jpeg'),
(6, 'Gel nettoyant', 1, 'Nettoie convénablement la peau des bactérie', '641c3ad9508461.20434931.jpeg'),
(7, 'Masque purifiant', 1, 'Un type de soin axé sur le nettoyage en profondeur de la peau, particulièrement destiné aux peaux mixtes à grasses, ainsi qu\'aux peaux à imperfections qui nécessite une action assainissante et séborégulatrice', '641c3b5d0c0b32.59669617.jpeg'),
(8, 'Nivea', 1, 'La  Crème NIVEA empêcher les irritations hivernales et prendre soin de la peau tout en douceur', '641c3c856904a9.78214446.jpeg'),
(9, 'Vaccin contre la grippe', 3, 'Meilleur vaccin pour ne plus attendre parler de la grippe', '641c3e822d8d81.68574399.jpeg'),
(10, 'Anti-venin', 3, 'Efficace contre le vénin de serpent', '641c3f8ca4c693.48954012.jpeg'),
(11, 'Anti cyanure', 3, 'Vaccin contre cyanure', '641c4011c5a9a8.10534186.jpeg'),
(12, 'Réactine', 4, 'Efficace contre l\'asthme', '641c40b82b1753.28935332.jpeg'),
(13, 'Saforelle', 5, 'Gel intime pour femme', '641c41c53da053.47610550.jpeg'),
(14, 'Massage gun', 6, 'pour le massage musculaire', '641c457e397866.06243325.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `up_contact_us`
--

CREATE TABLE IF NOT EXISTS `up_contact_us` (
  `id_contact_us` int(11) NOT NULL AUTO_INCREMENT,
  `nom_contact` varchar(255) NOT NULL,
  `email_contact` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message_contact` text NOT NULL,
  `traiter` int(11) NOT NULL DEFAULT 0,
  `date_c` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_contact_us`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `up_souscriber`
--

CREATE TABLE IF NOT EXISTS `up_souscriber` (
  `id_souscriber` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `date_s` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_souscriber`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `up_souscriber`
--

INSERT INTO `up_souscriber` (`id_souscriber`, `email`, `date_s`) VALUES
(1, 'tondesoulco@gmail.com', '2023-04-01 16:35:47'),
(3, 'ouffouetdexquis@gmail.com', '2023-04-01 16:35:47');

-- --------------------------------------------------------

--
-- Structure de la table `zone`
--

CREATE TABLE IF NOT EXISTS `zone` (
  `id_zone` int(11) NOT NULL AUTO_INCREMENT,
  `district` varchar(50) NOT NULL,
  PRIMARY KEY (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `zone`
--

INSERT INTO `zone` (`id_zone`, `district`) VALUES
(1, 'Abidjan'),
(2, 'Ouaga'),
(3, 'Paris'),
(4, 'Soubre');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `delegue_zone_produit`
--
ALTER TABLE `delegue_zone_produit`
  ADD CONSTRAINT `delegue_zone_produit_ibfk_1` FOREIGN KEY (`id_delegue`) REFERENCES `delegue` (`id_delegue`) ON DELETE CASCADE,
  ADD CONSTRAINT `delegue_zone_produit_ibfk_2` FOREIGN KEY (`id_zone`) REFERENCES `zone` (`id_zone`) ON DELETE CASCADE,
  ADD CONSTRAINT `delegue_zone_produit_ibfk_3` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE CASCADE;

--
-- Contraintes pour la table `gamme_produit`
--
ALTER TABLE `gamme_produit`
  ADD CONSTRAINT `gamme_produit_ibfk_1` FOREIGN KEY (`id_laboratoire`) REFERENCES `laboratoire` (`id_laboratoire`) ON DELETE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_delegue`) REFERENCES `delegue` (`id_delegue`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `modification`
--
ALTER TABLE `modification`
  ADD CONSTRAINT `fk_delegue_id` FOREIGN KEY (`id_delegue`) REFERENCES `delegue` (`id_delegue`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_gamme`) REFERENCES `gamme_produit` (`id_gamme`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
