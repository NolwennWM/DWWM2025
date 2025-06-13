<?php 
// ユーザーがログインしているかどうかを確認する
require "../ressources/service/_shouldBeLogged.php";
shouldBeLogged(true, "./exercice/login.php");

// データベースに接続する
require "../ressources/service/_pdo.php";
$db = connexionPDO();

// ユーザーを削除する
$sql = $db->prepare("DELETE FROM users WHERE idUser = ?");
$sql->execute([$_SESSION["user_id"]]);

// ユーザーは削除されたが、まだログイン状態なのでログアウトさせる
session_destroy();
unset($_SESSION);
setcookie("PHPSESSID", "", time()-3600);

// 確認メッセージを表示するために5秒待ってからリダイレクトする
header("refresh: 5;url=/");

$title = "CRUD - Suppression Utilisateur";
require "../ressources/template/_header.php";
?>
<p>
    Vous avez bien supprimé votre compte. <br>
    Vous allez être redirigé d'ici peu.
</p>
<?php 
require "../ressources/template/_footer.php";
?>