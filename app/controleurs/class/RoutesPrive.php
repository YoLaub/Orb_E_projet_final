<?php

namespace app\controleurs\class;

use app\controleurs\class\Connexion;

class RoutesPrive {
    private array $adminActions; // Tableau associatif des actions du back-office
    private string $action;
    private $params;
    private const DEFAULT_ROUTE = "accueilControleur:accueil"; // Définition d'une constante pour la route par défaut
    private const ERROR_ROUTE = "page404_ctrl.php"; // Route d'erreur

    public function __construct() {
        // Liste des actions disponibles uniquement pour les administrateurs
        $this->adminActions = [
            "defaut"  => self::DEFAULT_ROUTE,
            "accueil" => self::DEFAULT_ROUTE,
            "accueilBo" => "accueilControleur:accueil",
            "utilisateur" => "UtilisateurGControleur:pageGUtilisateur",
            "produit" => "ProduitControleur:pageProduitBo",
            "fiche" => "ProduitControleur:editionProduitBo",
            "messagerie" => "ContactControleur:pageContactBo",
            "connexion" => "Connexion:connexionUtilisateur",
            "suppression" => "Connexion:suppressionUtilisateur",
            "deconnexion" => "Connexion:deconnexion",
            "rechercheU" => "UtilisateurGControleur:rechercheUtilisateur",
            "rechercheM" => "ContactControleur:rechercheMessage",
            "rechercheMD" => "ContactControleur:rechercheMessageD",
            "rechercheR" => "ContactControleur:rechercheReponse",
            "nouveau" => "ProduitControleur:ajouterProduit",
            "page404" => self::ERROR_ROUTE,
        ];
    }

    public function redirection(string $action = "defaut", array $params = []){

        $this->action = $action;
        $this->params = $params;

            // Vérifie si l'action existe, sinon, renvoie vers la page 404
        $controllerAction = explode(":", $this->adminActions[$this->action]);
        // $controller = new $controllerAction[0]();
        $fullPathClass =  __NAMESPACE__ . "\\" . $controllerAction[0];
        
        $controller = new $fullPathClass(); 
        $method = $controllerAction[1]; 

        $controller->$method($params);

        exit();

    }

}

