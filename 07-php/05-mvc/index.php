<?php 

require "./routes.php";

$url = $_SERVER["REQUEST_URI"];

$url = filter_var($url, FILTER_SANITIZE_URL);

$url = explode("?", $url)[0];

$url = trim($url, "/");

if(array_key_exists($url, ROUTES))
{
    $page = ROUTES[$url];
    $path = "pages/$page";

    if(is_file($path))
    {
        require $path;
    }
    else
    {
        require "pages/404.php";
    }
}
else
{
    require "pages/404.php";
}
