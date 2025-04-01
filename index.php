<?php
// Inclusion des fichiers de configuration et des classes principales
define("RACINE", __DIR__. "/");
define('HTTP_HOST', 'http://' . $_SERVER['HTTP_HOST']);
define('SITE_NAME', "Orb'E");
define('CONTACT_EMAIL', 'laubert.yoann@gmail.fr');

require __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable((__DIR__ . "/"));
$dotenv->load();

use app\middleware\Middleware;

// Démarrer la session si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$controle = new Middleware;

$route = $controle->authMiddleware();

// Récupérer l'action demandée, sinon utiliser la valeur par défaut
$action = $_GET["action"] ?? "defaut";
$route->redirection($action); 

?>

