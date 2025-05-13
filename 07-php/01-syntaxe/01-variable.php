<h1>Introduction</h1>
<hr>
<!-- 
Le code php se place entre ces balises : 
    <?php ?>
Tout code hors de ces balises, est du simple HTML.
Il est commun de voir du PHP au milieu de HTML.
Mais selon la structure choisi, on pourra séparer la majorité du PHP de HTML.
(Par exemple, structure MVC)
-->
<?php 
// Commentaire sur une seule ligne
# autre commentaire sur une seule ligne
/* 
    Commentaire
    sur plusieurs lignes
*/
// ! Chaque instruction PHP, se termine par ";"
// par défaut, le code php n'est pas visible sur la page, pour l'afficher, on devra utiliser une des instructions suivante :

echo "Coucou";
// Si la plupart des fonctions PHP ont besoin de parenthèse, certaines comme "echo" n'en ont pas besoin
# echo peut prendre plusieurs paramètre :
echo "Hello", "World";
# Une fois affiché, les données sont traité comme du HTML:
echo "<br> PHP !!! <hr>";
/* 
    On a d'autre variantes pour afficher des données
    par exemple "print" qui retourne une valeur de 1 et est un peu plus lent à l'execution.
*/
print "<br> test avec print <br> ";
/* 
    Il en existe plein d'autre mais le second plus utilisé sera 
        var_dump()
    Il affichera tout type de donnée, en indiquant son type au préalable, il est très utilisé pour le debug
*/
var_dump("Bonjour", "le monde");
// Permet de voir toute la configuration de php :
// phpinfo();
# Il est possible de récupérer des variables d'environnement avec getenv()
echo getenv("DB_HOST");

#------------------------------------
echo "<h1>Déclaration des variables</h1><hr>";
// Les variables PHP commencent toujours par un "$"
// Ensuite on peut la nommer comme on le souhaite, mais elle ne doit pas commencer par un chiffre
$banane;
// echo $banane;
// Lors d'un warning, le message d'erreur s'affiche, mais le code continue
echo "<br><strong>après warning</strong>";
// throw new ErrorException("test");
// Lors d'un fatal error, le code s'arrête
echo "<br><strong>après fatal Error</strong>";
?>