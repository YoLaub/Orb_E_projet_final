<?php
// Inclusion des fichiers de configuration et des classes principales
define("RACINE", __DIR__. "/");

require __DIR__.'/vendor/autoload.php';


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable((__DIR__ . "/"));
$dotenv->load();


use app\modeles\DbConnect;
use app\class\Routes;
use app\class\RoutesPrive;




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
require $route->redirection($action); 

?>

