<?php 
if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}

// If the user is not logged in
if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true)
{
    // Then redirect them elsewhere
    header("Location: ./04-connexion.php");
    exit;
}

/* 
    To log the user out,
    we simply remove the login-related information from the session.
        unset($_SESSION["logged"]);
        unset($_SESSION["username"]);
        unset($_SESSION["expire"]);
    Or, if there's nothing else stored in the session,
    we can destroy the entire session.
*/
unset($_SESSION);
session_destroy();
setcookie("PHPSESSID", "", time()-3600);

// Then once logged out, redirect the user elsewhere
header("Location: ./04-connexion.php");
exit;
?>
