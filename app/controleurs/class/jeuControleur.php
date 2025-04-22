<?php

namespace app\controleurs\class;

use app\middleware\Middleware;
use app\modeles\DBParty;
use app\modeles\DBOrder;

class JeuControleur
{
    private $pageLayout;       // Gère l'affichage de la page avec le layout défini
    private $connexion;        // Instance du middleware pour la gestion des accès
    private $partie;           // Instance du modèle pour gérer les scores du jeu
    private $params;           // Paramètres envoyés à la vue
    private $infoJoueur;       // Permet de récupérer les informations utilisateur liées à une commande

    public function __construct()
    {
        $this->pageLayout = new RenderLayout;                          // Initialisation du système de rendu
        $this->connexion = new Middleware;                             // Initialisation du middleware pour vérifier les autorisations
        $this->partie = new DBParty;                                   // Accès aux méthodes de gestion des parties de jeu
        $this->infoJoueur = new DBOrder;                               // Accès aux données utilisateur liées à une commande

        
        $this->params["infoProfil"] = isset($_SESSION["email"]) ? $this->infoJoueur->infoUser($_SESSION["email"]) : null; // Récupération des infos profil utilisateur
        $this->params["style"] = "orbe.css";                           // Feuille de style à charger pour le jeu
        $this->params["scripts"] = '<script type="module" src="./publique/scripts/orbe/ballRun.js" defer></script>
        <script src="./publique/scripts/orbe/fullscreen.js" defer></script>'; // Scripts JS nécessaires pour le jeu
        $this->params["page"] = "Jouer";                               // Titre de la page
        $this->params["meta"] = '<meta property="og:title" content="Orbe" >
        <meta property="og:image" content="./publique/images/commande_ex.webp" >
        <meta property="og:url" content="https://stagiaires-kercode9.greta-bretagne-sud.org/yoann-laubert/Orb_E_projet_final/ >
        <meta property="og:type" content="game" >';                   // Métadonnées pour le partage sur les réseaux sociaux
    }

    // Affiche la page de jeu et enregistre le score si une requête POST est reçue
    public function pageJeu()
    {
        $zone = "jeu";
        if ($this->connexion->accesMiddleware($zone)) { // Vérifie que l'utilisateur est autorisé à accéder à la page

            if ($_SERVER["REQUEST_METHOD"] === "POST") { // Si l'utilisateur envoie une requête POST (soumission de score)
                $idUtilisateur = $_SESSION["id"] ?? ""; // Récupération de l'id utilisateur depuis la session
                $data = json_decode(file_get_contents("php://input"), true); // Récupère les données JSON envoyées
                $score = $data["score"] ?? ""; // Extraction du score
                $_SESSION["score"] = $score; // Stockage temporaire du score en session

                // Si l'utilisateur est identifié et un score a bien été envoyé
                if (!empty($idUtilisateur) && !empty($score)) {
                    $etat = $this->partie->saveScore($score, $idUtilisateur); // Sauvegarde du score dans la base de données
                    if ($etat) {
                        return $this->pageLayout->render("page_jeu.php", $this->params); // Affiche la page avec succès
                    } else {
                        $this->params["message"] = "Une erreur c'est produite !"; // Message d'erreur si l'enregistrement échoue
                        return $this->pageLayout->render("page_jeu.php", $this->params);
                    }
                    // Ce message n’est jamais atteint car le return ci-dessus sort de la méthode
                    $this->params["message"] = "Vous n'êtes probablement pas autorisé à jouer, inscrivez vous !!";
                    return $this->pageLayout->render("page_jeu.php", $this->params);
                }
            }

            // Affiche simplement la page de jeu (GET)
            $content = "page_jeu.php";
            $this->pageLayout->render($content, $this->params);
        } else {
            // Si l'utilisateur n'est pas connecté, stocke l'URL en session et redirige vers la page de connexion
            $_SESSION["url"] = $_SERVER['REQUEST_URI'];
            header("Location: connexion");
        }
    }

    // Permet d'enregistrer le nom d'un joueur s'il n'a pas encore été défini
    public function saveName()
    {
        $infoProfil =  $this->infoJoueur->infoUser($_SESSION["email"]); // Récupère les informations de l'utilisateur connecté

        if ($_SERVER["REQUEST_METHOD"] === "POST") { // Si la requête est un POST (soumission du formulaire)

            $idUtilisateur = $_SESSION["id"] ?? ""; // Récupération de l'id utilisateur
            $nom = trim($_POST["nom"] ?? ''); // Récupération et nettoyage du nom soumis

            // Récupération des autres infos nécessaires à la création du profil
            $prenom = $infoProfil[0]["prenom"] ?? "";
            $adresse = $infoProfil[0]["adresse_livraison"] ?? "";
            $ville = $infoProfil[0]["ville"] ?? "";
            $cp = $infoProfil[0]["code_postal"] ?? "";
            $tel = $infoProfil[0]["telephone"] ?? "";
            $pays = $infoProfil[0]["pays"] ?? "";
            $paiement = $infoProfil[0]["prenom"] ?? "";

            // Si l'utilisateur est bien connecté
            if (!empty($idUtilisateur)) {
                // Si l'utilisateur n'a pas encore renseigné son nom
                if (empty($infoProfil[0]["nom"])) {
                    $etat =  $this->infoJoueur->createInfoUser($idUtilisateur, $prenom, $nom, $adresse, $ville, $cp, $tel, $pays, $paiement); // Enregistre les infos en base
                    if ($etat) {
                        header("Location: jeu"); // Redirige vers la page de jeu après succès
                        exit();
                    } else {
                        $_SESSION["message"] = "Une erreur c'est produite !"; // Message d’erreur
                        header("Location: jeu");
                        exit();
                    }
                }
                // Si le nom est déjà renseigné, affiche un message
                $this->params["message"] = "Vous avez déjà entré votre nom !";
                return $this->pageLayout->render("page_jeu.php", $this->params);
            }

            // Si aucune info utilisateur n'est trouvée, on recharge la page
            $content = "page_jeu.php";
            $this->pageLayout->render($content, $this->params);
        }
    }
}
