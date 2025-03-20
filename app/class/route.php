<?php
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
            "produit" => "#",
            "commande" => "#",
            "jeu" => "#",
            "connexion" => "#",
            "profile" => "#",
            "mentions" => "#",
            "qui" => "#",
            "contact" => "#",
            "page404" => self::ERROR_ROUTE,
        ];
    }

    public function redirection(string $action = "defaut"): void 
    {
        $this->action = $action;

        // Vérifie si l'action existe, sinon, renvoie vers la page 404
        $controller_id = $this->lesActions[$this->action] ?? self::ERROR_ROUTE;

        try {
            require $this->getFilePath($controller_id); // Inclusion sécurisée du fichier correspondant
        } catch (Exception $e) {
            error_log($e->getMessage()); // Log de l'erreur dans le fichier de logs
            require $this->getFilePath(self::ERROR_ROUTE); // Redirection vers la page d'erreur
        }
    }

    private function getFilePath(string $file): string
    {
        // Génère le chemin du fichier de contrôle
        $path = RACINE . "app/controleurs/" . $file;

        // Vérifie si le fichier existe, sinon, lève une exception
        if (!file_exists($path)) {
            throw new Exception("Le fichier de contrôle '$file' est introuvable.");
        }
        return $path;
    }
}
