<?php
require RACINE."app/controleurs/navigation_ctrl.php";
include_once RACINE . "app/modeles/bddUtilisateur.php";

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["mdp"])){


    if($_POST["email"] != "" && $_POST["nom"] != "" && $_POST["mdp"] != "" && $_POST["prenom"] != ""){
        $email = $_POST["email"];
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $mdp = $_POST["mdp"];

        $connexion = new GestionConnexion();

        $etat = $connexion->inscription($nom, $prenom, $email, $mdp);

        if($etat){
            include RACINE . "app/vues/page_header.php";
            include RACINE . "app/vues/page_accueil.php";
            include RACINE . "app/vues/page_footer.php";
        }else{
            $validation = $etat;
            include RACINE . "app/vues/page_header.html.php";
            include RACINE . "app/vues/page_inscription.php";
            include RACINE . "app/vues/page_footer.html.php";
        }
        
    }
}
 else {
    // appel du script de vue qui permet de gerer l'affichage des donnees
    $validation = "*";
    include RACINE . "app/vues/page_header.php";
    include RACINE . "app/vues/page_inscription.php";
    include RACINE . "app/vues/page_footer.php";
}
?>