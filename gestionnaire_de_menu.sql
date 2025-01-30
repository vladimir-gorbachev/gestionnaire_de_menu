-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 jan. 2025 à 10:39
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

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_ingredient` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  UNIQUE KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  UNIQUE KEY `menu_id` (`menu_id`),
  UNIQUE KEY `plats_id` (`plats_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  UNIQUE KEY `categorie_id` (`categorie_id`),
  UNIQUE KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plats_ingrédients`
--

DROP TABLE IF EXISTS `plats_ingredients`;
CREATE TABLE IF NOT EXISTS `plats_ingredients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plat_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plat_id` (`plat_id`),
  UNIQUE KEY `ingredient_id` (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Contraintes pour la table `plats_ingrédients`
--
ALTER TABLE `plats_ingredients`
  ADD CONSTRAINT `fk_ingredient_id` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plat_id` FOREIGN KEY (`plat_id`) REFERENCES `plats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/*création des catégories entrée,plat et dessert__________________*/

INSERT INTO categories (nom) VALUES 
('Entrée'), 
('Plat'), 
('Dessert');




/*insérer les 3 plats de référence _______________________________*/

INSERT INTO plats (nom, categorie_id, prix, description, image, utilisateur_id, partage) VALUES 
('Salade César', (SELECT id FROM categories WHERE nom = 'Entrée'), 4.00, 'Salade classique et savoureuse', "img/salade_cesar.png" , NULL, true),
('Gnocchi épinards gorgonzola', (SELECT id FROM categories WHERE nom = 'Plat'), 7.00, 'Plat italien crémeux et réconfortant',"img/gnocchis_epinards.png" , NULL, true),
('Pastel De Nata', (SELECT id FROM categories WHERE nom = 'Dessert'), 2.00, 'Petites tartes portugaises à la crème', "img/pastel_de_nata.png" , NULL, true);




/* Insérer le "menu par défaut"*_________________*/

INSERT INTO menus (nom, utilisateur_id, partage) VALUES ('Menu par défaut', NULL, true);

-- Associer les plats au menu
INSERT INTO menus_plats (menu_id, plat_id) VALUES 
((SELECT id FROM menus WHERE nom = 'Menu par défaut'), (SELECT id FROM plats WHERE nom = 'Salade César')),
((SELECT id FROM menus WHERE nom = 'Menu par défaut'), (SELECT id FROM plats WHERE nom = 'Gnocchi épinards gorgonzola')),
((SELECT id FROM menus WHERE nom = 'Menu par défaut'), (SELECT id FROM plats WHERE nom = 'Pastel De Nata'));



INSERT INTO ingredients (nom) VALUES 
('Laitue Romaine'),
('Poulet Grillé'),
('Parmesan'),
('Croûtons'),
('Sauce César'),
('Oeuf mollet'),
('Bacon'),
('Gnocchis'),
('Epinards frais'),
('Gorgonzola'),
('Crème fraiche liquide'),
('Ail'),
('Beurre'),
('Sel et Poivre'),
('Pate feuilletée'),
('Lait entier'),
('Farine'),
('Sucre'),
("Jaunes d'oeufs"),
('Zeste de citron');


-- Ingrédients pour Salade César
INSERT INTO plats_ingredients (plat_id, ingredient_id) VALUES 
((SELECT id FROM plats WHERE nom = 'Salade César'), (SELECT id FROM ingredients WHERE nom = 'Laitue Romaine')),
((SELECT id FROM plats WHERE nom = 'Salade César'), (SELECT id FROM ingredients WHERE nom = 'Poulet Grillé')),
((SELECT id FROM plats WHERE nom = 'Salade César'), (SELECT id FROM ingredients WHERE nom = 'Parmesan')),
((SELECT id FROM plats WHERE nom = 'Salade César'), (SELECT id FROM ingredients WHERE nom = 'Croûtons')),
((SELECT id FROM plats WHERE nom = 'Salade César'), (SELECT id FROM ingredients WHERE nom = 'Sauce César')),
((SELECT id FROM plats WHERE nom = 'Salade César'), (SELECT id FROM ingredients WHERE nom = 'Oeuf mollet')),
((SELECT id FROM plats WHERE nom = 'Salade César'), (SELECT id FROM ingredients WHERE nom = 'Bacon'));

-- Ingrédients pour Gnocchi épinards gorgonzola
INSERT INTO plats_ingredients (plat_id, ingredient_id) VALUES 
((SELECT id FROM plats WHERE nom = 'Gnocchi épinards gorgonzola'), (SELECT id FROM ingredients WHERE nom = 'Gnocchis')),
((SELECT id FROM plats WHERE nom = 'Gnocchi épinards gorgonzola'), (SELECT id FROM ingredients WHERE nom = 'Epinards frais')),
((SELECT id FROM plats WHERE nom = 'Gnocchi épinards gorgonzola'), (SELECT id FROM ingredients WHERE nom = 'Gorgonzola')),
((SELECT id FROM plats WHERE nom = 'Gnocchi épinards gorgonzola'), (SELECT id FROM ingredients WHERE nom = 'Crème fraiche liquide')),
((SELECT id FROM plats WHERE nom = 'Gnocchi épinards gorgonzola'), (SELECT id FROM ingredients WHERE nom = 'Ail')),
((SELECT id FROM plats WHERE nom = 'Gnocchi épinards gorgonzola'), (SELECT id FROM ingredients WHERE nom = 'Beurre')),
((SELECT id FROM plats WHERE nom = 'Gnocchi épinards gorgonzola'), (SELECT id FROM ingredients WHERE nom = 'Sel et Poivre'));

-- Ingrédients pour Pastel de Nata
INSERT INTO plats_ingredients (plat_id, ingredient_id) VALUES 
((SELECT id FROM plats WHERE nom = 'Pastel De Nata'), (SELECT id FROM ingredients WHERE nom = 'Pate feuilletée')),
((SELECT id FROM plats WHERE nom = 'Pastel De Nata'), (SELECT id FROM ingredients WHERE nom = 'Lait entier')),
((SELECT id FROM plats WHERE nom = 'Pastel De Nata'), (SELECT id FROM ingredients WHERE nom = 'Farine')),
((SELECT id FROM plats WHERE nom = 'Pastel De Nata'), (SELECT id FROM ingredients WHERE nom = 'Sucre')),
((SELECT id FROM plats WHERE nom = 'Pastel De Nata'), (SELECT id FROM ingredients WHERE nom = "Jaunes d'oeufs")),
((SELECT id FROM plats WHERE nom = 'Pastel De Nata'), (SELECT id FROM ingredients WHERE nom = 'Zeste de citron'));
