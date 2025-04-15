<?php

namespace app\modeles;

use \PDO;
use \Exception;

class DBResponse extends DbConnect
{
    public static function getReponse()
    {


        $sql = "select * from reponses_contacts";

        try {
            return self::executerRequete($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getReponsesPerId($id_contact)
    {

        $value = array();
        $value["id_contact"] = $id_contact;


        $sql = "select
                        reponses_contacts.id_contact as Ref,
                        reponses_contacts.reponse as Message,
                        reponses_contacts.created_at as Date_message
                    from reponses_contacts
                    where reponses_contacts.id_contact = :id_contact
                    order by reponses_contacts.created_at desc";

        try {
            return self::executerRequete($sql, $value)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }






    public static function saveMessageAdmin($id_contact, $id_admin, $reponse)
    {

        $value = array();
        $value["id_contact"] = $id_contact;
        $value["id_admin"] = $id_admin;
        $value["reponse"] = $reponse;


        try {
            $sql = "insert into reponses_contacts (id_contact, id_admin, reponse) VALUES (:id_contact, :id_admin, :reponse)";
            self::executerRequete($sql, $value);
            return $value;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
