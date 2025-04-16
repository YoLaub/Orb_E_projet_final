<?php

namespace app\controleurs\class;

use app\modeles\DBUser;
use app\modeles\DBProduct;
use app\modeles\DBOrder;
use app\modeles\DBParty;

class AccueilControleur
{

    private $pageLayout;
    private $connexionUtilisateur;
    private $connexionCommande;
    private $connexionJeu;
    private $params;
    private $count;

    public function __construct()
    {
        $this->pageLayout = new RenderLayout;
        $this->connexionJeu = new DBParty();
        $this->params = array();
        $this->count = 3;
    }

    public function accueil()
    {

        $this->params["style"] = "style_accueil.css";
        $this->params["scripts"] = '<script src="./publique/scripts/consent.js" defer></script>';
        $this->params["meilleurJoueur"] = $this->connexionJeu->getFiveBestScores( $this->count);
        $this->params["page"] = 'Accueil';

        if (isset($_SESSION["role"])) {
            if ($_SESSION["role"] == "utilisateur") {
                $content = "page_accueil.php";
                $this->pageLayout->render($content, $this->params);
            } elseif ($_SESSION["role"] == "admin") {
                return $this->accueilBo();
            }
        } else {
            $content = "page_accueil.php";
            $this->pageLayout->render($content, $this->params);
        }
    }

    public function accueilBo()
    {

        $this->connexionUtilisateur = new DBUser();
        $this->connexionCommande = new DBOrder();

        $this->params["style"] = "style_accueil_bo.css";

        $commande = $this->connexionCommande->getAllOrder();

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
            $commandesGroupées[$id]["produits"][] = [
                "nom" => $ligne["nom_produit"],
                "description" => $ligne["description"],
                "prix" => $ligne["prix"],
                "quantité" => $ligne["quantité"],
                "total" => $ligne["total_produit"]
            ];
        }

        $table = 'commandes';
        $colonne = 'statut';


        $this->params["commande"] =  $commandesGroupées;
        $this->params["lesUtilisateurs"] = $this->connexionUtilisateur->numberOfUser();
        $this->params["meilleurJoueur"] = $this->connexionJeu->getFiveBestScores( $this->count);
        $this->params["total_score"] = $this->connexionJeu->totalScore();
        $this->params["select"] = $this->connexionCommande->showEnum($table, $colonne);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $idCommande = trim($_POST["idCommande"] ?? '');
            $statut = trim($_POST["statut"] ?? '');

            if ($idCommande && $statut) {
                $etat = $this->connexionCommande->updateStatus($statut, $idCommande);

                if ($etat) {
                    header("Location: ?action=accueilBo");
                    exit;
                } else {
                    return $content = "admin/page_accueil_bo.php";
                    $this->pageLayout->render($content, $this->params);
                }
            }
        } else {
            $content = "admin/page_accueil_bo.php";
            $this->pageLayout->render($content, $this->params);
        }
        $content = "admin/page_accueil_bo.php";
        $this->pageLayout->render($content, $this->params);
    }
}
