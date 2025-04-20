<?php

namespace app\controleurs\class;

use app\modeles\DBUser;
use app\modeles\DBOrder;
use app\modeles\DBParty;

class AccueilControleur
{
    // Attributs privés pour gérer les connexions aux différents modules
    private $pageLayout;              // Objet pour gérer le rendu de la page
    private $connexionUtilisateur;   // Connexion au modèle utilisateur
    private $connexionCommande;      // Connexion au modèle commande
    private $connexionJeu;           // Connexion au modèle des parties du jeu
    private $params;                 // Paramètres transmis à la vue
    private $count;                  // Nombre de meilleurs scores à récupérer

    public function __construct()
    {
        // Initialisation des objets nécessaires
        $this->pageLayout = new RenderLayout;
        $this->connexionJeu = new DBParty();
        $this->params = array();
        $this->count = 3; // On affiche les 3 meilleurs joueurs
    }

    // Méthode principale appelée pour afficher la page d'accueil
    public function accueil()
    {
        // Définition des paramètres de style et de script JS
        $this->params["style"] = "style_accueil.css";
        $this->params["scripts"] = '<script src="./publique/scripts/consent.js" defer></script>';

        // Récupération des meilleurs joueurs à afficher
        $this->params["meilleurJoueur"] = $this->connexionJeu->getFiveBestScores($this->count);

        // Définition du nom de la page
        $this->params["page"] = 'Accueil';

        // Si l'utilisateur est connecté
        if (isset($_SESSION["role"])) {
            // Affichage selon le rôle
            if ($_SESSION["role"] == "utilisateur") {
                $content = "page_accueil.php";
                $this->pageLayout->render($content, $this->params);
            } elseif ($_SESSION["role"] == "admin") {
                // Redirection vers l'accueil back-office
                return $this->accueilBo();
            }
        } else {
            // Utilisateur non connecté, affichage de la page publique
            $content = "page_accueil.php";
            $this->pageLayout->render($content, $this->params);
        }
    }

    // Méthode pour afficher l'accueil du back-office (admin uniquement)
    public function accueilBo()
    {
        // Connexion aux modèles nécessaires pour le back-office
        $this->connexionUtilisateur = new DBUser();
        $this->connexionCommande = new DBOrder();

        // Style spécifique au back-office
        $this->params["style"] = "style_accueil_bo.css";

        // Récupération de toutes les commandes
        $commande = $this->connexionCommande->getAllOrder();

        // Regroupement des commandes par ID pour affichage structuré
        $commandesGroupées = [];
        foreach ($commande as $ligne) {
            $id = $ligne["id_commande"];
            if (!isset($commandesGroupées[$id])) {
                $commandesGroupées[$id] = [
                    "date_heure" => $ligne["date_heure"],
                    "montant_total" => $ligne["montant_total"],
                    "statut" => $ligne["statut"],
                    "produits" => []
                ];
            }
            // Ajout des produits associés à chaque commande
            $commandesGroupées[$id]["produits"][] = [
                "nom" => $ligne["nom_produit"],
                "description" => $ligne["description"],
                "prix" => $ligne["prix"],
                "quantité" => $ligne["quantité"],
                "total" => $ligne["total_produit"]
            ];
        }

        // Paramètres pour l'affichage des données back-office
        $table = 'commandes';
        $colonne = 'statut';

        $this->params["commande"] = $commandesGroupées;
        $this->params["lesUtilisateurs"] = $this->connexionUtilisateur->numberOfUser();
        $this->params["meilleurJoueur"] = $this->connexionJeu->getFiveBestScores($this->count);
        $this->params["total_score"] = $this->connexionJeu->totalScore();
        $this->params["select"] = $this->connexionCommande->showEnum($table, $colonne);

        // Traitement de la soumission du formulaire de modification de statut
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $idCommande = trim($_POST["idCommande"] ?? '');
            $statut = trim($_POST["statut"] ?? '');

            // Mise à jour du statut si les données sont valides
            if ($idCommande && $statut) {
                $etat = $this->connexionCommande->updateStatus($statut, $idCommande);

                // Si la mise à jour a réussi, on recharge la page
                if ($etat) {
                    header("Location: ?action=accueilBo");
                    exit;
                } else {
                    // Sinon, on reste sur la page d'accueil BO avec les données
                    return $content = "admin/page_accueil_bo.php";
                    $this->pageLayout->render($content, $this->params);
                }
            }
        } else {
            // Affichage initial de la page d'accueil BO (GET)
            $content = "admin/page_accueil_bo.php";
            $this->pageLayout->render($content, $this->params);
        }

        // Double appel pour garantir le rendu de la page dans tous les cas
        $content = "admin/page_accueil_bo.php";
        $this->pageLayout->render($content, $this->params);
    }
}
