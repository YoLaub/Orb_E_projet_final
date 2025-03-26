CREATE DATABASE orbe;
USE orbe;

CREATE TABLE utilisateurs(
   id_utilisateur INT AUTO_INCREMENT,
   date_inscription timestamp NOT NULL CURRENT_TIMESTAMP,
   rôle ENUM('utilisateur', 'admin') NOT NULL DEFAULT 'utilisateur',
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(100) UNIQUE NOT NULL,
   password VARCHAR(255) NOT NULL,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE commandes (
   id_commande INT AUTO_INCREMENT PRIMARY KEY,
   date_commande timestamp NOT NULL CURRENT_TIMESTAMP,
   montant_total DECIMAL(15,2) NOT NULL,
   id_utilisateur INT NOT NULL,
   FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE
);

CREATE TABLE parties(
   id_partie INT AUTO_INCREMENT,
   score BIGINT NOT NULL,
   date_heure timestamp NOT NULL CURRENT_TIMESTAMP,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_partie),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE
);

CREATE TABLE produits(
   id_produit INT AUTO_INCREMENT,
   nom VARCHAR(20) NOT NULL,
   description TEXT NOT NULL,
   prix DECIMAL(10,2) NOT NULL,
   photo VARCHAR(255) NOT NULL,
   PRIMARY KEY(id_produit)
);


CREATE TABLE detail_commande(
   id_commande INT,
   id_produit INT,
   quantité SMALLINT UNSIGNED NOT NULL,
   PRIMARY KEY(id_commande, id_produit),
   FOREIGN KEY(id_commande) REFERENCES commandes(id_commande) ON DELETE CASCADE,
   FOREIGN KEY(id_produit) REFERENCES produits(id_produit) ON DELETE CASCADE
);