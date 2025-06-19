<?php 

require "./routes.php";

$url = $_SERVER["REQUEST_URI"];

$url = filter_var($url, FILTER_SANITIZE_URL);

$url = explode("?", $url)[0];

$url = trim($url, "/");

if(array_key_exists($url, ROUTES))
{
    // I specify that the name of my file is stored under the key "controller"
    $page = ROUTES[$url]["controller"];
    // The path of the file to load is in the "controller" folder
    $path = "./controller/$page";
    // The function to call is stored under the key "fonction"
    $fonction = ROUTES[$url]["fonction"];

    if(is_file($path))
    {
        // I require my controller.
        require $path;
        // I call the corresponding function:
        $fonction();
    }
    else
    {
        // I change the path to my 404 page
        require "./view/404.php";
    }
}
else
{
    // I change the path to my 404 page
    require "./view/404.php";
}
