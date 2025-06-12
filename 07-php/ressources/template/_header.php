<?php $test = "Coucou"; 
if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours PHP - <?php echo $title??""; ?></title>
    <!-- リンクはファイルの実際の場所ではなく、
    そのファイルがどこでインクルードされるかに基づいて指定する必要があります。-->
    <!-- <link rel="stylesheet" href="../style/style.css"> -->
    <!-- <link rel="stylesheet" href="./ressources/style/style.css"> -->
	<!--相対パスの問題点は、他の場所からインクルードされた場合に動作しなくなることです。
        そのため、サーバーのルートからの絶対パスを使うのが望ましいです。-->
	<link rel="stylesheet" href="/ressources/style/style.css">
    <script src="/ressources/script/script.js" defer></script>
</head>
<body>
    <header>
        <h1><?php echo $title??"Cours PHP" ?></h1>
        <?php 
            // ユーザーがログインしていれば、ユーザー名を表示する
            if(isset($_SESSION["logged"]) || isset($_SESSION["logged_in"]))
            {
                echo "<h2>{$_SESSION['username']}</h2>";
            }
        ?>
        <?php // include __DIR__ . "/_test.php"; ?>
    </header>
    <!-- bodyタグはここで開いていますが、閉じるのはfooter内です -->
    <main class="<?php echo $mainClass??"" ?>">
        <!-- フラッシュメッセージの処理： -->
        <?php 
            if(isset($_SESSION["flash"]))
            {
                echo "<div class='flash-message'>{$_SESSION['flash']}</div>";
                unset($_SESSION["flash"]);
            }
        ?>