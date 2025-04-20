<?php

namespace app\modeles;

use \PDO;
use \Exception;

class DBParty extends DbConnect
{

    // Récupération des scores de l'utilisateur par email
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
            return self::executerRequete($sql, $value)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Récupération du dernier score de l'utilisateur par id utilisateur
    public static function getLastScores($idUtilisateur)
    {
        $value = ["id" => $idUtilisateur];

        $sql = "select *
                from parties
                where parties.id_utilisateur = :id
                order by parties.date_heure desc
                limit 1";

        try {
            return self::executerRequete($sql, $value)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Récupération des 5 meilleurs scores
    public static function getFiveBestScores($count)
    {
        $value = ["count" => $count];

        $sql = "select 
                            utilisateurs.id_utilisateur,
                            utilisateurs.email as email_utilisateur,
                            commerce.nom as pseudo,
                            max(parties.score) as meilleur_score
                        from parties
                        join utilisateurs on parties.id_utilisateur = utilisateurs.id_utilisateur
                        join commerce on parties.id_utilisateur = commerce.id_utilisateur
                        group by utilisateurs.id_utilisateur, utilisateurs.email
                        order by meilleur_score desc
                        limit :count";

        try {
            return self::executerRequete($sql, $value)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Récupération et calcul de la somme de tout les scores
    public static function totalScore()
    {


        $sql = "select sum(score) as total_points from parties";

        try {
            return self::executerRequete($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Enregistrer les scores
    public static function saveScore($score, $idUtilisateur)
    {

        $value = array();
        $value["score"] = $score;
        $value["id_utilisateur"] = $idUtilisateur;

        try {
            $sql = "insert into parties (score, id_utilisateur) values (:score, :id_utilisateur)";

            self::executerRequete($sql, $value);

            return true;
        } catch (Exception $e) {
            return $e->getMessage() . "<br />Impossible d'envoyer les données dans la base de données' !";
        }
    }
}
