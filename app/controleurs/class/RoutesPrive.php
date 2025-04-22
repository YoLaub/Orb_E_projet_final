<?php

namespace app\controleurs\class;

use app\controleurs\class\Connexion;

class RoutesPrive
{
    private array $adminActions; // Tableau associatif des actions réservées au back-office (administration)
    private string $action; // Action courante demandée
    private $params; // Paramètres associés à l'action
    private const DEFAULT_ROUTE = "AccueilControleur:accueil"; // Route par défaut si aucune action spécifique n'est fournie
    private const ERROR_ROUTE = "app/vues/'page404.php"; // Route utilisée pour la page 404 en cas d'erreur

    public function __construct()
    {
        // Définition des routes disponibles uniquement pour les administrateurs avec leurs correspondances contrôleur:methode
        $this->adminActions = [
            "defaut"  => self::DEFAULT_ROUTE,
            "accueil" => self::DEFAULT_ROUTE,
            "accueilBo" => "AccueilControleur:accueil", // Page d'accueil back-office
            "utilisateur" => "UtilisateurGControleur:pageGUtilisateur", // Gestion des utilisateurs
            "produit" => "ProduitControleur:pageProduitBo", // Gestion des produits back-office
            "fiche" => "ProduitControleur:editionProduitBo", // Édition de produit
            "messagerie" => "ContactControleur:pageContactBo", // Gestion de la messagerie back-office
            "connexion" => "Connexion:connexionUtilisateur", // Connexion administrateur
            "suppression" => "Connexion:suppressionUtilisateur", // Suppression d'utilisateur
            "modifier" => "UtilisateurGControleur:modifierPasswordAdmin", // Suppression d'utilisateur
            "deconnexion" => "Connexion:deconnexion", // Déconnexion administrateur
            "rechercheU" => "UtilisateurGControleur:rechercheUtilisateur", // Recherche d'utilisateur
            "rechercheM" => "ContactControleur:rechercheMessage", // Recherche de message reçu
            "rechercheMD" => "ContactControleur:rechercheMessageD", // Recherche de message dans les discussions
            "rechercheR" => "ContactControleur:rechercheReponse", // Recherche de réponse
            "nouveau" => "ProduitControleur:ajouterProduit", // Ajout d'un nouveau produit
            "page404" => self::ERROR_ROUTE, // Page 404 en cas d'erreur ou action introuvable
        ];
    }

    public function redirection(string $action = "defaut", array $params = [])
    {
        $this->action = $action; // Stocke l'action demandée
        $this->params = $params; // Stocke les paramètres éventuels

        // Récupère la correspondance contrôleur:methode à partir de l'action demandée
        $controllerAction = explode(":", $this->adminActions[$this->action]);

        // Construit le nom complet de la classe contrôleur en ajoutant l’espace de nom courant
        $fullPathClass =  __NAMESPACE__ . "\\" . $controllerAction[0];

        // Instancie dynamiquement le contrôleur correspondant
        $controller = new $fullPathClass();

        // Récupère le nom de la méthode à appeler sur ce contrôleur
        $method = $controllerAction[1];

        // Exécute la méthode en lui passant les paramètres
        $controller->$method($params);

        // Termine le script après la redirection pour éviter toute suite d'exécution inutile
        exit();
    }
}
