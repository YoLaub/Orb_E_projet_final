<?php

namespace app\controleurs\class;

use app\modeles\DBContacts;

class ContactControleur
{
    private $connexion;
    private $pageLayout;
    
    public function __construct()
    {
        $connexion = new DBContacts();
        $this->pageLayout = new renderLayout;
    }

    public function pageContact() {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = htmlspecialchars($_POST["nom"]);
    
            if(isset($_SESSION["email"])){
                $email = $_SESSION["email"];
            }else{
                $email = htmlspecialchars($_POST["email"]);
            }
    
            $message = htmlspecialchars($_POST["message"]);
    
            if(isset($_SESSION["id"])){
                $id_utlisateur = $_SESSION["id"];
            }else{
                $id_utlisateur = NULL;
            }
    
            $connexion = new DBContacts();
    
    
            if (!empty($nom) && !empty($email) && !empty($message)) {
                $etat = $connexion->saveMessage($nom, $email, $message, $id_utlisateur);
                if ($etat) {
                    $_SESSION["message"] = "Message envoyé !";
                } else {
                    $params["message"] = "Erreur d'envoie' !";
                    return $this->pageLayout->render("page_contact.php", $params);
                }
                header("Location: ?action=contact"); // Redirection vers la même page après POST
                exit; // Important pour éviter toute exécution après la redirection
            } else {
                $params["message"] = "Vous avez oubliez un champ !";
                return $this->pageLayout->render("page_contact.php", $params);   
            }
        }
        if(isset($_SESSION["message"])){
            unset($_SESSION["message"]);
        }
        
        $params["message"] = "Dites nous tous !";
        return $this->pageLayout->render("page_contact.php", $params);
    }

    
}
