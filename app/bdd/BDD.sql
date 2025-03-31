CREATE DATABASE orbe;
USE orbe;

CREATE TABLE utilisateurs(
   id_utilisateur INT AUTO_INCREMENT,
   date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   rôle ENUM('utilisateur', 'admin') NOT NULL DEFAULT 'utilisateur',
   email VARCHAR(100) UNIQUE NOT NULL,
   password VARCHAR(255) NOT NULL,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE commandes (
   id_commande INT AUTO_INCREMENT PRIMARY KEY,
   date_heure TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
   statut ENUM(
        'en_attente_paiement',
        'paiement_accepte',
        'en_validation',
        'en_preparation',
        'prete_a_expedier',
        'expediee',
        'en_cours_de_livraison',
        'livree',
        'annulee',
        'remboursee',
        'en_retour',
        'retour_recu',
        'echec_paiement',
        'litige_en_cours',
        'partiellement_expediee'
    ) NOT NULL DEFAULT 'en_attente_paiement',
   montant_total DECIMAL(15,2) NOT NULL,
   id_utilisateur INT NOT NULL,
   FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE
);

CREATE TABLE parties (
   id_partie INT AUTO_INCREMENT,
   score BIGINT NOT NULL,
   date_heure TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
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
   disponibilité ENUM("en_stock", "epuise")  NOT NULL DEFAULT 'en_stock',
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

CREATE TABLE commerce (
    id_commerce INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse_livraison VARCHAR(255) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    code_postal VARCHAR(20) NOT NULL,
    pays VARCHAR(100) NOT NULL DEFAULT 'France',
    telephone VARCHAR(20) NOT NULL,
    mode_paiement ENUM('carte', 'paypal', 'virement', 'autre') NOT NULL DEFAULT 'carte',
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE
);

CREATE TABLE contacts (
    id_contact INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NULL,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE
);

CREATE TABLE reponses_contacts (
    id_reponse INT AUTO_INCREMENT PRIMARY KEY,
    id_contact INT NOT NULL,             -- Référence au message de contact
    id_admin INT NOT NULL,               -- L'ID de l'administrateur qui répond
    reponse TEXT NOT NULL,               -- Le contenu de la réponse
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Date de la réponse
    CONSTRAINT fk_contact FOREIGN KEY (id_contact) REFERENCES contacts(id_contact) ON DELETE CASCADE,  -- Lien vers le message de contact
    CONSTRAINT fk_admin FOREIGN KEY (id_admin) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE  -- Lien vers l'administrateur (assuré par la table utilisateurs)
);
