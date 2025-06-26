<?php
// ? --------------- NAMESPACE and USE ------------------
require "./10-a-poo.php";
/* 
    My file is properly required, yet a fatal error is thrown
    saying that the class "Humain" cannot be found.

    This is due to the "namespace" declared at the top of the previous file.
*/
// class enfant extends Humain{}
/* 
    A namespace is like a drawer in which we store our classes.
    At the top of the previous file, we wrote "namespace Cours\POO;"

    This means that the classes defined in that file are stored inside the "Cours\POO" drawer.
    So to access them, we must specify that path:
*/
class enfant extends Cours\POO\Humain{};
/* 
    Using a namespace is not mandatory.
    In very small projects, it might not even be useful.

    But in larger projects with many libraries,
    they help distinguish between classes that might share the same name.

    You can name your namespaces however you like.
    But commonly, we use the folder structure to name them, making it easier to locate classes.

    This also helps if you're using an autoloader to automatically locate and load classes.

    If you don't want to rewrite the full namespace every time you call the class,
    you can use the "use" keyword to declare the path once:
*/
use Cours\POO\Humain;
class enfant2 extends Humain{};
/* 
    If you want to use two classes with the same name,
    you can use "as" with "use" to rename one of them:
*/
use Cours\POO\Humain2 as Hum;
class enfant3 extends Hum{};
// A final use case is explained in part three of the course.
?>
