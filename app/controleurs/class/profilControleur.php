<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBUser;
use app\modeles\DBContacts;
use app\modeles\DBResponse;
use app\modeles\DBOrder;
use app\modeles\DBProduct;

class ProfilControleur
{
    private $pageLayout;
    private $connexion;
    private $gestionProfil;
    private $connexionContact;
    private $connexionReponses;
    private $gestionCommande;
    private $connexionDBProduct;
    private $infoPerso;
    private $email;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
        $this->connexion = new Middleware;
        $this->gestionProfil = new DBUser;
        $this->connexionContact = new DBContacts;
        $this->connexionReponses = new DBResponse;
        $this->connexionDBProduct = new DBProduct;
        $this->gestionCommande = new DBOrder;
        if(isset($_SESSION["email"])){
            $this->email = $_SESSION["email"];
        }
        $this->infoPerso = $this->gestionProfil->infoUser($this->email);
        
    }

    public function pageProfil(){

        $id_contact = 12;

        $params = [
            "email" => $this->email,
            "informations" =>  $this->infoPerso,
            "commandes" => $this->gestionProfil->getUserOrders($this->email),
            "score" => $this->gestionProfil->getUserScores($this->email),
            "mesMessages" => $this->connexionContact->getMessagePerEmail($this->email),
            "mesReponses" => $this->connexionReponses->getReponsesPerEmail($id_contact),
            "formulaire" => $this->modifierInformationPerso(),
            "style"=>"style_profile.css" 
        ];

        $content = "page_profile.php";

        $this->pageLayout->render($content, $params);
    }

    public function pageCommande(){
        $params = [
            "email" => $this->email,
            "informations" =>  $this->infoPerso,
            "formulaire" => $this->modifierInformationPerso(),
            "infoProduit" => $this->connexionDBProduct->getProduct(),
            "style"=> "style_commande.css"
            
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomProduit = trim($_POST["nomProduit"] ?? '');
            $prix = trim($_POST["prix"] ?? '');
            $quantite = intval(trim($_POST["quantite"] ?? ''));
            $prixTotal = floatval($prix) * $quantite;

        
        if($nomProduit && $prix){
            $etat = false;
            $etat =$this->connexionDBProduct->addOrder($prixTotal,$_SESSION["id"], $_SESSION["id_produit"],$quantite);
    
            if ($etat) {
                unset($_SESSION["id_produit"]);
                // Redirection vers l'accueil si connexion réussie
                header("Location: ?action=produit");
            } else {
                // Redirection vers l'accueil si connexion réussie
                $content = "page_commande.php";
                $this->pageLayout->render($content, $params);
            }
        }
        }
        else {
    
        if($this->connexion->accesMiddleware()){
            
            $content = "page_commande.php";
            $this->pageLayout->render($content, $params);
        }else{

            header("Location: ?action=connexion");
        
        }
    
        }
    
    }

    public function modifierInformationPerso(){

        $params = array();
         // Récupérer les infos pour afficher le formulaire pré-rempli
        $params = [
            "informations" => $this->gestionProfil->infoUser($this->email),
            "select" => $this->gestionCommande->showEnum(),
            "action" => "profile"
        ];


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $prenom = trim($_POST["prenom"] ?? '');
            $nom = trim($_POST["nom"] ?? '');
            $adresse = trim($_POST["adresse"] ?? '');
            $ville = trim($_POST["ville"] ?? '');
            $cp = trim($_POST["cp"] ?? '');
            $tel = trim($_POST["tel"] ?? '');
            $paiement = trim($_POST["paiement"] ?? '');
           
            if ($this->email && $nom && $prenom && $adresse&& $ville && $cp && $tel) {
               $etat = $this->gestionProfil->updateInfoUser($this->email, $prenom, $nom, $adresse, $ville, $cp, $tel, $paiement);
        
                if ($etat) {
                    $_SESSION["message"] = "<p>Modification effectué !</p>";
                } else {
                    $params["message"] = "<p> Erreur de modification !</p>";
                    return $this->pageLayout->render("partials/formulaire.php", $params, true);
                }
                header("Location: ?action=profile"); // Redirection vers la même page après POST
                exit; // Important pour éviter toute exécution après la redirection
            }
        } else {
            if(isset($_SESSION["message"])){
                unset($_SESSION["message"]);
            }
            // Retourner le rendu du formulaire sous forme de chaîne
            return $this->pageLayout->render("partials/formulaire.php", $params, true);
        }

            
    }



}
