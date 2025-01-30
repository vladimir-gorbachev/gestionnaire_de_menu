-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 jan. 2025 à 15:48
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionnaire_de_menu`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(4, 'Entrée'),
(5, 'Plat'),
(6, 'Dessert');

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_ingredient` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`id`, `nom_ingredient`) VALUES
(1, 'Laitue Romaine'),
(2, 'Poulet Grillé'),
(3, 'Parmesan'),
(4, 'Croûtons'),
(5, 'Sauce César'),
(6, 'Oeuf mollet'),
(7, 'Bacon'),
(8, 'Gnocchis'),
(9, 'Epinards frais'),
(10, 'Gorgonzola'),
(11, 'Crème fraiche liquide'),
(12, 'Ail'),
(13, 'Beurre'),
(14, 'Sel et Poivre'),
(15, 'Pate feuilletée'),
(16, 'Lait entier'),
(17, 'Farine'),
(18, 'Sucre'),
(19, 'Jaunes d\'oeufs'),
(20, 'Zeste de citron');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `utilisateur_id` int NOT NULL,
  `partage` tinyint(1) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `nom`, `utilisateur_id`, `partage`, `description`, `prix`, `image`) VALUES
(3, 'Menu exemple', 1, 1, '', 13.00, '');

-- --------------------------------------------------------

--
-- Structure de la table `menu_plats`
--

DROP TABLE IF EXISTS `menu_plats`;
CREATE TABLE IF NOT EXISTS `menu_plats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `plats_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`) USING BTREE,
  KEY `plats_id` (`plats_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menu_plats`
--

INSERT INTO `menu_plats` (`id`, `menu_id`, `plats_id`) VALUES
(1, 3, 1),
(5, 3, 1),
(6, 3, 2),
(7, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

DROP TABLE IF EXISTS `plats`;
CREATE TABLE IF NOT EXISTS `plats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `categorie_id` int NOT NULL,
  `prix` decimal(6,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `utilisateur_id` int NOT NULL,
  `partage` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`) USING BTREE,
  KEY `categorie_id` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`id`, `nom`, `categorie_id`, `prix`, `description`, `image`, `utilisateur_id`, `partage`) VALUES
(1, 'Salade César', 4, 4.00, 'Salade classique et savoureuse, composée de laitue romaine croquante, de poulet grillé, de copeaux de parmesan, de croûtons dorés, et relevée par une sauce crémeuse à base de mayonnaise, d\'ail, de parmesan et d\'anchois. Ce plat, à la fois léger et gourmand, est idéal en entrée ou en plat principal.', 'images/mon_image.jpg', 1, 1),
(2, 'Gnocchi épinards Gorgonzola', 5, 7.00, 'Plat italien crémeux et réconfortant. Les gnocchis moelleux sont enrobés d\'une sauce onctueuse au gorgonzola, sublimée par la douceur des épinards et une touche de muscade. Un mélange parfait de saveurs et de textures pour un repas gourmand.', 'images/mon_image.jpg', 1, 1),
(3, 'Pastel de Nata', 6, 2.00, 'Petites tartes portugaises à la crème, au cœur fondant et parfumé à la cannelle et au citron, nichées dans une pâte feuilletée croustillante. Un délice emblématique du Portugal, souvent dégusté tiède avec une touche de sucre glace ou de cannelle.', 'images/pastel_de_nata.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `plats_ingredients`
--

DROP TABLE IF EXISTS `plats_ingredients`;
CREATE TABLE IF NOT EXISTS `plats_ingredients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plat_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `plat_id` (`plat_id`) USING BTREE,
  KEY `ingredient_id` (`ingredient_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plats_ingredients`
--

INSERT INTO `plats_ingredients` (`id`, `plat_id`, `ingredient_id`) VALUES
(77, 1, 1),
(80, 1, 2),
(82, 1, 3),
(84, 1, 4),
(87, 1, 5),
(89, 1, 6),
(93, 1, 7),
(95, 2, 8),
(96, 2, 9),
(97, 2, 10),
(98, 2, 11),
(99, 2, 12),
(100, 2, 13),
(101, 2, 14),
(102, 3, 15),
(103, 3, 15),
(104, 3, 16),
(105, 3, 17),
(106, 3, 18),
(107, 3, 19),
(108, 3, 20);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mot_de_passe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_nom_utilisateur` (`nom_utilisateur`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom_utilisateur`, `mot_de_passe`, `email`) VALUES
(1, 'vladimir', 'vladimir', 'vladimir.gorbachev@laplateforme.io'),
(3, 'utilisateur', 'utilisateur', 'utilisateur@laplateforme.io');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `fk_menus_utilisateur_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `menu_plats`
--
ALTER TABLE `menu_plats`
  ADD CONSTRAINT `fk_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menu_plats_plat_id` FOREIGN KEY (`plats_id`) REFERENCES `plats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `plats`
--
ALTER TABLE `plats`
  ADD CONSTRAINT `fk_categorie_id` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utilisateur_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `plats_ingredients`
--
ALTER TABLE `plats_ingredients`
  ADD CONSTRAINT `fk_ingrédient_id` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plat_id` FOREIGN KEY (`plat_id`) REFERENCES `plats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
