<?php

    require_once RACINE . "app/modeles/bddUtilisateur.php";
    require RACINE."app/controleurs/navigation_ctrl.php";
    require RACINE."app/class/gestionConnexion.php";

    $gestionProfil = new DBUser();
    $listeUtilisateur = $gestionProfil->getUser("admin");
    $listeAdmin = $gestionProfil->getUser("utilisateur");


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST["email"] ?? '');
        $mdp = trim($_POST["mdp"] ?? '');
        $role = $_SESSION["role"];

        if ($email && $mdp && $role) {
            $connexion = new GestionConnexion();
            $etat = $connexion->inscription($email, $mdp, $role);

            if ($etat == true) {
                $validation = "Nouvel administrateur crée";
                // Redirection vers l'accueil si connexion réussie
                header("Location: ?action=utilisateur");
            } else {
                $validation = "Erreur lors de l'inscription.";
                // Redirection vers l'accueil si connexion réussie
                header("Location: ?action=utilisateur");
            }
        } else {
            $validation = "Tous les champs sont requis.";
            header("Location: ?action=utilisateur");
        }
    } else {

    include RACINE . "app/vues/page_header.php";
    include RACINE . "app/vues/admin/page_Ubo.php";
    include RACINE . "app/vues/page_footer.php";
    }
?>