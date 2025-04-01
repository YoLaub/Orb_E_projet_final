<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBUser;
use app\modeles\DBContacts;
use app\modeles\DBResponse;

class profilControleur
{
    private $pageLayout;
    private $gestionProfil;
    private $connexionContact;
    private $connexionReponses;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
        $this->gestionProfil = new DBUser;
        $this->connexionContact = new DBContacts;
        $this->connexionReponses = new DBResponse;


    }

    public function pageProfil(){

        $id_contact = 12;
        $email = $_SESSION["email"];

        $params = array();
        $params["email"] = $email;
        $params["informations"] = $this->gestionProfil->infoUser($email);
        $params["commandes"] = $this->gestionProfil->getUserOrders($email);
        $params["score"] =  $this->gestionProfil->getUserScores($email);
        $params["mesMessages"] = $this->connexionContact->getMessagePerEmail($email);
        $params["mesReponses"] = $this->connexionReponses->getReponsesPerEmail($id_contact);
        $params["formulaire"] = self::modifierInformationPerso();

        $content = "page_profile.php";
        $this->pageLayout->render($content, $params);

        

       

    }

    private function modifierInformationPerso(){

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $prenom = trim($_POST["prenom"] ?? '');
            $nom = trim($_POST["nom"] ?? '');
            $adresse = trim($_POST["adresse"] ?? '');
            $ville = trim($_POST["ville"] ?? '');
            $cp = trim($_POST["cp"] ?? '');
            $tel = trim($_POST["tel"] ?? '');
           
            if ($email && $nom && $prenom && $adresse&& $ville && $cp && $tel) {
               $etat = $gestionProfil->updateInfoUser($email, $prenom, $nom, $adresse, $ville, $cp, $tel, $paiement);
        
                if ($etat) {
                    $params = array();
                    $params["message"] = "Modification effectué !";
                    $content = "formulaire.php";
                    $this->pageLayout->render($content, $params);
                } else {
                    $params = array();
                    $params["message"] = "Erreur de modification !";
                    $content = "formulaire.php";
                    $this->pageLayout->render($content, $params);
                }
            }
        } else {


            $email = $_SESSION["email"];
            $params = array();
            $params["informations"] = $this->gestionProfil->infoUser($email);
           
        
            //Affichage des vues
            $content = $content = "partials/formulaire.php";;
            $this->pageLayout->render($content, $params); 
        }

            
    }



}
