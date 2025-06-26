<?php
// ? --------------- NAMESPACE et USE ------------------
require "./10-a-poo.php";
/* 
    Mon fichier est bien require, pourtant, une fatale erreur est déclenché indiquant qu'il ne trouve pas ma classe "Humain"

    Ceci est à cause du "namespace" indiqué en haut du fichier précédent.
*/
// class enfant extends Humain{}
/* 
    Un namespace est un peu un tiroir dans lequel nous avons rangé nos classes.
    En haut du fichier précédent, j'ai noté "namespace Cours\POO;"

    Cela signifie que les classes définies dans ce fichier, sont rangées dans le tiroir "Cours\POO"
    Donc pour y accèder, je dois le préciser :
*/
class enfant extends Cours\POO\Humain{};
/* 
    Rien n'oblige à utiliser un namespace.
    Sur un tout petit projet, ce n'est même pas forcément utile.
    Mais sur de gros projets ayant de nombreuses bibliothèques, 
    Ils vont servir à différencier les différentes classes qui pourraient porter le même nom.

    On peut nommer nos namespaces comme on le souhaite.
    Mais souvent on choisira de reprendre le nom de nos dossiers pour retrouver les classes plus facilement.

    Cela sera aussi utile si on utilise un "autoloader" pour qu'il puisse trouver les classes automatiquement.

    Si on ne souhaite pas réécrire le namespace à chaque fois que l'on appelle la classe dans le fichier, on peut aussi utiliser le mot clef "use" pour indiquer ce chemin qu'une seule fois :
*/
use Cours\POO\Humain;
class enfant2 extends Humain{};
/* 
    Si on veut utiliser deux classes ayant le même nom;
    On peut demander à "use" de renommer l'une d'elles:
*/
use Cours\POO\Humain2 as Hum;
class enfant3 extends Hum{};
// Une dernière possiblité est indiqué dans le troisième partie du cours
?>