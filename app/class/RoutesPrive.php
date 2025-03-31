<?php

namespace app\class;

use \Exception;

class RoutesPrive {
    private array $adminActions; // Tableau associatif des actions du back-office
    private string $action;
    private const ERROR_ROUTE = "page404_ctrl.php"; // Route d'erreur

    public function __construct() {
        // Liste des actions disponibles uniquement pour les administrateurs
        $this->adminActions = [
            "accueilBo" => "admin/accueil_bo_ctrl.php",
            "utilisateur" => "admin/utilisateur_bo_ctrl.php",
            "produit" => "admin/produit_bo_ctrl.php",
            "fiche" => "admin/fiche_p_bo_ctrl.php",
            "messagerie" => "admin/messagerie_ctrl.php",
            "connexion" => "connexion_ctrl.php",
            "suppression" => "composant/suppression_ctrl.php",
            "page404" => self::ERROR_ROUTE,
        ];
    }

    public function redirection(string $action = "accueilBo"): string {
    
        // Vérifie si l'utilisateur est bien un administrateur
        if (!$this->isAdmin()) {
            return $this->getFilePath("connexion_ctrl.php");
        }

        $this->action = $action;

        // Vérifie si l'action demandée existe, sinon, redirige vers la page 404
        $controller_id = $this->adminActions[$this->action] ?? self::ERROR_ROUTE;

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

    private function isAdmin(): bool {
        // Vérifie si la session contient un rôle administrateur
        return isset($_SESSION['role']) && $_SESSION['role'] === "admin";
    }
}

