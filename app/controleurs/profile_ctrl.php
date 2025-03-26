<?php
require_once RACINE . "app/modeles/bddUtilisateur.php";
require RACINE."app/controleurs/navigation_ctrl.php";


$email = $_SESSION["email"];
$gestionProfil = new DBUser();
$informations = $gestionProfil->infoUser($email);
$commandes = $gestionProfil->getUserOrders($email);
$score = $gestionProfil->getUserScores($email);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom = trim($_POST["prenom"] ?? '');
    $nom = trim($_POST["nom"] ?? '');
    $adresse = trim($_POST["adresse"] ?? '');
    $ville = trim($_POST["ville"] ?? '');
    $cp = trim($_POST["cp"] ?? '');
    $tel = trim($_POST["tel"] ?? '');
   
    if ($email && $nom && $prenom && $adresse&& $ville && $cp && $tel) {
       $etat = $gestionProfil->updateInfoUser($email, $prenom, $nom, $adresse, $ville, $cp, $tel, $paiement);

        if ($etat) {
            $validation = "Les modifications ont été enregstrée";
            header("Location: ?action=profile");
        } else {
            $validation = "Une erreur c'est produite";
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=profile");
        }
    }
} else {

    //Affichage des vues
    include_once RACINE . "app/vues/page_header.php";
    include_once RACINE . "app/vues/page_profile.php";
    include_once RACINE . "app/vues/page_footer.php"; 
}

