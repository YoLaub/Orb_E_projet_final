<?php

namespace app\middleware;

use app\controleurs\class\Routes;
use app\controleurs\class\RoutesPrive;

class Middleware
{

    public function __construct() {}

    public function authMiddleware()
    {

        if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {

            return new RoutesPrive;
        } else {
            return new Routes;
        }
    }
    public function accesMiddleware()
    {

        if (isset($_SESSION["role"]) && $_SESSION["role"] = "utilisateur") {

            return true;
        } else {
            return false;
        }
    }
}
