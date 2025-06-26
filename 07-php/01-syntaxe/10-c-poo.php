<?php 
// One last possibility is to work within the same namespace:
namespace Cours\POO;

require "./10-a-poo.php";
/* 
    Since the namespace is the same, it will look for "Humain" directly within it.
*/
class enfant4 extends Humain{};
/* 
    ! WARNING
    From the moment a namespace is declared, PHP will try to resolve all class names 
    (unless fully qualified) within that namespace.
*/
// new Exception();
// To avoid this issue, always prefix PHP's built-in/default classes with a backslash "\"
new \Exception();
?>
