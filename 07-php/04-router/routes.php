<?php 
/* 
    On défini une constante ROUTES qui est un tableau dont les clefs sont les routes de mon site.
    et les valeurs, les fichiers à charger.
*/
const ROUTES = [
    "04-router"=>"02-read.php",
    "04-router/inscription"=>"01-create.php",
    "04-router/profil"=>"03-update.php",
    "04-router/profil/supprimer"=>"04-delete.php",
    // Exercices :
    "04-router/connexion"=>"exercice/connexion.php",
    "04-router/deconnexion"=>"exercice/deconnexion.php",
    "04-router/blog"=>"exercice/blog/read.php",
    "04-router/blog/nouveau"=>"exercice/blog/create.php",
    "04-router/blog/modifier"=>"exercice/blog/update.php",
    "04-router/blog/supprimer"=>"exercice/blog/delete.php",
];