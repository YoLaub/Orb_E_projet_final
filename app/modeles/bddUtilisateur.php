<?php

/**
 *  dao : Page1
 */

class DBPage2 extends DbConnect
{

    public static function getUser()
    {

        $sql = "select * from utilisateur";

        $req = self::executerRequete($sql);

        /* Remplacer ??? par la méthode fetchAll() */
        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }
    public static function getUserPerEmail($email)
    {

        $sql = "select * from utilisateurs where email like :email";
        $req = self::executerRequete($sql, $email);

        /* Remplacer ??? par la méthode fetchAll() */
        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    public static function getUserPerName($prenom)
    {

        $sql = "select * from user where prenom like :prenom";
        $req = self::executerRequete($sql, $prenom);

        /* Remplacer ??? par la méthode fetchAll() */
        $data = $req->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($data)) return $data;
    }

    public static function addUser($nom, $prenom, $email, $mdp)
    {

        $value = array();
        $value["nom"] =  $nom;
        $value["prenom"] = $prenom;
        $value["email"] = $email;
        $value["mdp"] = $mdp;

        try {

            $utilisateur = self::getUserPerEmail($email);
            if ($email == $utilisateur["email"]) {
                throw new Exception("Adresse Email déjà utilisée");
            } else {
                $sql = "insert into utilisateurs (nom, prenom, email, password) values (:nom, :prenom, :email, :mdp)";
                self::executerRequete($sql, $value);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
