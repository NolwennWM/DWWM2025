<?php
require("../../ressources/service/_shouldBeLogged.php");
shouldBeLogged(true, "./login.php");
unset($_SESSION);
session_destroy();
setcookie("PHPSESSID","", time()-3600);
header("location: ./login.php");
exit;
?>