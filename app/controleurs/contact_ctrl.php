<?php
    require RACINE."app/controleurs/navigation_ctrl.php";
    require RACINE."app/modeles/bddContact.php";

    $validation = "* veuillez remplir tout les champs";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = htmlspecialchars($_POST["nom"]);

        if(isset($_SESSION["email"])){
            $email = $_SESSION["email"];
        }else{
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        }

        $message = htmlspecialchars($_POST["message"]);

        if(isset($_SESSION["id"])){
            $id_utlisateur = $_SESSION["id"];
        }else{
            $id_utlisateur = NULL;
        }

        $connexion = new DBContacts();


        if (!empty($nom) && !empty($email) && !empty($message)) {
            $etat = $connexion->saveMessage($nom, $email, $message, $id_utlisateur);
            if ($etat) {
                
                header("Location: ?action=contact");
            } else {
                header("Location: ?action=contact");
            }
        } else {
            header("Location: ?action=contact");
        }
    }
     //Affichage des vues
     include_once RACINE . "app/vues/page_header.php";
     include_once RACINE . "app/vues/page_contact.php";
     include_once RACINE . "app/vues/page_footer.php"; 
 



   

?>