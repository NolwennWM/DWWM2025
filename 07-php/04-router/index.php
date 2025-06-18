<?php 
/*
    Currently, no matter what URL is written, we are redirected to this file.
    So we'll ask it to process the URL and load the corresponding file.

    Requiring my routes:
*/
require "./routes.php";

// Retrieves the URL requested by the user:
$url = $_SERVER["REQUEST_URI"];

// Cleans the URL to remove unwanted characters
$url = filter_var($url, FILTER_SANITIZE_URL);
/* 
    explode splits a string into an array using the first parameter as a separator.
    Here we tell it to split the string at every "?" and only take the first element "[0]"
    This is to get rid of possible GET parameters
*/
$url = explode("?", $url)[0];

// With a second parameter, trim removes different characters at the beginning and end
$url = trim($url, "/");

// var_dump($url);

// Does our URL exist in our routes?
if(array_key_exists($url, ROUTES))
{
    $page = ROUTES[$url];
    $path = "pages/$page";
    // var_dump($page, $path);

    // Checks if the file at the given path exists
    if(is_file($path))
    {
        require $path;
    }
    else
    {
        // If the file doesn't exist, load our 404 page:
        require "pages/404.php";
    }
}
else
{
    // If the URL doesn't exist, load our 404 page:
    require "pages/404.php";
}

/* 
    ! WARNING about requires/include

    With the router, all files are required in the index.
    So the require paths in other files must be relative to the index, not to their own location.

    Two solutions:
        - Either make all requires relative to the index.
        - Or add "__DIR__" before each require to add the correct folder path.

    A more complete router:
        https://phprouter.com/
*/
