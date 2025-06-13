<?php 
// We check that the user is properly logged in.
require "../ressources/service/_shouldBeLogged.php";
shouldBeLogged(true, "./exercice/login.php");

// We connect to the database.
require "../ressources/service/_pdo.php";
$db = connexionPDO();

// We delete the user:
$sql = $db->prepare("DELETE FROM users WHERE idUser = ?");
$sql->execute([$_SESSION["user_id"]]);

// The user is deleted, but still logged in — we need to log them out:
session_destroy();
unset($_SESSION);
setcookie("PHPSESSID", "", time()-3600);

// We wait 5 seconds before redirecting, so the user can see the confirmation message:
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