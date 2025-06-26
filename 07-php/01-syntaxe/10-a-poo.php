<?php 
// Ignore this line for now, it will be explained in part "b"
namespace Cours\POO;

/* 
    Like in JS, we can write our code procedurally or use object-oriented programming (OOP).

    Reminder of OOP principles:
        Create classes that act as constructors for objects that can be instantiated and inherit methods from other classes.

    Two important keywords:
        - "class" defines a new class.
        - "new" instantiates a new object.
*/
// I define a new class (by convention, I use a capital letter)
class Chaussette{};
// I instantiate a new object from my class
$a = new Chaussette();
var_dump($a);

/* 
    We can add properties and methods to our classes, and they can be preceded by:
        - public
        - protected
        - private
    If nothing is indicated, it is considered "public"
*/
class Fruit
{
    public $famille = "plant";
    public function talk()
    {
        echo "I am a fruit! <br>";
    }
}
/* 
    To call a method or property of an object, use "->"
        $myObject->myProperty;
        $myObject->myMethod();
*/
$f = new Fruit();
// I call the "talk" method of the "Fruit" object
$f->talk();
// When calling a property, the "$" is dropped:
echo $f->famille, "<br>";
// I change the "famille" property:
$f->famille = "living being";

// ?--------------THIS and PRIVATE ----------------

class Humain
{
    // A "private" property is only accessible inside the class.
    private $age;
    // To access it from outside, use "setters" and "getters"
    public function setAge(int $a)
    {
        if($a < 0)
        {
            // $this represents the current object.
            // Here we assign the "age" property of our "Humain"
            $this->age = 0;
            return;
        }
        $this->age = (int)$a;
    }
    public function getAge()
    {
        return $this->age;
    }
}
$h = new Humain();
$h->setAge(-24);
echo $h->getAge(), "<br>";
// As said, a private property is not accessible outside the class:
// echo $h->age;

//? --------------- CONSTRUCT and DESTRUCT ------------
/* 
    Classes have built-in methods triggered automatically:
        - "__construct" is called when a new object is instantiated.
        - "__destruct" is called when the object is destroyed.
    ! NOTE: there are two underscores before their names.
*/
class Humain2
{
    public $nom;
    // The parameters given to "construct" are automatically received when instantiating  
    // new myClass("parameter")
    function __construct($nom)
    {
        $this->nom = $nom;
        echo $this->nom . " was born!<br>";
    }
    function __destruct()
    {
        echo $this->nom . " has died! <br>";
    }
}
// Here the argument required by "construct" is expected:
$h2 = new Humain2("Maurice");
// new Humain2("patrick");
// PHP automatically destroys all variables at the end of the script.
echo "Hello everyone! <br>";
// But we can destroy it manually too:
unset($h2);
// Without unset, destruct runs last; with it, it runs at the moment of unset.
echo "end of construct/destruct explanation <br>";

//? ----------- METHOD CHAINING ---------
// Sometimes we need to call several methods on the same object.
$f->talk();
$f->talk();
$f->talk();
/* 
    But when methods return no value,
    they can return the object itself
    to allow method chaining:
*/
class Fruit2
{
    public function talk():self
    {
        echo "I am a fruit! <br>";
        return $this;
    }
}
$f2 = new Fruit2();
$f2->talk()->talk()->talk();
/* 
    Or across multiple lines for clarity:
    $f2 ->talk()
        ->talk()
        ->talk();
*/
// ? ------------ CONSTANTS and STATIC ---------------
/* 
    A class can have constant properties (with "const")
    and static methods (with "static").
    
    These can be called directly on the class, without instantiating it.

    To call them, use "::" instead of "->"
*/
class Humain3
{
    public const MEMBRES = "2 arms, 2 legs, a torso and a head";
    public static function description()
    {
        /* 
            To call a constant/static property or method,
            "$this" can't be used, as it represents an object instance.
            Use "self" to refer to the class.
        */
        echo "A human generally has ". self::MEMBRES."<br>";
    }
}
echo Humain3::MEMBRES, "<br>";
Humain3::description();
// Unlike JS, I can still access it from an object instance:
$h3 = new Humain3();
$h3::description();

// ? ------------------- INHERITANCE ---------------
/* 
    Classes can inherit from other classes.
    The "child" class inherits the methods and properties of its parent.
        - "private" ones are not inherited.
        - "protected" ones are inherited but remain inaccessible outside the class.
*/
class Humain4
{
    private $age = 28;
    protected $nom = "Maurice";
    private function loisir()
    {
        echo "I love bowling! <br>";
    }
    protected function talk()
    {
        echo "Hello, my name is ". $this->nom ."!<br>";
        $this->loisir();
    }
}
// Use "extends" to make a class inherit from another
class Pompier extends Humain4
{
    public function presentation()
    {
        // My "Pompier" class has access to the "talk" method of Humain4
        $this->talk();
        echo "I am a firefighter! <br>";
    }
}
$p = new Pompier();
$p->presentation();

/* 
    Inheritance can be done multiple times,
    until a class marked "final" is encountered.
*/
final class Apprenti extends Pompier{}
$p2 = new Apprenti();
$p2->presentation();
// Can't extend "Apprenti" because it's "final"
// class Enfant extends Apprenti{};

//? --------------- ABSTRACT ---------------------
/* 
    Abstract classes cannot be instantiated.
    They are used only for inheritance.
    Useful when several classes share the same logic.
*/
abstract class Humanity
{
    protected $nom;
    public function talk()
    {
        echo "My name is {$this->nom}! <br>";
    }
    /* 
        Abstract classes can contain abstract methods.
        These act as blueprints for child classes.
        Child classes must implement all abstract methods.
    */
    abstract public function setName(string $n);
}
// Inheritance causes an error if abstract methods aren't defined:
class Policier extends Humanity
{
    public function setName(string $n)
    {
        // Any implementation is acceptable as long as it's defined.
        $this->nom = $n;
        return $this;
    }
}
$po = new Policier();
$po->setName("Charle")->talk();

// ? --------------- INTERFACES and TRAITS --------------
/* 
    An interface is like an abstract class but contains only public and undefined methods.

    It's used solely as a blueprint.
*/
interface Ordinateur
{
    public function excel();
    public function browser(string $url);
}
/* 
    A trait is similar to an abstract class, 
    but all methods and properties must be defined.

    Abstract classes are usually for parent-child logic.
    Traits are for shared utilities across unrelated classes.
*/
trait Electricity
{
    protected $volt = 230;
    public function description()
    {
        echo "I use {$this->volt} volts.<br>";
    }
}
/* 
    Use "implements" to use an interface,
    and use the "use" keyword inside the class for traits.
*/
class Asus implements Ordinateur
{
    use Electricity;
    public function excel(){}
    public function browser(string $url){}
}
?>
