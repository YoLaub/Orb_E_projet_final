<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Découvrez Orb'E, l'assistant personnel intelligent et innovant. Jouez à notre mini-jeu interactif, cumulez des points et bénéficiez de réductions exclusives sur votre achat. Un mélange unique de technologie !">
    <meta name="language" content="fr">
    <meta name="Geography" content="Vannes, FR, 56000">
    <meta name="customer" content="FR-USER-<?= $_SESSION['id'] ?? "00" ?>">

    <meta name="author" content="AY-Lab">
    <?= $commande["meta"] ?? "" ?>
    <link rel="icon" href="./publique/images/logo/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./publique/css/style.css">
    <link rel="stylesheet" href="./publique/css/<?= $commande["style"] ?>">
    <script src="./publique/scripts/menu.js" defer></script>
    <script src="./publique/scripts/article.js" defer></script>
    <script src="./publique/scripts/modal_profile.js" defer></script>
    <script type="module" src="./publique/scripts/visualiseur.js" defer></script>
    <script src="./publique/scripts/rechercheUtilisateur.js" defer></script>
    <script src="./publique/scripts/rechercheMessage.js" defer></script>
    <script src="./publique/scripts/preview_photo.js" defer></script>
    <title>Orb'E</title>
</head>

<body class="menu-open">

    <header>
        <div class="logo"><a href="?action=accueil"><img src="./publique/images/logo/Logo_V1_white.webp" alt="Logo AYLab"></a></div>
        <?= $navContent ?>
        <div class="iconHeader">
            <p class="menu-toggle">
                <svg width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                </svg>
            </p>

            <?php if (isset($_SESSION["id"]) && isset($_SESSION["role"]) && $_SESSION["role"] == "utilisateur") { ?>
                <a href="./?action=profile">
                    <svg width="32" height="32" fill="white" class="bi bi-person-badge" viewBox="0 0 16 16">
                        <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492z" />
                    </svg>
                </a>
                <a href="./?action=deconnexion">
                <svg  width="32" height="32" fill="white" class="bi bi-door-closed" viewBox="0 0 16 16">
                    <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3zm1 13h8V2H4z"/>
                    <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0"/>
                </svg>
                </a>

            <?php } elseif(isset($_SESSION["role"]) && $_SESSION["role"] == "admin") { ?>
                <a href="./?action=deconnexion">
                <svg  width="32" height="32" fill="white" class="bi bi-door-closed" viewBox="0 0 16 16">
                    <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3zm1 13h8V2H4z"/>
                    <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0"/>
                </svg>
                </a>

            <?php }else{?>
                <a href="./?action=connexion">
                    <svg width="32" height="32" fill="white" class="bi bi-power" viewBox="0 0 16 16">
                        <path d="M7.5 1v7h1V1z" />
                        <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                    </svg>
                </a>
            <?php } ?>
        </div>

    </header>

    <main>