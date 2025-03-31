<?php

namespace app\modeles;

use \PDO;
use \Exception;

class DBUser extends DbConnect
{

    public static function getAllUser()
    {

        $sql = "select * from utilisateurs";

        try {
            return self::executerRequete($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getUser($role)
    {

        $value= array();
        $value["role"] = $role;

        $sql = "select 
                u.email, 
                c.nom, 
                c.prenom, 
                c.id_commerce, 
                c.adresse_livraison,
                c.ville,
                c.code_postal,
                c.pays,
                c.telephone, 
                c.mode_paiement
            from utilisateurs as u
            left join commerce as c on u.id_utilisateur = c.id_utilisateur
            where u.rôle != :role";

        $req = self::executerRequete($sql, $value);
        
        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    public static function numberOfUser()
    {

        $sql = "select count(*) from utilisateurs where utilisateurs.rôle = 'utilisateur'";
        $req = self::executerRequete($sql);

        /* Remplacer ??? par la méthode fetchAll() */
        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }


    public static function getUserPerEmail($email)
    {

        $value= array();
        $value["email"] = $email;

        $sql = "select * from utilisateurs where email like :email";
        $req = self::executerRequete($sql, $value);

        /* Remplacer ??? par la méthode fetchAll() */
        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }


    public static function addUser($email, $mdp, $role)
    {

        $value = array();
        $value["email"] = $email;
        $value["password"] = $mdp;
        $value["role"] = $role;

        try {

            $utilisateur = self::getUserPerEmail($email);
            if($utilisateur==""){
                $sql = "insert into utilisateurs (rôle, email, password) values (:role, :email, :password)";
                self::executerRequete($sql, $value);
                return true;
            }
             else {
                throw new Exception("Adresse Email déjà utilisée");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

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

    public static function updateInfoUser($email, $prenom, $nom, $adresse, $ville, $cp, $tel, $paiement)
    {
        $value = [
            "email" => $email,
            "prenom" => $prenom,
            "nom" => $nom,
            "adresse" => $adresse,
            "ville" => $ville,
            "cp" => $cp,
            "tel" => $tel,
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
                        commerce.mode_paiement = :paiement 
                    where utilisateurs.email = :email";
    
            $req = self::executerRequete($sql, $value);
            
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

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
    public static function getUserScores($email)
    {
    $value = ["email" => $email];

    $sql = "select 
                parties.id_partie,
                parties.score,
                parties.date_heure,
                (select max(score) from parties where id_utilisateur = utilisateurs.id_utilisateur) as meilleur_score,
                (select avg(score) from parties where id_utilisateur = utilisateurs.id_utilisateur) as score_moyen,
                (select count(*) FROM parties WHERE id_utilisateur = utilisateurs.id_utilisateur) as nombre_parties
            from parties
            join utilisateurs on parties.id_utilisateur = utilisateurs.id_utilisateur
            where utilisateurs.email = :email
            order by parties.date_heure desc";

    try {
        return self::executerRequete($sql, $value)->fetchAll();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
    

          

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
    public static function deleteUser($id_utilisateur)
    {

        $value = array();
        $value["id_utilisateur"] = $id_utilisateur;

        try {
            $sql = "delete from utilisateurs where utilisateurs.id_utilisateur like :id_utilisateur";
    
            $req = self::executerRequete($sql, $value);
            
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
}

}
