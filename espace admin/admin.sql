-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 20 juin 2024 à 15:44
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `admin`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_login`
--

CREATE TABLE `admin_login` (
  `Id_admin` int(11) NOT NULL,
  `Admin_Name` varchar(50) NOT NULL,
  `Admin_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_login`
--

INSERT INTO `admin_login` (`Id_admin`, `Admin_Name`, `Admin_password`) VALUES
(1, 'admin', 'admin1234'),
(9, 'nourhane', 'nourhane1234');

-- --------------------------------------------------------

--
-- Structure de la table `catégories`
--

CREATE TABLE `catégories` (
  `Id_categorie` int(11) NOT NULL,
  `nomcategorie` varchar(20) NOT NULL,
  `descriptioncategorie` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `jour_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `catégories`
--

INSERT INTO `catégories` (`Id_categorie`, `nomcategorie`, `descriptioncategorie`, `status`, `jour_creation`) VALUES
(5, 'Graphic Designer', 'Graphic Designer', 1, '2024-06-12 23:56:56'),
(6, 'Developement mobile', 'Developement mobile', 1, '2024-06-12 23:57:07'),
(7, 'Fb ads', 'Fb ads', 1, '2024-06-16 20:10:54');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `Id_formations` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date_commande` datetime NOT NULL,
  `etat` varchar(50) DEFAULT 'en_attente',
  `Id_membre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `prenom`, `nom`, `telephone`, `email`, `Id_formations`, `price`, `date_commande`, `etat`, `Id_membre`) VALUES
(9, 'Nourhane', 'Bendjeddou', '0658934340', 'nourhanebndj@gmail.com', 14, 8000.00, '2024-06-20 13:42:47', 'en_attente', 3),
(10, 'Loubna', 'Lekouaghet', '0550560868', 'Loub0416@gmail.com', 14, 8000.00, '2024-06-20 13:56:29', 'en_attente', 3),
(11, 'Nihed', 'Mebrek', '0658934340', 'Mebreknihed0@gmail.com', 14, 8000.00, '2024-06-20 13:58:45', 'en_attente', 3),
(12, 'Yasmine', 'Bendjeddou', '0550560868', 'nourhanebendjeddou23@gmail.com', 14, 8000.00, '2024-06-20 14:57:37', 'en_attente', 3);

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `Id_formations` int(11) NOT NULL,
  `Id_categorie` varchar(100) NOT NULL,
  `nom_formation` varchar(191) NOT NULL,
  `description` mediumtext NOT NULL,
  `Prix` int(11) NOT NULL,
  `Prix_Promotion` int(11) NOT NULL,
  `images` varchar(191) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`Id_formations`, `Id_categorie`, `nom_formation`, `description`, `Prix`, `Prix_Promotion`, `images`, `date_creation`) VALUES
(12, '6', 'Developement Web', 'Avez-vous besoin d’une boutique attrayante et qui augmente vos ventes en ligne?\r\n\r\nDécouvrez comment créer des boutiques en ligne captivantes et rentables pour vendre vos produits. \r\n\r\nSoyez à la pointe de la tendance de l’e-commerce et inscrivez-vous dès maintenant. ', 20000, 15000, '1718556448.jpg', '2024-06-16 16:47:28'),
(13, '5', 'Graphic designer', 'Plongez au cœur de Photoshop et découvrez toutes ses fonctions, des plus basiques aux plus avancées. À travers des projets pratiques, apprenez à transformer vos idées en visuels époustouflants. Que vous soyez débutant ou déjà familiarisé avec le logiciel, cette formation est conçue pour vous permettre d’atteindre l’excellence.', 20000, 18000, '1718556474.jpg', '2024-06-16 16:47:54'),
(14, '5', 'Formation sur Motion Design', 'Découvrez comment maîtriser le Motion Design pour créer des vidéos animées qui se vendent.\r\n\r\nApprenez les bases d’Illustrator et d’After Effects, ainsi que les meilleures techniques de Motion Design.\r\n\r\nExplorez, étape par étape, comment animer vos illustrations et créer des vidéos explicatives.', 9000, 8000, '1718564761.jpg', '2024-06-16 19:06:01'),
(15, '7', 'Formation sur Facebook Ads', 'Vous avez des problèmes avec Facebook Ads ? C’est parce que vous ne le maîtrisez pas encore.\r\n\r\nNe vous inquiétez pas, notre formation en ligne est là pour vous aider à relever ce défi.\r\n\r\nDu niveau débutant à avancé, nous vous guiderons pas à pas pour que vous puissiez créer des campagnes publicitaires réussies sur Facebook et Instagram.', 10000, 9000, '1718565114.jpg', '2024-06-16 19:11:54');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`Id_admin`);

--
-- Index pour la table `catégories`
--
ALTER TABLE `catégories`
  ADD PRIMARY KEY (`Id_categorie`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formation_id` (`Id_formations`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`Id_formations`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `Id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `catégories`
--
ALTER TABLE `catégories`
  MODIFY `Id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `Id_formations` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`Id_formations`) REFERENCES `formations` (`Id_formations`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
