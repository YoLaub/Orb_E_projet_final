<?php
require_once RACINE . "app/class/gestionConnexion.php";
require_once RACINE . "app/modeles/bddUtilisateur.php";
require RACINE . "app/controleurs/navigation_ctrl.php";




// Vérification de la requête POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');
    $mdp = trim($_POST["password"] ?? '');


    if (!empty($email) && !empty($mdp)) {
 
        $connexion = new GestionConnexion();
        $estConnecte = $connexion->connexion($email, $mdp);

        if ($estConnecte==true && isset($_SESSION["role"]) && $_SESSION["role"] == "utilisateur") {
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=accueil");
        }elseif($estConnecte == true && isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
            header("Location: ?action=accueilBo");;
        } 
        exit(); // Assure que le script s'arrête ici
    }
}else{

    $connexion = new GestionConnexion();
    $connexion->deconnexion();
    
    // Inclusion de la page connexion avec un message d'erreur si nécessaire
    include RACINE . "app/vues/page_header.php";
    include RACINE . "app/vues/page_connexion.php";
    include RACINE . "app/vues/page_footer.php";

}


?>
