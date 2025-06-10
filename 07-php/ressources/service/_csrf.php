<?php 
if(session_status() === PHP_SESSION_NONE)
session_start();
/**
 * セッションにトークンを設定し、hidden inputとして出力します。
 * 
 * オプションでトークンの有効期限を設定可能。
 *
 * @param integer $time
 * @return void
 */
function setCSRF(int $time = 0): void
{
    // $timeが0より大きければ、期限時間をセッションに保存
    if($time>0)
        $_SESSION["tokenExpire"] = time() + 60*$time; 
    /* 
        random_bytesは指定したバイト数のランダムバイト列を返します。
        bin2hexでそれを16進数の文字列に変換します。
        セッションに保存します。
    */
    $_SESSION["token"] = bin2hex(random_bytes(50));
    // hidden inputとしてトークンをフォームに埋め込みます
    echo '<input type="hidden" name="token" value="'.$_SESSION["token"].'">';
}
/**
 * トークンが有効かどうかをチェックします。
 *
 * @return boolean
 */
function isCSRFValid(): bool
{
    // 有効期限が無いか、まだ期限内なら
    if(!isset($_SESSION["tokenExpire"]) || $_SESSION["tokenExpire"] > time()){
        // セッションとPOSTにトークンがあり、一致していればtrue
        if( isset($_SESSION['token'],$_POST['token']) && $_SESSION['token'] == $_POST['token'])
        return true;
    }
    // そうでなければ405エラーを返しfalse
    if(isset($_SERVER['SERVER_PROTOCOL']))
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    return false;
}
/* 
    このファイルはすべてのフォームでインクルードされる想定で、
    ユーザー入力のクリーニング関数も用意しています。
*/
/**
 * 文字列のサニタイズ
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

