<?php 
if(session_status() === PHP_SESSION_NONE)
session_start();
/**
 * Sets a token in the session and adds a hidden input containing the token.
 * 
 * Optionally adds an expiration time to the token.
 *
 * @param integer $time
 * @return void
 */
function setCSRF(int $time = 0): void
{
    // if $time is greater than 0, add an expiration time in the session
    if($time>0)
        $_SESSION["tokenExpire"] = time() + 60*$time; 
    /* 
        random_bytes returns a random number of bytes of the length given in parameter.
        bin2hex converts those bytes into hexadecimal.
        We store everything in the session.
    */
    $_SESSION["token"] = bin2hex(random_bytes(50));
    // Output a hidden input containing our token.
    echo '<input type="hidden" name="token" value="'.$_SESSION["token"].'">';
}
/**
 * Checks if the token is still valid.
 *
 * @return boolean
 */
function isCSRFValid(): bool
{
    // If the token has no expiration date or is still valid.
    if(!isset($_SESSION["tokenExpire"]) || $_SESSION["tokenExpire"] > time()){
        // If the token exists and matches the one submitted in the form.
        if( isset($_SESSION['token'],$_POST['token']) && $_SESSION['token'] == $_POST['token'])
        return true;
    }
    // Otherwise send a 405 Method Not Allowed header and return false.
    if(isset($_SERVER['SERVER_PROTOCOL']))
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    return false;
}
/* 
    Since this file will be included 
    in all our forms, let's put here our
    function to sanitize user input
    that we will reuse on every page.
*/
/**
 * Sanitize a string
 *
 * @param string $data
 * @return string
 */
function cleanData(string $data): string{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}
?>
