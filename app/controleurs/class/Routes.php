<?php

namespace app\controleurs\class;

use app\controleurs\class\Connexion;


class Routes
{
    private array $lesActions; // Tableau associatif des actions et fichiers correspondants
    private string $action;
    private $params;
    private const DEFAULT_ROUTE = "accueilControleur:accueil"; // Définition d'une constante pour la route par défaut
    private const ERROR_ROUTE = "page404_ctrl.php"; // Route en cas d'erreur ou de page introuvable

    public function __construct()
    {
        // Définition des routes accessibles par tous les utilisateurs
        $this->lesActions = [
            "defaut"  => self::DEFAULT_ROUTE,
            "accueil" => self::DEFAULT_ROUTE,
            "produit" => "ProduitControleur:pageProduit",
            "commande" => "ProfilControleur:pageCommande",
            "jeu" => "JeuControleur:pageJeu",
            "connexion" => "Connexion:connexionUtilisateur",
            "deconnexion" => "Connexion:deconnexion",
            "inscription" => "Connexion:inscription",
            "formulaire" => "ProfilControleur:modifierInformationPerso",
            "profile" => "ProfilControleur:pageProfil",
            "rgpd" => "ArticleControleur:pageRgpd",
            "engagement" => "ArticleControleur:pageEngagement",
            "cgv" => "ArticleControleur:pageCgv",
            "faq" => "ArticleControleur:pageFaq",
            "qui" => "ArticleControleur:pageQui",
            "contact" => "ContactControleur:pageContact",
            "page404" => self::ERROR_ROUTE,
        ];
    }

    public function redirection(string $action = "defaut", array $params = []){

        $this->action = $action;
        $this->params = $params;

        // Vérifie si l'action existe, sinon, renvoie vers la page 404
        $controllerAction = explode(":", $this->lesActions[$this->action]);
        // $controller = new $controllerAction[0]();
        $fullPathClass =  __NAMESPACE__ . "\\" . $controllerAction[0];
        
        $controller = new $fullPathClass(); 
        $method = $controllerAction[1]; 

        $controller->$method($params);

          exit();
    }

}
