<?php 
if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}

// ユーザーがログインしていない場合
if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true)
{
    // 別のページにリダイレクトします
    header("Location: ./04-connexion.php");
    exit;
}

/* 
    ユーザーをログアウトさせるには、
    セッションからログイン関連の情報を削除します。
        unset($_SESSION["logged"]);
        unset($_SESSION["username"]);
        unset($_SESSION["expire"]);
    または、セッションに他の情報がない場合は
    セッション全体を破棄しても良いです。
*/
unset($_SESSION);
session_destroy();
setcookie("PHPSESSID", "", time()-3600);

// ログアウト後は別のページにリダイレクトします
header("Location: ./04-connexion.php");
exit;
?>
