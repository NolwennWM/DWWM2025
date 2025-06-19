<?php 

require "./routes.php";

$url = $_SERVER["REQUEST_URI"];

$url = filter_var($url, FILTER_SANITIZE_URL);

$url = explode("?", $url)[0];

$url = trim($url, "/");

if(array_key_exists($url, ROUTES))
{
    // ファイル名は "controller" というキーに格納されていることを指定します
    $page = ROUTES[$url]["controller"];
    // 読み込むファイルのパスは "controller" フォルダにあるとします
    $path = "./controller/$page";
    // 呼び出す関数は "fonction" というキーに格納されています
    $fonction = ROUTES[$url]["fonction"];

    if(is_file($path))
    {
        // コントローラーを読み込みます
        require $path;
        // 対応する関数を呼び出します：
        $fonction();
    }
    else
    {
        // 404ページのパスを変更します
        require "./view/404.php";
    }
}
else
{
    // 404ページのパスを変更します
    require "./view/404.php";
}
