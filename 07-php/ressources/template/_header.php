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
    <!-- The link must be made relative to where the file will be included, 
    not where the file is actually located. -->
    <!-- <link rel="stylesheet" href="../style/style.css"> -->
    <!-- <link rel="stylesheet" href="./ressources/style/style.css"> -->
	<!-- The problem with a relative path is that it won’t work if it's included from a file located elsewhere.
    So, we prefer using an absolute path from the root of the server. -->
	<link rel="stylesheet" href="/ressources/style/style.css">
    <script src="/ressources/script/script.js" defer></script>
</head>
<body>
    <header>
        <h1><?php echo $title??"Cours PHP" ?></h1>
        <?php 
            // displays the username if the user is logged in
            if(isset($_SESSION["logged"]) || isset($_SESSION["logged_in"]))
            {
                echo "<h2>{$_SESSION['username']}</h2>";
            }
        ?>
        <?php // include __DIR__ . "/_test.php"; ?>
    </header>
    <!-- We open the body here but don’t close it — it will be closed in the footer. -->
    <main class="<?php echo $mainClass??"" ?>">
        <!-- handling flash messages: -->
        <?php 
            if(isset($_SESSION["flash"]))
            {
                echo "<div class='flash-message'>{$_SESSION['flash']}</div>";
                unset($_SESSION["flash"]);
            }
        ?>