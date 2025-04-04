<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Découvrez Orb'E, l'assistant personnel intelligent et innovant. Jouez à notre mini-jeu interactif, cumulez des points et bénéficiez de réductions exclusives sur votre achat. Un mélange unique de technologie !">
    <meta name="language" content="fr">
    <meta name="Geography" content="Vannes, FR, 56000">
    <meta name="customer" content="FR-USER-<?php
                                            if (isset($_SESSION['id'])) {
                                                echo $_SESSION['id'];
                                            } else {
                                                echo "00";
                                            } ?> ">
    <meta name="author" content="AY-Lab">
    <link rel="icon" href="./publique/images/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./publique/css/style.css">
    <link rel="stylesheet" href="./publique/css/<?=$commande["style"]?>">
    <script src="./publique/scripts/menu.js"  defer></script>
    <script src="./publique/scripts/article.js"  defer></script>
    <script type="module" src="./publique/scripts/visualiseur.js"></script>
    <title>Orb'E</title>
</head>

<body class="menu-open">

<header>
    <div class="logo"><a href="?action=accueil"><img src="./publique/images/logo/Logo_V1_white.webp" alt="Logo AYLab"></a></div>
    <button class="menu-toggle" >
    <svg  width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
        <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
    </svg>
</button>
    <?=$navContent?>
    <?php if(isset($_SESSION["id"])) { ?>
        <a href="./?action=profile">Mon profil</a>
        <a href="./?action=deconnexion">Déconnexion</a>
    <?php } else { ?>
        <a href="./?action=connexion">Connexion</a>
    <?php } ?>
</header>