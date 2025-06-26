<?php
require __DIR__."/../../../ressources/service/_shouldBeLogged.php";
shouldBeLogged(true, "/04-router/connexion");
unset($_SESSION);
session_destroy();
setcookie("PHPSESSID","", time()-3600);
header("location: /04-router/connexion");
exit;
?>