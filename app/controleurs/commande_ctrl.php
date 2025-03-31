<?php
require RACINE."app/controleurs/navigation_ctrl.php";

use app\modeles\DBUser;
use app\modeles\DBProduct;
use app\class\GestionConnexion;




$connexion = new GestionConnexion();
$connexionDBUser = new DBUser();
$connexionDBProduct = new DBProduct();
$infoPerso = $connexionDBUser->infoUser($_SESSION["email"]);
$infoProduit = $connexionDBProduct->getProduct();




if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom = trim($_POST["prenom"] ?? '');
    $nom = trim($_POST["nom"] ?? '');
    $adresse = trim($_POST["adresse"] ?? '');
    $ville = trim($_POST["ville"] ?? '');
    $cp = trim($_POST["cp"] ?? '');
    $tel = trim($_POST["tel"] ?? '');
    $paiement = trim($_POST["paiement"] ?? '');

    $nomProduit = trim($_POST["nomProduit"] ?? '');
    $prix = trim($_POST["prix"] ?? '');
    $quantite = intval(trim($_POST["quantite"] ?? ''));
    $prixTotal = floatval($prix) * $quantite;
        
   
    if ($nom && $prenom && $adresse&& $ville && $cp && $tel) {
       $etat = $connexionDBUser->updateInfoUser($_SESSION["email"], $prenom, $nom, $adresse, $ville, $cp, $tel, $paiement);

        if ($etat) {
            $validation = "Les modifications ont été enregstrée";
            header("Location: ?action=commande");
        } else {
            $validation = "Une erreur c'est produite";
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=commande");
        }
    }

    if($nomProduit && $prix){
        $etat = false;
        $etat = $connexionDBProduct->addOrder($prixTotal,$_SESSION["id"], $_SESSION["id_produit"],$quantite);

        if ($etat) {
            $validation = "Votre commande est enregistrée !";
            unset($_SESSION["id_produit"]);
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=profile");
        } else {
            $validation = "Une erreur c'est produite !";
            // Redirection vers l'accueil si connexion réussie
            header("Location: ?action=commande");
        }
    }


} else {

    if(!$connexion->estConnecte()){
        header("Location: ?action=inscription");
        exit();
    }else{

        
        //Affichage des vues
        include_once RACINE . "app/vues/page_header.php";
        include_once RACINE . "app/vues/page_commande.php";
        include_once RACINE . "app/vues/page_footer.php"; 
    
    }
}







