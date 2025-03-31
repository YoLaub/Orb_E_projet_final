<?php
require_once RACINE . "app/controleurs/navigation_ctrl.php";


use app\controleurs\class\GestionConnexion;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');
    $mdp = trim($_POST["mdp"] ?? '');

    if ($email && $mdp) {
        $connexion = new GestionConnexion();
        $etat = $connexion->inscription($email, $mdp);

        if ($etat) {
            $connexion->connexion($email, $mdp);
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=accueil");
        } else {
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=inscription");
        }
    } else {
        header("Location: ?action=inscription");
    }
} else {

include RACINE . "app/vues/page_header.php";
include RACINE . "app/vues/page_inscription.php";
include RACINE . "app/vues/page_footer.php";
}
?>