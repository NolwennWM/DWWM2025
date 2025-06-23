<?php

try
{
    // Récupération et nettoyage de l'URL appelée
    $url = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);
    $url = explode("?", $url)[0]; // Suppression des éventuels paramètres GET
    $url = trim($url, "/");       // Suppression du slash en début/fin

    // Vérifie si l'URL correspond à une route définie
    if (array_key_exists($url, ROUTES)) {
        // Inclusion du contrôleur correspondant à la route
        $controllerPath = "./controller/" . ROUTES[$url];
        if (file_exists($controllerPath)) {
            require($controllerPath);
        } else {
            // TODO
        }
    } else {
        // TODO
    }
}
catch (\Throwable $e) {
    // TODO
}
