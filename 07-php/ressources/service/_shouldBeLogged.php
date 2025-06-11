<?php
if(session_status() === PHP_SESSION_NONE)
	session_start();

/**
 * Checks whether the user is logged in or not and redirects if not.
 * 
 * If the Boolean is true, checks if the user is logged in. 
 * If the Boolean is false, checks if the user is logged out.
 * The second argument indicates where to redirect the user.
 *
 * @param boolean $logged
 * @param string $redirect
 * @return void
 */
function shouldBeLogged(bool $logged = true, string $redirect = "/"): void
{
    if($logged)
    {
        if(isset($_SESSION["expire"]))
        {
            // If the session has expired, it is destroyed
            if(time()> $_SESSION["expire"])
            {
                unset($_SESSION);
                session_destroy();
                setcookie("PHPSESSID", "", time()-3600);
            }else
            {
                // Otherwise, it is renewed for one hour
                $_SESSION["expire"] = time() + 3600;
            }
        } // end of expiration check
        if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true)
        {
            // If the user is not logged in, redirect them.
            header("Location: $redirect");
            exit;
        }
    }
    else
    {
        /* 
            If the user must be logged out to access the page,
            then we check if they are logged in,
            and in that case, we redirect them
        */
        if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)
        {
            header("Location: $redirect");
            exit;
        }
    }
}
/**
 * Redirects the user if they do not match the ID provided via GET or POST;
 *
 * @param string $redirect
 * @param string $index 
 * @param string $session
 * @return string
 */
function isSelectedUser(string $redirect = "/", string $index = "id", string $session = "idUser"): string
{
    $selectedId = $_GET[$index] ?? $_POST[$index]?? false;

    if(!isset($_SESSION[$session]) || $_SESSION[$session] != $selectedId)
    {
        header("Location: ".$redirect);
        exit;
    }
    return $selectedId;
}
?>