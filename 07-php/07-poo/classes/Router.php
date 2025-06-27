<?php
/**
 * Gets the route and launches the corresponding class and method
 */ 
class Router
{
    public static function routing()
    {
        $url = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);
        $url = explode("?", $url)[0];
        $url = trim($url, "/");

        if(array_key_exists($url, ROUTES))
        {
            $route = ROUTES[$url];
            // Instantiate the associated class:
            $controller = new ($route["controller"])();
            // Call the corresponding method:
            $controller->{$route["fonction"]}();
        }
        else
        {
            require "view/404.php";
        }
    }
}
