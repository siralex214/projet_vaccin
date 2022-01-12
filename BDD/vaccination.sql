-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 jan. 2022 à 11:17
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vaccination`
--

-- --------------------------------------------------------

--
-- Structure de la table `mdp_forgot`
--

CREATE TABLE `mdp_forgot` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(10) NOT NULL,
  `confirmation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL,
  `sexe` varchar(5) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_de_naissance` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `CGU` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `role`, `sexe`, `nom`, `prenom`, `date_de_naissance`, `email`, `pwd`, `CGU`) VALUES
(1, 'role_ADMIN', 'homme', 'mouchon', 'alexis', '2021-06-09', 'admin@admin.com', '$argon2id$v=19$m=65536,t=4,p=1$ZGVEeHdxdDUzYVRtcmc0dQ$adl5h+pJz0pCm4lYH+VWpVJuvqftBlzASiZRN5NrLuA', 1),
(9, 'role_USER', 'homme', 'user', 'user', '2001-04-08', 'user@user.com', '$argon2i$v=19$m=65536,t=4,p=1$c3N3MEJicXlBVzkzdk1zQw$eEg8IvpxZlGHOjrmypZs0CgchY0/QBRMAnAFynlWJQA', 0);

-- --------------------------------------------------------

--
-- Structure de la table `vaccins`
--

CREATE TABLE `vaccins` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nom_du_vaccin` varchar(100) NOT NULL,
  `date_injection` datetime NOT NULL,
  `type_vaccin` varchar(100) NOT NULL,
  `mail_rappel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `vaccins`
--

INSERT INTO `vaccins` (`id`, `id_user`, `nom_du_vaccin`, `date_injection`, `type_vaccin`, `mail_rappel`) VALUES
(1, 1, 'grippe', '2022-01-03 14:16:49', 'sdqqshdjkqshd', 0),
(6, 1, 'grippe', '2022-01-03 14:16:49', 'sdqqshdjkqshd', 0),
(11, 1, 'grippe', '2022-01-03 14:16:49', 'sdqqshdjkqshd', 0),
(16, 1, 'grippe', '2022-01-03 14:16:49', 'sdqqshdjkqshd', 0),
(24, 9, 'Engerix B 10®', '2022-01-12 10:46:00', 'Méningo-encéphalite à tiques', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `mdp_forgot`
--
ALTER TABLE `mdp_forgot`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vaccins`
--
ALTER TABLE `vaccins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `mdp_forgot`
--
ALTER TABLE `mdp_forgot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `vaccins`
--
ALTER TABLE `vaccins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `vaccins`
--
ALTER TABLE `vaccins`
  ADD CONSTRAINT `vaccins_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
