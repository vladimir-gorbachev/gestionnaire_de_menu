-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 28 jan. 2025 à 12:49
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
-- Structure de la table `catégories`
--

DROP TABLE IF EXISTS `catégories`;
CREATE TABLE IF NOT EXISTS `catégories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `catégories`
--

INSERT INTO `catégories` (`id`, `nom`, `description`) VALUES
(1, 'entrées', 'mini miams'),
(2, 'plats', 'quel poulet'),
(3, 'desserts', 'par pure gourmandise..');

-- --------------------------------------------------------

--
-- Structure de la table `ingrédients`
--

DROP TABLE IF EXISTS `ingrédients`;
CREATE TABLE IF NOT EXISTS `ingrédients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plats_id` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plats_id` (`plats_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_de_création` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `utilisateur_id` (`utilisateur_id`) USING BTREE,
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menus_favoris`
--

DROP TABLE IF EXISTS `menus_favoris`;
CREATE TABLE IF NOT EXISTS `menus_favoris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `utilisateur_id` int NOT NULL,
  `menu_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_id` (`menu_id`),
  UNIQUE KEY `utilisateur_id` (`utilisateur_id`) USING BTREE,
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

DROP TABLE IF EXISTS `plats`;
CREATE TABLE IF NOT EXISTS `plats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `menu_id` int NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_de_création` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_id` (`menu_id`),
  UNIQUE KEY `categorie_id` (`categorie_id`) USING BTREE,
  UNIQUE KEY `nom` (`nom`),
  UNIQUE KEY `prix` (`prix`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plats_favoris`
--

DROP TABLE IF EXISTS `plats_favoris`;
CREATE TABLE IF NOT EXISTS `plats_favoris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `utilisateur_id` int NOT NULL,
  `plat_id` int NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plat_id` (`plat_id`),
  UNIQUE KEY `utilisateur_id` (`utilisateur_id`) USING BTREE,
  UNIQUE KEY `nom` (`nom`),
  KEY `fk_plat_favoris_prix` (`prix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plats_ingrédients`
--

DROP TABLE IF EXISTS `plats_ingrédients`;
CREATE TABLE IF NOT EXISTS `plats_ingrédients` (
  `id_plats` int NOT NULL,
  `id_ingrédients` int NOT NULL,
  UNIQUE KEY `id_plats` (`id_plats`),
  KEY `fk_plats_ingrédients_ingrédients_id` (`id_ingrédients`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plats_partagés`
--

DROP TABLE IF EXISTS `plats_partagés`;
CREATE TABLE IF NOT EXISTS `plats_partagés` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `plats_id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `partagé` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`plats_id`),
  UNIQUE KEY `utilisateur_id` (`utilisateur_id`) USING BTREE,
  UNIQUE KEY `nom` (`nom`),
  UNIQUE KEY `prix` (`prix`),
  KEY `fk_plats_partagés_id_plats_id` (`plats_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO plats_partagés (id,utilisateur_id, plats_id, nom, prix, description, partagé) 
VALUES 
(1, 101, "Salade César", 12.50, "Une salade composée de laitue, poulet, croûtons et parmesan.", 1),
(1, 102, "Gnocchis aux épinards", 15.00, "Des gnocchis frais accompagnés d'une sauce aux épinards crémeuse.", 1),
(1, 103, "Pastel de Nata", 4.00, "Un dessert portugais classique à base de pâte feuilletée et de crème pâtissière.", 0);


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom_utilisateur`, `mot_de_passe`, `email`) VALUES
(1, 'Vladimir', '12345678', 'vladimir.gorbachev@laplateforme.io');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ingrédients`
--
ALTER TABLE `ingrédients`
  ADD CONSTRAINT `fk_ingrédients_plats_id_plats_id` FOREIGN KEY (`plats_id`) REFERENCES `plats` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `fk_menus_user_id_users_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `menus_favoris`
--
ALTER TABLE `menus_favoris`
  ADD CONSTRAINT `fk_menu_favoris_menus_id` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menu_favoris_menus_nom` FOREIGN KEY (`nom`) REFERENCES `menus` (`nom`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_menu_favoris_user_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `plats`
--
ALTER TABLE `plats`
  ADD CONSTRAINT `fk_category_id_categories_id` FOREIGN KEY (`categorie_id`) REFERENCES `catégories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_plats_id_users_id` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `plats_favoris`
--
ALTER TABLE `plats_favoris`
  ADD CONSTRAINT `fk_plat_favoris_plat_id` FOREIGN KEY (`plat_id`) REFERENCES `plats` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plat_favoris_plat_nom` FOREIGN KEY (`nom`) REFERENCES `plats` (`nom`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_plat_favoris_prix` FOREIGN KEY (`prix`) REFERENCES `plats` (`prix`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plat_favoris_user_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `plats_ingrédients`
--
ALTER TABLE `plats_ingrédients`
  ADD CONSTRAINT `fk_plats_ingrédients_ingrédients_id` FOREIGN KEY (`id_ingrédients`) REFERENCES `ingrédients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plats_ingrédients_plats_id` FOREIGN KEY (`id_plats`) REFERENCES `plats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `plats_partagés`
--
ALTER TABLE `plats_partagés`
  ADD CONSTRAINT `fk_plats_favoris_plats_prix` FOREIGN KEY (`prix`) REFERENCES `plats` (`prix`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plats_partagés_id_plats_id` FOREIGN KEY (`plats_id`) REFERENCES `plats` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_plats_partagés_plats_noms` FOREIGN KEY (`nom`) REFERENCES `plats` (`nom`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plats_partagés_user_id` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
