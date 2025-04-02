<?php

namespace app\controleurs\class;

use app\modeles\DBContacts;
use app\modeles\DBResponse;

class ContactControleur
{
    private $connexion;
    private $connexionReponse;
    private $pageLayout;
    
    public function __construct()
    {
        $this->connexion = new DBContacts;
        $this->connexionReponse = new DBResponse;
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

    public function pageContactBo() 
    {
        $params["lesMessages"] = $this->connexion->getMessage();
        $params["lesReponses"] = $this->connexionReponse->getReponse();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id_contact = htmlspecialchars($_POST["id_contact"]);
            $reponse = htmlspecialchars($_POST["reponse"]);
    
            if(isset($_SESSION["id"])){
                $id_admin = $_SESSION["id"];
            }else{
                $id_admin = NULL;
            }
    
            if (!empty($id_contact) && !empty($id_admin) && !empty($reponse)) {
                $etat =  $this->connexionReponse->saveMessageAdmin($id_contact, $id_admin, $reponse);
                if ($etat) {
                    header("Location: ?action=messagerie");
                } else {
                    return $this->pageLayout->render("admin/page_messagerie_bo.php", $params);
                }
            } else {
        return $this->pageLayout->render("admin/page_messagerie_bo.php", $params);
            }
        }
        return $this->pageLayout->render("admin/page_messagerie_bo.php", $params);


    }

    
}
