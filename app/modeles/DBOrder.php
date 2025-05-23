<?php

namespace app\modeles;

use \PDO;
use \Exception;


class DBOrder extends DbConnect
{

    // Récupération de toute les commandes
    public static function getAllOrder()
    {

        $sql = "select 
                    commandes.id_commande,
                    commandes.date_heure,
                    commandes.montant_total,
                    commandes.statut,
                    produits.id_produit,
                    produits.nom as nom_produit,
                    produits.description,
                    produits.prix,
                    detail_commande.quantité,
                    (produits.prix * detail_commande.quantité) as total_produit,
                    utilisateurs.id_utilisateur,
                    utilisateurs.email
                from commandes
                join utilisateurs on commandes.id_utilisateur = utilisateurs.id_utilisateur
                join detail_commande on commandes.id_commande = detail_commande.id_commande
                join produits on detail_commande.id_produit = produits.id_produit
                order by commandes.date_heure desc";




        $req = self::executerRequete($sql);

        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    // Récupération des informations personnel de l'utilisateur 
    public static function infoUser($email)
    {

        $value = array();
        $value["email"] = $email;

        $sql = "select c.* from commerce as c inner join utilisateurs as u on c.id_utilisateur = u.id_utilisateur where binary u.email like :email";
        $req = self::executerRequete($sql, $value);

        /* Remplacer ??? par la méthode fetchAll() */
        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }


    // Mise à jours des informations personnelle de l'utilisateur
    public static function updateInfoUser($email, $prenom, $nom, $adresse, $ville, $cp, $tel, $pays, $paiement)
    {
        $value = [
            "email" => $email,
            "prenom" => $prenom,
            "nom" => $nom,
            "adresse" => $adresse,
            "ville" => $ville,
            "cp" => $cp,
            "tel" => $tel,
            "pays" => $pays,
            "paiement" => $paiement
        ];

        try {
            $sql = "update commerce 
                    join utilisateurs on commerce.id_utilisateur = utilisateurs.id_utilisateur 
                    set commerce.prenom = :prenom, 
                        commerce.nom = :nom, 
                        commerce.adresse_livraison = :adresse, 
                        commerce.ville = :ville, 
                        commerce.code_postal = :cp, 
                        commerce.telephone = :tel, 
                        commerce.pays = :pays, 
                        commerce.mode_paiement = :paiement 
                    where utilisateurs.email = :email";

            $req = self::executerRequete($sql, $value);

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Creation de la fiche client
    public static function createInfoUser($id_utilisateur, $prenom, $nom, $adresse, $ville, $cp, $tel, $pays, $paiement)
    {
        $value = [
            "id_utilisateur" => $id_utilisateur,
            "prenom" => $prenom,
            "nom" => $nom,
            "adresse_livraison" => $adresse,
            "ville" => $ville,
            "code_postal" => $cp,
            "telephone" => $tel,
            "pays" => $pays,
            "mode_paiement" => $paiement
        ];

        try {
            $sql = "insert into commerce (id_utilisateur, nom, prenom, adresse_livraison, ville, code_postal, pays, telephone, mode_paiement) values (:id_utilisateur, :nom, :prenom, :adresse_livraison, :ville, :code_postal, :pays, :telephone, :mode_paiement)";

            self::executerRequete($sql, $value);

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Récupération des informations personnel de l'utilisateur par email
    public static function getUserOrders($email)
    {
        $value = ["email" => $email];

        $sql = "select 
                commandes.id_commande,
                commandes.date_heure,
                commandes.montant_total,
                commandes.statut,
                produits.id_produit,
                produits.nom as nom_produit,
                produits.description,
                produits.prix,
                detail_commande.quantité,
                (produits.prix * detail_commande.quantité) as total_produit
            from commandes
            join detail_commande on commandes.id_commande = detail_commande.id_commande
            join produits on detail_commande.id_produit = produits.id_produit
            where commandes.id_utilisateur = (select id_utilisateur from utilisateurs where email = :email)
            order by commandes.date_heure desc";

        try {
            return self::executerRequete($sql, $value)->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Suppression des informations personnel de l'utilisateur par email
    public static function deleteInfoUser($email)
    {

        $value = array();
        $value["email"] = $email;

        try {
            $sql = "delete commerce from commerce join utilisateurs on commerce.id_utilisateur = utilisateurs.id_utilisateur where utilisateurs.email like :email";

            $req = self::executerRequete($sql, $value);

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Mise à jours du statut de commande
    public static function updateStatus($status, $idCommande)
    {

        $value = array();
        $value["status"] = $status;
        $value["idCommande"] = $idCommande;

        try {
            $sql = "update commandes set statut = :status where id_commande = :idCommande ";

            $req = self::executerRequete($sql, $value);

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Récuperation des en tête de champ ENUM
    public static function showEnum($table, $colonne)
    {

        $value = array();

        $value["colonne"] = $colonne;

        // Récupérer les valeurs de l'ENUM
        $sql = "SHOW COLUMNS FROM `$table` LIKE :colonne";
        $req = self::executerRequete($sql, $value);

        /* Remplacer ??? par la méthode fetchAll() */
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        preg_match("/^enum\((.+)\)$/i",  $data[0]["Type"], $matches);
        $enumValues = str_getcsv($matches[1], ",", "'");

        if (!empty($data)) return $enumValues;
    }
}
