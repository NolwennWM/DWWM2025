<?php 
// Une dernière possibilité, est de travailler dans un même namespace :
namespace Cours\POO;

require "./10-a-poo.php";
/* 
    Le namespace étant le même, il ira chercher "Humain" directement dans celui ci.
*/
class enfant4 extends Humain{};
/* 
    ! ATTENTION
    à partir du moment où un namespace est indiqué, PHP ira chercher toute les classes dont on a pas d'autre précision, dans ce namespace:
*/
// new Exception();
// Pour éviter cette erreur, on fera précéder les classes par défaut de PHP d'un "\"
new \Exception();
?>