<?php

namespace app\controleurs\class;

use app\controleurs\class\Connexion;


class Routes
{
    private array $lesActions; // Tableau associatif des actions et fichiers correspondants
    private string $action; // Action courante demandée par l'utilisateur
    private $params; // Paramètres associés à l'action
    private const DEFAULT_ROUTE = "AccueilControleur:accueil"; // Route par défaut (utilisée si aucune action n'est spécifiée)
    private const ERROR_ROUTE = "page404.php"; // Route utilisée en cas d'erreur ou de page non trouvée

    public function __construct()
    {
        // Définition des routes disponibles et leur correspondance contrôleur:methode
        $this->lesActions = [
            "defaut"  => self::DEFAULT_ROUTE,
            "accueil" => self::DEFAULT_ROUTE,
            "produit" => "ProduitControleur:pageProduit", // Affichage des produits
            "commande" => "ProfilControleur:pageCommande", // Affichage du processus de commande
            "jeu" => "JeuControleur:pageJeu", // Page de jeu
            "save" => "JeuControleur:saveName", // Sauvegarde du nom dans le jeu
            "connexion" => "Connexion:connexionUtilisateur", // Connexion utilisateur
            "deconnexion" => "Connexion:deconnexion", // Déconnexion utilisateur
            "inscription" => "Connexion:inscription", // Inscription utilisateur
            "ajouterCommande" => "ProfilControleur:ajouterCommande", // Ajout d'une commande
            "profile" => "ProfilControleur:pageProfil", // Affichage du profil utilisateur
            "rgpd" => "ArticleControleur:pageRgpd", // Page RGPD
            "engagement" => "ArticleControleur:pageEngagement", // Page d'engagements
            "rechercheR" => "ContactControleur:rechercheReponse", // Recherche de réponse par contact
            "cgv" => "ArticleControleur:pageCgv", // Conditions générales de vente
            "faq" => "ArticleControleur:pageFaq", // Foire aux questions
            "qui" => "ArticleControleur:pageQui", // Présentation de l'entreprise
            "contact" => "ContactControleur:pageContact", // Formulaire de contact
            "page404" => self::ERROR_ROUTE, // Page d'erreur personnalisée
        ];
    }

    public function redirection(string $action = "defaut", array $params = [])
    {
        $this->action = $action; // Récupère l'action demandée
        $this->params = $params; // Récupère les paramètres éventuels

        if(isset($this->lesActions[$this->action])){
                    // Vérifie si l'action demandée est bien définie dans le tableau des routes, sinon, redirige vers page404
        $controllerAction = explode(":", $this->lesActions[$this->action]);

        // Construit le chemin complet vers le contrôleur (espace de nom + nom de classe)
        $fullPathClass =  __NAMESPACE__ . "\\" . $controllerAction[0];

        // Instancie dynamiquement le contrôleur
        $controller = new $fullPathClass();

        // Récupère la méthode à appeler
        $method = $controllerAction[1];

        // Appelle la méthode du contrôleur en lui passant les paramètres
        $controller->$method($params);

        // Termine le script après la redirection
        exit();
        }else{
            $pageError = new RenderLayout;
            $pageError->render($this->lesActions['page404'] ,  $this->params,false);
        }

    }
}
