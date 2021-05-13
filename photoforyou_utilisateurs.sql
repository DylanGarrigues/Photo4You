-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 13 mai 2021 à 23:31
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `photoforyou`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorys`
--

DROP TABLE IF EXISTS `categorys`;
CREATE TABLE IF NOT EXISTS `categorys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(1024) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `categorys`
--

INSERT INTO `categorys` (`id`, `name`, `description`) VALUES
(1, 'Paysage', 'Des paysages à coupé le souffle !'),
(2, 'Evenements', 'Photos Evenementielles'),
(3, 'Portraits', 'Les meilleurs portraits');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL COMMENT 'clé étrangère de utilisateurs',
  `price` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `category` varchar(255) COLLATE utf8_bin NOT NULL,
  `link` varchar(1024) COLLATE utf8_bin NOT NULL,
  `size` varchar(255) COLLATE utf8_bin NOT NULL,
  `buyed` int(11) NOT NULL DEFAULT 0,
  `buyer` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `owner`, `price`, `name`, `category`, `link`, `size`, `buyed`, `buyer`) VALUES
(10, 11, 10, 'France', '1', 'http://127.0.0.6/files/2021-0505-0505drapeau_FR.png', '(1200x800)', 0, 0),
(11, 11, 10, 'logo', '1', 'http://127.0.0.6/files/2021-0505-0505logo.jpg', '(400x400)', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateurs` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8_bin NOT NULL,
  `role` int(11) NOT NULL COMMENT '1 = Photographe 0 = Client',
  `prenom` varchar(25) COLLATE utf8_bin NOT NULL,
  `nom` varchar(25) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(15) COLLATE utf8_bin NOT NULL,
  `motdepasse` varchar(255) COLLATE utf8_bin NOT NULL,
  `cart` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `coins` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_utilisateurs`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateurs`, `email`, `role`, `prenom`, `nom`, `pseudo`, `motdepasse`, `cart`, `coins`) VALUES
(10, 'dylangarrigues55@gmail.com', 0, 'Dylan', 'GARRIGUES', 'LinkOkarys', '$2y$10$jys2X1keDzWmKDoKVf8Ms.Tee/avLOqKh/kGPNghJtmQhAKM0KVlK', '[]', 543111),
(11, 'contact@lenglet.pro', 1, 'Stéphane', 'Lenglet', 'Sywoo', '$2y$10$0aDs/XvFZb0Wy2GW9bIeeOhc4KF6IinaVgJYuXKUKbO3QEv7s.3by', NULL, 45230),
(12, 'michel@gmail.com', 0, 'Michel', 'gnu', 'Gneeee', '$2y$10$CJGwq6lr5kRgZvfIoSZbIOobD3PWR/8I7mgjIQaIpEEfljwjCsNPi', '[]', 85265),
(16, 'test@gmail.com', 1, 'test', 'test', 'test', '$2y$10$9TEnxGGdgbD930FuHTgxS.wati/34FKXZ7LPds4Cgz2cRGcBCRBPK', NULL, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
