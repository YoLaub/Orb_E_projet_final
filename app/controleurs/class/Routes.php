<?php

namespace app\controleurs\class;

use \Exception;

class Routes
{
    private array $lesActions; // Tableau associatif des actions et fichiers correspondants
    private string $action;
    private const DEFAULT_ROUTE = "accueil_ctrl.php"; // Définition d'une constante pour la route par défaut
    private const ERROR_ROUTE = "page404_ctrl.php"; // Route en cas d'erreur ou de page introuvable

    public function __construct()
    {
        // Définition des routes accessibles par tous les utilisateurs
        $this->lesActions = [
            "defaut"  => self::DEFAULT_ROUTE,
            "accueil" => self::DEFAULT_ROUTE,
            "produit" => "produit_ctrl.php",
            "commande" => "commande_ctrl.php",
            "jeu" => "jeu_ctrl.php",
            "connexion" => "connexion_ctrl.php",
            "inscription" => "inscription_ctrl.php",
            "profile" => "profile_ctrl.php",
            "mentions" => "mention_ctrl.php",
            "qui" => "qui_ctrl.php",
            "contact" => "contact_ctrl.php",
            "page404" => self::ERROR_ROUTE,
        ];
    }

    public function redirection(string $action = "defaut")
    {
        $this->action = $action;

        // Vérifie si l'action existe, sinon, renvoie vers la page 404
        $controller_id = $this->lesActions[$this->action] ?? self::ERROR_ROUTE;

        try {
            return $this->getFilePath($controller_id);
        } catch (Exception $e) {
            error_log($e->getMessage()); // Log l'erreur dans un fichier
            return $this->getFilePath(self::ERROR_ROUTE);
        }
    }

    private function getFilePath(string $file): string {
        // Chemin vers les fichiers du back-office
        $path = RACINE . "app/controleurs/" . $file; 

        // Vérifie si le fichier existe avant de l'inclure
        if (!file_exists($path)) {
            throw new Exception("Le fichier de contrôle '$file' est introuvable.");
        }
        return $path;
    }

  
}
