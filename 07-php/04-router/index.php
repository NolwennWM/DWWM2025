<?php 
/*
    現在、どんなURLを入力してもこのファイルにリダイレクトされます。
    そのため、このファイルにURLを処理して対応するファイルを読み込ませます。

    ルート定義ファイルを読み込みます:
*/
require "./routes.php";

// ユーザーが要求したURLを取得:
$url = $_SERVER["REQUEST_URI"];

// URLをクリーンアップして不要な文字を削除
$url = filter_var($url, FILTER_SANITIZE_URL);
/* 
    explodeは文字列を配列に分割します。第1引数は区切り文字です。
    ここでは"?"で分割し、最初の要素"[0]"のみ取得します。
    これはGETパラメータを取り除くためです。
*/
$url = explode("?", $url)[0];

// 第二引数を使うと、trimは先頭と末尾から指定文字を削除できます
$url = trim($url, "/");

// var_dump($url);

// URLが定義されたルートに存在するか確認
if(array_key_exists($url, ROUTES))
{
    $page = ROUTES[$url];
    $path = "pages/$page";
    // var_dump($page, $path);

    // 指定したパスにファイルが存在するか確認
    if(is_file($path))
    {
        require $path;
    }
    else
    {
        // ファイルが存在しない場合、404ページを読み込む
        require "pages/404.php";
    }
}
else
{
    // URLが存在しない場合、404ページを読み込む
    require "pages/404.php";
}

/* 
    ! require/includeに関する注意

    このルーターを使用する場合、全てのファイルはindexからrequireされます。
    したがって、他のファイル内のrequireパスは、自分自身の場所ではなくindexに対して相対的に書く必要があります。

    対処法は2つあります:
        - 全てのrequireをindexに対して相対パスで書く。
        - もしくは、__DIR__ を各requireの前に付けて正しいパスを取得する。

    より高度なルーターはこちら:
        https://phprouter.com/
*/
