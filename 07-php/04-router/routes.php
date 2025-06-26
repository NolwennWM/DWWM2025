<?php 
/* 
    We define a constant ROUTES, which is an array where the keys are the routes of the site,
    and the values are the files to load.
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
