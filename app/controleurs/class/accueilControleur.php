<?php

namespace app\controleurs\class;

use app\modeles\DBUser;
use app\modeles\DBProduct;
use app\modeles\DBOrder;
use app\modeles\DBParty;

class accueilControleur{

    private $pageLayout;
    private $connexionUtilisateur;
    private $connexionCommande;
    private $connexionProduit;
    private $connexionJeu;
    private $params;

    public function __construct()
    {
        $this->pageLayout = new renderLayout;
        $this->params = array();
        
    }

    public function accueil(){
        $this->params["style"] = "style_accueil.css";

        if(isset($_SESSION["role"])){
            if($_SESSION["role"] == "utilisateur"){
                $content = "page_accueil.php";
                $this->pageLayout->render($content, $this->params);
            }elseif($_SESSION["role"] == "admin"){
               return $this->accueilBo();
            }
        }else{
            $content = "page_accueil.php";
                $this->pageLayout->render($content, $this->params);
        }
    }

    public function accueilBo(){
    
        $this->connexionUtilisateur = new DBUser();
        $this->connexionProduit = new DBProduct();
        $this->connexionCommande = new DBOrder();
        $this->connexionJeu = new DBParty();

        $this->params["style"] = "style_accueil.css";

        $count = 5;

        $params = [
            "lesCommandes" => $this->connexionCommande->getAllOrder(),
            "lesUtilisateurs" =>  $this->connexionUtilisateur->numberOfUser(),
            "meilleurJoueur" => $this->connexionJeu->getFiveBestScores($count)
            
        ];
    
        $content = "admin/page_accueil_bo.php";
        $this->pageLayout->render($content, $params);


    }
}