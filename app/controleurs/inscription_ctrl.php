<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";
require_once RACINE . "app/class/gestionConnexion.php";
require_once RACINE . "app/modeles/bddUtilisateur.php";

$validation = "*";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');
    $prenom = trim($_POST["prenom"] ?? '');
    $nom = trim($_POST["nom"] ?? '');
    $mdp = trim($_POST["mdp"] ?? '');

    if ($email && $prenom && $nom && $mdp) {
        $connexion = new GestionConnexion();
        $etat = $connexion->inscription($nom, $prenom, $email, $mdp);

        if ($etat) {
            $connexion->connexion($email, $mdp);
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=accueil");
        } else {
            $validation = "Erreur lors de l'inscription.";
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=inscription");
        }
    } else {
        $validation = "Tous les champs sont requis.";
        header("Location: ?action=inscription");
    }
} else {

include RACINE . "app/vues/page_header.php";
include RACINE . "app/vues/page_inscription.php";
include RACINE . "app/vues/page_footer.php";
}
?>