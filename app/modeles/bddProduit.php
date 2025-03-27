<?php

class DBProduct extends DbConnect
{

    public static function getProduct()
    {

        $sql = "select * from produits";

        $req = self::executerRequete($sql);

        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    public static function getProductById($id_produit)
    {

        $value = array();
        $value["id_produit"] = $id_produit;

        $sql = "select * from produits where id_produit = :id_produit";

        $req = self::executerRequete($sql, $value);

        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    public static function getOrder()
    {

        $sql = "select * from order";

        $req = self::executerRequete($sql);

        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    public static function lastOrder()
    {

        $sql = "select max(id_commande) as dernier_id from commandes";

        $req = self::executerRequete($sql);

        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    public static function addDetailsOrder($idCommande, $idProduct, $quantite)
    {

        if (!is_int($idCommande) || !is_int($idProduct) || !is_int($quantite) || $quantite <= 0) {
            throw new InvalidArgumentException("Les paramètres doivent être des entiers valides, et la quantité doit être supérieure à zéro.");
        }

        $value = array();
        $value["idCommande"] = $idCommande;
        $value["idProduct"] = $idProduct;
        $value["quantite"] = $quantite;

        try {
            $sql = "insert into detail_commande (id_commande, id_produit, quantité) values (:idCommande, :idProduct, :quantite)";

            self::executerRequete($sql, $value);
            return true;
        } catch (Exception $e) {
            return "Erreur lors de l'ajout du detail commande : " . $e->getMessage();
        }
    }

    public static function addProduct()
    {

        $sql = "select * from produits";

        $req = self::executerRequete($sql);

        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    public static function deleteProduct($id_produit)
    {

        $value = array();
        $value["id_produit"] = $id_produit;

        try {
            $sql = "delete from produits where id_produit = :id_produit";

            self::executerRequete($sql, $value);

            return true;
        } catch (Exception $e) {
            return "Erreur lors de la suppression : " . $e->getMessage();
        }
    }

    public static function updateProduct($id_produit, $nom, $description, $prix, $photo, $dispo)
    {

        $value = array();
        $value["id_produit"] = $id_produit;
        $value["nom"] = $nom;
        $value["description"] = $description;
        $value["prix"] = $prix;
        $value["photo"] = $photo;
        $value["disponibilite"] = $dispo;

        try {
            $sql = "update produits
                    set nom = :nom,
                    description = :description,
                    prix = :prix,
                    photo = :photo,
                    disponibilite = :disponibilite
                    where id_produit = :id_produit";

            self::executerRequete($sql, $value);

            return true;
        } catch (Exception $e) {
            return "Erreur lors de la mis à jour : " . $e->getMessage();
        }
    }


    public static function addOrder($total, $idUtilisateur, $idProduct, $quantite)
    {

        $value = array();
        $value["prixTotal"] = $total;
        $value["idUtilisateur"] =  $idUtilisateur;


        try {
            $sql = "insert into commandes (id_utilisateur, montant_total) values (:idUtilisateur, :prixTotal)";

            self::executerRequete($sql, $value);

            $idCommande = self::lastOrder();

            self::addDetailsOrder($idCommande[0]["dernier_id"], $idProduct, $quantite);

            return true;
        } catch (Exception $e) {
            return $e->getMessage() . "<br />Impossible d'envoyer les données dans la base de données' !";
        }
    }

    public static function deleteOrder($id_commande)
    {

        $value = array();
        $value["id_commande"] = $id_commande;
        


        try {
            $sql = "delete from commandes where id_commmande = :id_commande";

            self::executerRequete($sql, $value);

            return true;
        } catch (Exception $e) {
            return $e->getMessage() . "Impossible de supprimer la commande !";
        }
    }
}
