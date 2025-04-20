<?php

// Déclaration du namespace et inclusion du contrôleur de menu
namespace app\controleurs\class;

use app\controleurs\class\MenuControleur;

class RenderLayout
{
    // Déclaration de la propriété pour gérer le menu principal
    private $menuPrincipale;

    // Constructeur : initialise le menu principal via le contrôleur MenuControleur
    public function __construct()
    {
        $this->menuPrincipale = new MenuControleur("main-nav");
    }

    /**
     * Méthode pour générer et afficher (ou retourner) une page complète avec layout (header + footer)
     * 
     * @param string $target  Nom du fichier vue à charger
     * @param array  $params  Données à passer à la vue (optionnel)
     * @param bool   $return  Si true, retourne le contenu en tant que string sans l'afficher
     * 
     * @return string|null    Contenu de la page si $return est true, sinon affiche directement
     */
    public function render($target, $params = [], $return = false)
    {
        // Si $return est true : retourne le contenu généré sans l'afficher
        if ($return) {
            ob_start(); // Démarre la mise en mémoire tampon

            $commande = $params;             // Récupère les paramètres pour la vue
            $keys = array_keys($params);     // Récupère les clés des paramètres

            // Inclut le fichier de la vue ciblée
            require RACINE . 'app/vues/' . $target;

            $pageContent = ob_get_clean();   // Récupère et nettoie le contenu généré

            return $pageContent;             // Retourne le contenu de la page
        } else {
            ob_start(); // Démarre la mise en mémoire tampon

            $navContent = $this->menuPrincipale->prepareNav();  // Prépare le menu de navigation
            $commande = $params;                                // Récupère les paramètres pour la vue
            $keys = array_keys($params);                         // Récupère les clés des paramètres

            // Inclut les fichiers de layout (header, contenu principal, footer)
            require_once RACINE . "app/vues/page_header.php";
            require_once RACINE . 'app/vues/' . $target;
            require_once RACINE . "app/vues/page_footer.php";

            $pageContent = ob_get_clean();   // Récupère et nettoie le contenu généré

            echo $pageContent;               // Affiche le contenu de la page
        }
    }
}
