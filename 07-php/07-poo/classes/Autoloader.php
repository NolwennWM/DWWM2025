<?php
/* 
    The purpose of this class is to automatically require other classes.
*/
class Autoloader
{
    public static function register()
    {
        /* 
            spl_autoload_register will allow the callback function to be called each time a new class is used.
        */
        spl_autoload_register(function(string $class)
        {
            /* 
                The provided string will contain the namespace.
                We will treat this namespace as if it were folder names:
            */
            $file = str_replace("\\",DIRECTORY_SEPARATOR,$class) .".php";
            if(file_exists($file))
            {
                require $file;
                return true;
            }
            return false;
        });
    }
}
