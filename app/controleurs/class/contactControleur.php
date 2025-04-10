<?php

namespace app\controleurs\class;

use app\modeles\DBContacts;
use app\modeles\DBResponse;

class ContactControleur
{
    private $connexion;
    private $connexionReponse;
    private $pageLayout;
    private $params;
    
    public function __construct()
    {
        $this->connexion = new DBContacts;
        $this->connexionReponse = new DBResponse;
        $this->pageLayout = new renderLayout;
        $this->params = array();
        
    }

    public function pageContact() {

        $this->params["style"] = "style_contact.css";

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
                   $this->params["message"] = "Erreur d'envoie' !";
                    return $this->pageLayout->render("page_contact.php",$this->params);
                }
                header("Location: ?action=contact"); // Redirection vers la même page après POST
                exit; // Important pour éviter toute exécution après la redirection
            } else {
               $this->params["message"] = "Vous avez oubliez un champ !";
                return $this->pageLayout->render("page_contact.php",$this->params);   
            }
        }
        if(isset($_SESSION["message"])){
            unset($_SESSION["message"]);
        }
        
       $this->params["message"] = "Dites nous tout !";
        return $this->pageLayout->render("page_contact.php",$this->params);
    }

    public function pageContactBo() 
    {
       $this->params["lesMessages"] = $this->connexion->getMessage();
       $this->params["lesReponses"] = $this->connexionReponse->getReponse();
       $this->params["style"] = "style_messagerie.css";

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
                    return $this->pageLayout->render("admin/page_messagerie_bo.php",$this->params);
                }
            } else {
        return $this->pageLayout->render("admin/page_messagerie_bo.php",$this->params);
            }
        }
        return $this->pageLayout->render("admin/page_messagerie_bo.php",$this->params);


    }

    public function rechercheMessage(){

        if (isset($_POST['terme'])) {
            $terme = "%".trim($_POST['terme'])."%";
      

            $message = $this->connexion->searchMessagePerEmail($terme); // la méthode qu'on a vue plus haut
        
            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
    }
}

    public function rechercheMessageD(){

        if (isset($_POST['terme'])) {
            $terme = trim($_POST['terme']);
      

            $message = $this->connexion->searchMessagePerDate($terme); // la méthode qu'on a vue plus haut
        
            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
    }
}
    public function rechercheReponse(){

        if (isset($_POST['terme'])) {
            $terme = intval(trim($_POST['terme']));
      

            $message = $this->connexionReponse->getReponsesPerId($terme); // la méthode qu'on a vue plus haut
        
            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
    }
}

    
}
