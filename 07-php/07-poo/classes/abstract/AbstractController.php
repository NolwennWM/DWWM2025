<?php
// To make the autoloader work, I set a namespace matching my folders
namespace Classes\Abstract;

require __DIR__."/../../../ressources/service/_shouldBeLogged.php";
require __DIR__."/../../../ressources/service/_csrf.php";
/** 
 * An abstract class cannot be instantiated.
 * Its role is to be inherited by all controllers to provide them with shared functions.
*/
abstract class AbstractController
{
    /**
     * Displays flash messages
     *
     * @return void
     */
    protected function getFlash():void
    {
        if(isset($_SESSION["flash"]))
        {
            echo "<div class='flash'>{$_SESSION['flash']}</div>";
            unset($_SESSION["flash"]);
        }
    }

    /**
     * Stores a flash message.
     *
     * @param string $message
     * @return void
     */
    protected function setFlash(string $message): void
    {
        $_SESSION["flash"] = $message;
    }

    /**
     * Displays the requested view.
     * 
     * Optionally, an associative array can be passed with variables to send to the view.
     *
     * @param string $view Path of the view from the "view" folder
     * @param array $variables Data to send to the view
     * @return void
     */
    protected function render(string $view, array $variables = []):void
    {
        foreach($variables as $name => $value)
        {
            /* 
                Example:
                If we send the following array: ["users"=>$users]
                This will produce a $users variable containing the user list
                $$ is used to create a dynamic variable name.
            */
            $$name = $value;
        }
        // Our function automatically integrates the header and footer around our views.
        require __DIR__."/../../../ressources/template/_header.php";
        require __DIR__."/../../view/$view";
        require __DIR__."/../../../ressources/template/_footer.php";
    }

    /**
     * Checks whether the user has access to the page depending on whether they are logged in
     * 
     * If the boolean is "true", blocks access to unauthenticated users
     * If "false", blocks access to authenticated users
     *
     * @param boolean $bool Must be logged in or not
     * @param string $redirect Redirection path
     * @return void
     */
    protected function shouldBeLogged(bool $bool = true, string $redirect = "/"):void
    {
        shouldBeLogged($bool, $redirect);
    }

    /**
     * Sets a token in session and adds a hidden input containing the token
     * 
     * Optionally adds a lifespan to the token
     *
     * @param integer $time Token lifetime
     * @return void
     */
    protected function setCSRF(int $time = 0): void
    {
        setCSRF($time);
    }

    /**
     * Checks if the CSRF token is valid.
     *
     * @return boolean true if valid.
     */
    protected function isCSRFValid():bool
    {
        return isCSRFValid();
    }
}
