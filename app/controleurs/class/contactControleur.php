<?php

namespace app\controleurs\class;

use app\modeles\DBContacts;
use app\modeles\DBResponse;

class ContactControleur
{
    // Connexion au modèle DBContacts pour gérer les messages utilisateurs
    private $connexion;

    // Connexion au modèle DBResponse pour gérer les réponses des administrateurs
    private $connexionReponse;

    // Gestionnaire de rendu de page
    private $pageLayout;

    // Tableau de paramètres à passer aux vues
    private $params;

    public function __construct()
    {
        // Initialisation des connexions aux modèles et du moteur de rendu
        $this->connexion = new DBContacts;
        $this->connexionReponse = new DBResponse;
        $this->pageLayout = new RenderLayout;
        $this->params = array();
    }

    // Affiche la page de contact et traite l'envoi de formulaire si POST
    public function pageContact()
    {
        // Définition des ressources nécessaires à la page
        $this->params["style"] = "style_contact.css";
        $this->params["scripts"] = '<script src="./publique/scripts/contact.js" defer></script>';
        $this->params["page"] = "Contactez nous";

        // Si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Sécurisation des données saisies
            $nom = htmlspecialchars($_POST["nom"]);
            $email = htmlspecialchars($_POST["email"]);
            $message = htmlspecialchars($_POST["message"]);

            // Vérifie si l'utilisateur est connecté, sinon NULL
            if (isset($_SESSION["id"])) {
                $id_utilisateur = $_SESSION["id"];
            } else {
                $id_utilisateur = NULL;
            }

            // Champ caché utilisé comme honeypot anti-bot
            $prtg = htmlspecialchars($_POST["prtg"]);

            // Nouvelle instance de DBContacts (peut être factorisé)
            $connexion = new DBContacts();

            // Vérifie les conditions de validité du message
            if (isset($_POST["term"]) && empty($prtg) && !empty($nom) && !empty($email) && !empty($message)) {
                // Sauvegarde le message en base de données
                $etat = $connexion->saveMessage($nom, $email, $message, $id_utilisateur);

                // Si l'enregistrement a réussi, on recharge la page (Post/Redirect/Get)
                if ($etat) {
                    header("Location: ?action=contact");
                    exit;
                } else {
                    // Affiche la page avec les paramètres (échec de l'enregistrement)
                    return $this->pageLayout->render("page_contact.php", $this->params);
                }
            } else {
                // Affiche la page si champs invalides ou tentative de spam
                return $this->pageLayout->render("page_contact.php", $this->params);
            }
        }

        // Affiche la page si pas de soumission POST
        return $this->pageLayout->render("page_contact.php", $this->params);
    }

    // Affiche la messagerie dans le back-office et traite l'envoi de réponse
    public function pageContactBo()
    {
        // Récupère tous les messages et réponses pour les afficher dans le BO
        $this->params["lesMessages"] = $this->connexion->getMessage();
        $this->params["lesReponses"] = $this->connexionReponse->getReponse();
        $this->params["style"] = "style_messagerie.css";
        $this->params["scripts"] = '<script src="./publique/scripts/rechercheMessage.js" defer></script>';

        // Si une réponse est envoyée via POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Récupération et sécurisation des données du formulaire
            $id_contact = htmlspecialchars($_POST["id_contact"]);
            $reponse = htmlspecialchars($_POST["reponse"]);

            // Récupération de l'identifiant de l'admin connecté
            if (isset($_SESSION["id"])) {
                $id_admin = $_SESSION["id"];
            } else {
                $id_admin = NULL;
            }

            // Vérifie que tous les champs requis sont remplis
            if (!empty($id_contact) && !empty($id_admin) && !empty($reponse)) {
                // Enregistre la réponse de l'admin dans la base
                $etat =  $this->connexionReponse->saveMessageAdmin($id_contact, $id_admin, $reponse);

                // Redirection vers la messagerie si succès
                if ($etat) {
                    header("Location: ?action=messagerie");
                } else {
                    // Sinon on recharge la page avec les données actuelles
                    return $this->pageLayout->render("admin/page_messagerie_bo.php", $this->params);
                }
            } else {
                // En cas de champs manquants, on recharge aussi la page
                return $this->pageLayout->render("admin/page_messagerie_bo.php", $this->params);
            }
        }

        // Affiche la page messagerie s’il n’y a pas de POST
        return $this->pageLayout->render("admin/page_messagerie_bo.php", $this->params);
    }

    // Recherche des messages par email (utilisé côté admin pour filtrer)
    public function rechercheMessage()
    {
        if (isset($_POST['terme'])) {
            // Préparation du terme de recherche avec joker SQL
            $terme = "%" . trim($_POST['terme']) . "%";

            // Appel du modèle pour chercher les messages par email
            $message = $this->connexion->searchMessagePerEmail($terme);

            // Envoie la réponse en JSON (utilisé en AJAX)
            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
        }
    }

    // Recherche des messages par date
    public function rechercheMessageD()
    {
        if (isset($_POST['terme'])) {
            // Nettoyage du terme
            $terme = trim($_POST['terme']);

            // Recherche en base de données selon la date
            $message = $this->connexion->searchMessagePerDate($terme);

            // Renvoie les résultats en JSON
            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
        }
    }

    // Recherche des réponses par identifiant de message
    public function rechercheReponse()
    {
        if (isset($_POST['terme'])) {
            // Cast du terme en entier
            $terme = intval(trim($_POST['terme']));

            // Recherche des réponses liées à un ID de message
            $message = $this->connexionReponse->getReponsesPerId($terme);

            // Retour JSON pour AJAX
            header('Content-Type: application/json');
            echo json_encode($message);
            exit;
        }
    }
}
