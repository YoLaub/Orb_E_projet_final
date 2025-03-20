CREATE DATABASE orbe;
USE orbe;

CREATE TABLE Utilisateur(
   Id_Utilisateur INT AUTO_INCREMENT,
   date_inscription DATE NOT NULL,
   rôle VARCHAR(50) NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(100) NOT NULL,
   password VARCHAR(255) NOT NULL,
   PRIMARY KEY(Id_Utilisateur)
);

CREATE TABLE Commande(
   Id_Commande INT AUTO_INCREMENT,
   date_commande DATE NOT NULL,
   quantité SMALLINT NOT NULL,
   montant_total DECIMAL(15,2) NOT NULL,
   Id_Utilisateur INT NOT NULL,
   PRIMARY KEY(Id_Commande),
   FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur)
);

CREATE TABLE score(
   Id_score INT AUTO_INCREMENT,
   score BIGINT NOT NULL,
   date_classement DATE NOT NULL,
   Id_Utilisateur INT NOT NULL,
   PRIMARY KEY(Id_score),
   FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur)
);

CREATE TABLE Produit(
   Id_Produit INT AUTO_INCREMENT,
   nom VARCHAR(20) NOT NULL,
   description TEXT NOT NULL,
   prix DECIMAL(10,2) NOT NULL,
   PRIMARY KEY(Id_Produit)
);

CREATE TABLE Classement_journalier(
   Id_Classement_journalier INT AUTO_INCREMENT,
   score BIGINT NOT NULL,
   date_classement DATE NOT NULL,
   Id_Utilisateur INT,
   PRIMARY KEY(Id_Classement_journalier),
   FOREIGN KEY(Id_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur)
);

CREATE TABLE Detail_commande(
   Id_Commande INT,
   Id_Produit INT,
   quantité SMALLINT NOT NULL,
   prix_unitaire DECIMAL(10,2) NOT NULL,
   PRIMARY KEY(Id_Commande, Id_Produit),
   FOREIGN KEY(Id_Commande) REFERENCES Commande(Id_Commande),
   FOREIGN KEY(Id_Produit) REFERENCES Produit(Id_Produit)
);