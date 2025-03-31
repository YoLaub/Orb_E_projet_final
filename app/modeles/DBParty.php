<?php

namespace app\modeles;

use \PDO;
use \Exception;

class DBParty extends DbConnect
{
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
 

    public static function getFiveBestScores($count)
        {
        $value = ["count" => $count];

                $sql = "select 
                            utilisateurs.id_utilisateur,
                            utilisateurs.email as email_utilisateur,
                            max(parties.score) as meilleur_score
                        from parties
                        join utilisateurs on parties.id_utilisateur = utilisateurs.id_utilisateur
                        group by utilisateurs.id_utilisateur, utilisateurs.email
                        order by meilleur_score desc
                        limit :count";

                try {
                    return self::executerRequete($sql, $value)->fetchAll(PDO::FETCH_ASSOC);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }

}