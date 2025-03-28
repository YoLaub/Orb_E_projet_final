<?php
class DBContacts extends DbConnect
{
    public static function getMessage()
        {
        

        $sql = "select * from contacts";

        try {
            return self::executerRequete($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
 

    public static function getMessagePerEmail($email)
        {
        
        $value = array();
        $value = ["email" => $email];

                $sql = "select
                            contacts.id_contact as Ref,
                            contacts.message as Message,
                            contacts.created_at as Date_message
                        from contacts
                        where contacts.email = :email
                        order by contacts.created_at desc";

                try {
                    return self::executerRequete($sql, $value)->fetchAll(PDO::FETCH_ASSOC);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }

    public static function saveMessage($nom, $email, $message, $id_utilisateur = NULL)
        {

        $value = array();
        $value["nom"] = $nom;
        $value["email"] = $email;
        $value["message"] = $message;
        $value["id_utilisateur"] = $id_utilisateur;

                try {
                    $sql = "insert into contacts (id_utilisateur, nom, email, message) VALUES (:id_utilisateur, :nom, :email, :message)";
                    self::executerRequete($sql, $value);
                    return $value;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }




    public static function deleteMessage($idMessage)
        {
        $value = ["idMessage" => $idMessage];

                $sql = "delete from contacts where contacts.id_contact like :idMessage";

                try {
                    return self::executerRequete($sql, $value)->fetchAll(PDO::FETCH_ASSOC);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }

}