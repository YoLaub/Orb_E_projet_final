<?php

include_once RACINE . "modeles/bddUtilisateur.php";

session_start();

$inscrit = false;
$msg=null;

// recuperation des donnees GET, POST, et SESSION
if (isset($_POST["mailU"]) && isset($_POST["mdpU"]) && isset($_POST["pseudoU"])) {

    if ($_POST["mailU"] != "" && $_POST["mdpU"] != "" && $_POST["pseudoU"] != "") {
        $mailU = $_POST["mailU"];
        $mdpU = $_POST["mdpU"];
        $pseudoU = $_POST["pseudoU"];

        // enregistrement des donnees
        $ret = ajouter_utilisateur($mailU, $mdpU, $pseudoU);
        if ($ret) {
            $inscrit = true;
        } else {
            $msg = "l'utilisateur n'a pas été enregistré.";
        }
    }
 else {
    $msg="Renseigner tous les champs...";    
    }
}

if ($inscrit) {
    // appel du script de vue qui permet de gerer l'affichage des donnees
    $titre = "Inscription confirmée";
    include RACINE . "/vues/entete.html.php";
    include RACINE . "/vues/vueConfirmationInscription.php";
    include RACINE . "/vues/pied.html.php";
} else {
    // appel du script de vue qui permet de gerer l'affichage des donnees
    $titre = "Inscription pb";
    include RACINE . "/vues/entete.html.php";
    include RACINE . "/vues/vueInscription.php";
    include RACINE . "/vues/pied.html.php";
}
?>