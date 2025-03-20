<?php

class RoutesPrive {
    private array $adminActions; // Tableau associatif des actions du back-office
    private string $action;
    private const ERROR_ROUTE = "page404.php"; // Route d'erreur

    public function __construct() {
        // Liste des actions disponibles uniquement pour les administrateurs
        $this->adminActions = [
            "accueilBo" => "#",
            "utilisateur" => "#",
            "produit" => "#",
            "fiche" => "#",
            "page404" => self::ERROR_ROUTE,
        ];
    }

    public function redirection(string $action = "accueilBo"): void {
        session_start(); // Démarre la session (nécessaire pour vérifier le rôle de l'utilisateur)

        // Vérifie si l'utilisateur est bien un administrateur
        if (!$this->isAdmin()) {
            header("Location: /App/controleur/" . self::ERROR_ROUTE);
            exit;
        }

        $this->action = $action;

        // Vérifie si l'action demandée existe, sinon, redirige vers la page 404
        $controller_id = $this->adminActions[$this->action] ?? self::ERROR_ROUTE;

        try {
            require $this->getFilePath($controller_id);
        } catch (Exception $e) {
            error_log($e->getMessage()); // Log l'erreur dans un fichier
            require $this->getFilePath(self::ERROR_ROUTE);
        }
    }

    private function getFilePath(string $file): string {
        // Chemin vers les fichiers du back-office
        $path = RACINE . "/App/controleur/admin/" . $file;

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

