<?php 
/*
    The header is the beginning of the request, it will be read by the browser.
    Normally, the header() function must be called before any HTML output.
    With headers, we can trigger several different actions:
*/
/* "HTTP/" allows you to modify the status code sent
200, 300, 404...
For example, here we turn our page into a 404. */
header("HTTP/1.1 404 Not Found");
// http_response_code allows us to get the status code.
echo http_response_code();
/* "Location:" will trigger a redirection, changing the 
status code to 302 and redirecting to the specified page
(the link can be relative or absolute) */ 
if(rand(0, 100)<50){
    header("Location: 09-b-header.php");
    /* exit ends the current script;
    It is good practice to use it after a redirection
    to ensure the server doesn't do unnecessary work */
    exit;
    /* 
    exit can be useful for debugging as it stops
    the current PHP script to help identify where 
    a problem is occurring.
    Optionally, exit can display a message:
    exit("We stop here!");

    For those who prefer, exit has an alias named:
    die;
    */
}
// header("Location: 09-b-header.php");
$title = " header page 1";
require("../ressources/template/_header.php");
?>
<h1>You’re lucky to be able to see me.</h1>
<?php
require("../ressources/template/_footer.php");
?>
