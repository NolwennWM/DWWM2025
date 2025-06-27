<?php
/* 
    このクラスの役割は、他のクラスファイルを自動的に require することです。
*/
class Autoloader
{
    public static function register()
    {
        /* 
            spl_autoload_register は、未定義のクラスが呼び出されたときに
            コールバック関数を自動的に実行してくれます。
        */
        spl_autoload_register(function(string $class)
        {
            /* 
                渡される文字列は、クラスの名前空間を含んでいます。
                この名前空間をディレクトリ名として扱うことで、
                クラスのファイルパスを特定できます。
            */
            $file = str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
            if (file_exists($file))
            {
                require $file;
                return true;
            }
            return false;
        });
    }
}
