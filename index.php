<?php
// Inclusion des fichiers de configuration et des classes principales
require dirname(__FILE__) . "/app/config.php";
require RACINE . "app/class/route.php";
require RACINE . "app/class/routePrive.php";
require RACINE . "app/modeles/connect.php";

// Démarrer la session si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si on est sur une route admin
if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    $route = new RoutesPrive();
} else {
    $route = new Routes();
}

// Récupérer l'action demandée, sinon utiliser la valeur par défaut
$action = $_GET["action"] ?? "defaut";
$route->redirection($action); 

?>

