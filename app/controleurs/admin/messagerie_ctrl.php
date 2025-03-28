<?php
    require RACINE."app/controleurs/navigation_ctrl.php";
    require RACINE."app/modeles/bddContact.php";
    require RACINE."app/modeles/bddReponse.php";

    $connexionContact = new DBContacts();
    $connexionReponse = new DBResponse();

    $lesMessages = $connexionContact->getMessage();
    $lesReponses = $connexionReponse->getReponse();

    $validation = "* veuillez remplir tout les champs";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id_contact = htmlspecialchars($_POST["id_contact"]);
        $reponse = htmlspecialchars($_POST["reponse"]);

        if(isset($_SESSION["id"])){
            $id_admin = $_SESSION["id"];
        }else{
            $id_admin = NULL;
        }

        


        if (!empty($id_contact) && !empty($id_admin) && !empty($reponse)) {
            $etat = $connexionReponse->saveMessageAdmin($id_contact, $id_admin, $reponse);
            if ($etat) {
                
                header("Location: ?action=messagerie");
            } else {
                header("Location: ?action=messagerie");
            }
        } else {
            header("Location: ?action=messagerie");
        }
    }
     //Affichage des vues
     include_once RACINE . "app/vues/page_header.php";
     include_once RACINE . "app/vues/admin/page_messagerie_bo.php";
     include_once RACINE . "app/vues/page_footer.php"; 