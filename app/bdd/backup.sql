-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 22 avr. 2025 à 07:16
-- Version du serveur : 10.6.21-MariaDB
-- Version de PHP : 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tima6358_yoann-laubert-projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int(11) NOT NULL,
  `date_heure` timestamp NOT NULL DEFAULT current_timestamp(),
  `montant_total` decimal(15,2) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `statut` enum('en_attente_paiement','paiement_accepte','en_validation','en_preparation','prete_a_expedier','expediee','en_cours_de_livraison','livree','annulee','remboursee','en_retour','retour_recu','echec_paiement','litige_en_cours','partiellement_expediee') NOT NULL DEFAULT 'en_attente_paiement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `date_heure`, `montant_total`, `id_utilisateur`, `statut`) VALUES
(33, '2025-04-17 18:09:58', 199.99, 22, 'en_attente_paiement'),
(35, '2025-04-18 16:58:00', 1990.99, 26, 'en_attente_paiement'),
(36, '2025-04-18 16:58:15', 1990.99, 26, 'en_attente_paiement');

-- --------------------------------------------------------

--
-- Structure de la table `commerce`
--

CREATE TABLE `commerce` (
  `id_commerce` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `adresse_livraison` varchar(255) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `pays` varchar(100) DEFAULT 'France',
  `telephone` varchar(20) DEFAULT NULL,
  `mode_paiement` enum('carte','paypal','virement','autre') DEFAULT 'carte'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commerce`
--

INSERT INTO `commerce` (`id_commerce`, `id_utilisateur`, `nom`, `prenom`, `adresse_livraison`, `ville`, `code_postal`, `pays`, `telephone`, `mode_paiement`) VALUES
(7, 13, 'robertoto', 'john', '1783 Rue de Paris', 'Rennes', '35000', 'France', '0123456789', 'carte'),
(8, 22, 'Boby', 'john', '2 place de la John', 'Saint-Brevin-les-Pins', '44250', 'France', '0723456789', 'autre'),
(9, 19, 'Toy', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id_contact` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id_contact`, `id_utilisateur`, `nom`, `email`, `message`, `created_at`) VALUES
(1, NULL, 'Jean Dupont', 'jean.dupont@example.com', 'Bonjour, j’aimerais avoir plus d’informations sur votre service.', '2025-03-28 10:59:43'),
(2, NULL, 'Alice Martin', 'alice.martin@example.com', 'J’ai rencontré un problème lors de l’inscription.', '2025-03-28 10:59:43'),
(3, NULL, 'Sophie Lemoine', 'sophie.lemoine@example.com', 'Je vous remercie pour votre travail, c’est super !', '2025-03-28 10:59:43'),
(4, NULL, 'Thomas Bernard', 'thomas.bernard@example.com', 'Est-il possible de modifier mon adresse e-mail ?', '2025-03-28 10:59:43'),
(5, NULL, 'David Moreau', 'david.moreau@example.com', 'Je ne parviens pas à accéder à mon compte.', '2025-03-28 10:59:43'),
(12, 13, 'Bob', 'robert@sponge.us', 'JE ME QUESTIONNE', '2025-03-28 13:54:13'),
(13, 13, 'robertous', 'robert@sponge.us', 'Je m questionne à nouveau', '2025-04-02 11:42:45'),
(19, 13, 'robertous', 'robert@sponge.us', 'tyjvhfcfy', '2025-04-02 12:01:13'),
(20, NULL, 'bla Blo', 'monemasus@gmail.com', 'Ploplop\r\n\r\nToy toy toy\r\n\r\nxoxo\r\n\r\nm', '2025-04-12 15:57:02'),
(21, 22, 'Boby', 'laubert.yoann@gmail.com', 'Heyheyhey', '2025-04-17 14:07:55');

-- --------------------------------------------------------

--
-- Structure de la table `detail_commande`
--

CREATE TABLE `detail_commande` (
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantité` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `detail_commande`
--

INSERT INTO `detail_commande` (`id_commande`, `id_produit`, `quantité`) VALUES
(33, 10, 1),
(35, 10, 1),
(36, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `parties`
--

CREATE TABLE `parties` (
  `id_partie` int(11) NOT NULL,
  `score` bigint(20) NOT NULL,
  `date_heure` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `parties`
--

INSERT INTO `parties` (`id_partie`, `score`, `date_heure`, `id_utilisateur`) VALUES
(7, 396, '2025-04-14 16:44:48', 13),
(8, 249, '2025-04-14 22:31:11', 13),
(9, 33, '2025-04-16 00:36:49', 13),
(10, 36, '2025-04-16 21:08:17', 13),
(11, 69, '2025-04-17 01:17:34', 22),
(12, 7, '2025-04-17 14:02:44', 22),
(13, 74, '2025-04-17 14:07:33', 22),
(14, 51, '2025-04-17 21:18:10', 19),
(15, 113, '2025-04-17 21:27:14', 19),
(16, 137, '2025-04-17 21:37:21', 13),
(17, 81, '2025-04-18 18:38:22', 19),
(18, 90, '2025-04-18 18:45:50', 19),
(20, 78, '2025-04-20 23:02:48', 13),
(21, 88, '2025-04-21 10:32:45', 13),
(22, 86, '2025-04-22 01:01:07', 22),
(23, 115, '2025-04-22 01:11:02', 22);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `disponibilite` enum('en_stock','epuise') NOT NULL DEFAULT 'en_stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `nom`, `description`, `prix`, `photo`, `disponibilite`) VALUES
(10, 'Orbe', 'Un drone en forme de sphère avec IA intégrée', 1990.99, './publique/images/imports/680251cc4e126-3.webp', 'en_stock');

-- --------------------------------------------------------

--
-- Structure de la table `reponses_contacts`
--

CREATE TABLE `reponses_contacts` (
  `id_reponse` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `reponse` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp(),
  `rôle` enum('utilisateur','admin') NOT NULL DEFAULT 'utilisateur',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `date_inscription`, `rôle`, `email`, `password`) VALUES
(13, '2025-03-26 18:21:59', 'utilisateur', 'robert@sponge.us', '$2y$10$PgXVIO7VikV0aOljA/t7D.b8eALFEJYD2AjY5n9mFaa2uTCMqdCKO'),
(19, '2025-04-12 15:59:40', 'utilisateur', 'monemasus@gmail.com', '$2y$10$/I59d1RgBV6eimJiWrLT2e4AzY9NLbwu7QKNxzC8XbWAsR.VyNrpq'),
(20, '2025-04-14 06:23:33', 'utilisateur', 'lucaskiller566@gmail.com', '$2y$10$Y1u3Ctdxh5xi/ehoDtUpUelFO2y02xlN4BOTW2ghjLAmDhT2wIUK2'),
(21, '2025-04-15 21:01:28', 'utilisateur', 'a.hovelaque@gmail.com', '$2y$10$KMHJDpiLipfiUPMk/vkP5e5vkq.qGSvdrrD3unmzOFUK911L/LUt6'),
(22, '2025-04-17 00:28:22', 'utilisateur', 'laubert.yoann@gmail.com', '$2y$10$jvSlXsPBsPpTvgID/lsBVuy2mDnoN6gonP1L2iPYAt4zRDrtXR0D2'),
(23, '2025-04-17 18:59:12', 'utilisateur', 'nathalie.dorso@wanadoo.fr', '$2y$10$LBBuWSufQLaaVPUr60P2N.6T2/iFhcFuyDn1Lb3HDyO1DvBkv2j4i'),
(24, '2025-04-17 19:37:17', 'utilisateur', 'steph56lebroc@gmail.com', '$2y$10$U2gZeGTPyZxAZSY5Xmxew.VoL5DLpZUUPWzojnwN/18a51lkc7UKi'),
(26, '2025-04-18 16:55:56', 'utilisateur', 'Elonmusk@yahoo.fr', '$2y$10$EG8CmZjTTDAvjCsLxrrzAO25gt6tXkWD8bfdj8yGev64D9RWBcemO'),
(27, '2025-04-20 23:05:34', 'utilisateur', 'blorg@test.com', '$2y$10$zfju1Xpg7c2JnP65.lqpO.Ut3rXnhDF0n8P9xQdgdbwVQYKqOvBUe'),
(28, '2025-04-22 07:10:58', 'admin', 'johngreta904@gmail.com', '$2y$10$sEb5qSSSOshA/7HbxhfecuV61P1rxnHKmUrS1eV5wH7uRQJ8QM.6e');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `commerce`
--
ALTER TABLE `commerce`
  ADD PRIMARY KEY (`id_commerce`),
  ADD UNIQUE KEY `id_utilisateur` (`id_utilisateur`) USING BTREE;

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id_contact`),
  ADD KEY `fk_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `detail_commande`
--
ALTER TABLE `detail_commande`
  ADD PRIMARY KEY (`id_commande`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id_partie`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `reponses_contacts`
--
ALTER TABLE `reponses_contacts`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `fk_contact` (`id_contact`),
  ADD KEY `fk_admin` (`id_admin`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `commerce`
--
ALTER TABLE `commerce`
  MODIFY `id_commerce` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `parties`
--
ALTER TABLE `parties`
  MODIFY `id_partie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `reponses_contacts`
--
ALTER TABLE `reponses_contacts`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commerce`
--
ALTER TABLE `commerce`
  ADD CONSTRAINT `commerce_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `detail_commande`
--
ALTER TABLE `detail_commande`
  ADD CONSTRAINT `detail_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id_commande`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE;

--
-- Contraintes pour la table `parties`
--
ALTER TABLE `parties`
  ADD CONSTRAINT `parties_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reponses_contacts`
--
ALTER TABLE `reponses_contacts`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`id_admin`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_contact` FOREIGN KEY (`id_contact`) REFERENCES `contacts` (`id_contact`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
