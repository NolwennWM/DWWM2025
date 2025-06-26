<?php 
// Ignorer pour l'instant cette ligne, on expliquera cela dans la partie "b"
namespace Cours\POO;

/* 
    Comme en JS, on peut développer notre code en procédural, ou bien en programmation orienté objet.

    Rappel du principe de la POO :
        Créer des classes qui servent de constructeur à des objets pouvant être instanciés et hériter des méthodes d'autres classes.

    On va trouver deux mots clefs important :
        - "class" permet de définir une nouvelle classe.
        - "new" permet d'instancier un nouvel objet.
*/
// Je définie une nouvelle classe (par convention je met une majuscule)
class Chaussette{};
// J'instancie un nouvel objet depuis ma classe
$a = new Chaussette();
var_dump($a);

/* 
    On peut ajouter à nos classes, des propriétés et méthodes, qui peuvent être précédé d'un des mots clefs suivant :
        - public
        - protected
        - private
    Si rien n'est indiqué, cela sera considéré comme "public"
*/
class Fruit
{
    public $famille = "végétal";
    public function talk()
    {
        echo "Je suis un fruit ! <br>";
    }
}
/* 
    Lorsque je veux faire appel à une méthode ou une propriété d'un objet, j'utilise "->"
        $monObjet->maPropriété;
        $monObjet->maMéthode();
*/
$f = new Fruit();
// j'appelle la méthode "talk" de l'objet "Fruit"
$f->talk();
// Lors de l'appel d'une propriété, le "$" de la propriété disprait :
echo $f->famille, "<br>";
// Je change la propriété famille :
$f->famille = "être vivant";

// ?--------------THIS et PRIVATE ----------------

class Humain
{
    // Une propriété "private" est accessible uniquement à l'interieur de la classe.
    private $age;
    // Si on veut y accèder depuis l'exterieur, on utilisera des "setter" et des "getter"
    public function setAge(int $a)
    {
        if($a < 0)
        {
            // $this représente l'objet dans lequel nous nous trouvons.
            // Ici on lui indique que l'on veut la propriété "age" de notre "Humain"
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
// Comme indiqué, une propriété privée n'est pas accessible hors de la classe :
// echo $h->age;

//? --------------- CONSTRUCT et DESTRUCT ------------
/* 
    Les classes sont pourvue de méthode prédéfinie qui se lancent automatiquement à certains moments :
        - "__construct" se lance lorsque l'on instancie un nouvel objet.
        - "__destruct" se lance lorsque l'objet est détruit.
    ! ATTENTION, il y a deux "_" devant leurs nom.
*/
class Humain2
{
    public $nom;
    // Les paramètres données à "construct" sont automatiquement récupéré depuis l'instanciation  
    // new maClass("paramètre")
    function __construct($nom)
    {
        $this->nom = $nom;
        echo $this->nom . " est né(e)!<br>";
    }
    function __destruct()
    {
        echo $this->nom . " est mort(e) ! <br>";
    }
}
// Ici l'argument demandé par "construct" est attendu :
$h2 = new Humain2("Maurice");
// new Humain2("patrick");
// PHP détruit automatiquement toute les variables à la fin de l'execution du script.
echo "Bonjour les gens ! <br>";
// Mais on peut aussi la détruire nous même:
unset($h2);
// Sans le unset, le destruct se lance en dernier, avec, il se  lance au moment de l'unset.
echo "fin explication construct/destruct <br>";

//? ----------- CHAINAGE DES METHODES ---------
// Parfois nous avons besoin de lancer plusieurs méthodes d'un même objet.
$f->talk();
$f->talk();
$f->talk();
/* 
    Mais lorsque nos méthodes n'ont pas de valeur de retour, 
    il est possible de leur demander de retourner l'objet lui même,
    cela afin d'enchaîner nos méthodes plus rapidement :
*/
class Fruit2
{
    public function talk():self
    {
        echo "Je suis un fruit ! <br>";
        return $this;
    }
}
$f2 = new Fruit2();
$f2->talk()->talk()->talk();
/* 
    Ou sur plusieurs lignes pour plus de clareté :
    $f2 ->talk()
        ->talk()
        ->talk();
*/
// ? ------------ CONSTANTE et STATIC ---------------
/* 
    Une classe peut contenir des propriétés constante précédées du mot clef "const"
    et des méthodes statiques précédées du mot clef "static".
    
    Ces propriétés et méthodes ont la particularité d'être appelable sur la classe directement, sans instanciation.

    Pour les appeller, on remplacera "->" par "::"
*/
class Humain3
{
    public const MEMBRES = "2 bras, 2 jambes, un torse et une tête";
    public static function description()
    {
        /* 
            Pour appeler une propriété ou methode constante/static.
            On ne peut pas utiliser "$this" car celui doit représenté un objet instancié.
            On utilisera alors "self" pour représenter la classe et non un objet.
        */
        echo "Un humain a en général ". self::MEMBRES."<br>";
    }
}
echo Humain3::MEMBRES, "<br>";
Humain3::description();
// à la différence de JS, je peux toujours y accèder sur un objet instancié :
$h3 = new Humain3();
$h3::description();

// ? ------------------- HERITAGE ---------------
/* 
    Il est possible de faire hériter des classes à de nouvelles classes.
    Ces classes "enfant" hériterons alors des méthodes et propriétés de son parent.
        - Les méthodes et propriétés marqué "private" ne seront pas héritées.
        - Celles marquées "protected" seront hérité mais toujours innaccessible hors de la classe.
*/
class Humain4
{
    private $age = 28;
    protected $nom = "Maurice";
    private function loisir()
    {
        echo "J'aime le bowling ! <br>";
    }
    protected function talk()
    {
        echo "Bonjour, je me nomme ". $this->nom ."!<br>";
        $this->loisir();
    }
}
// J'utilise le mot clef "extends" pour faire hériter une classe 
class Pompier extends Humain4
{
    public function presentation()
    {
        // Ma classe pompier a bien accès à la méthode "talk" de Humain4
        $this->talk();
        echo "Je suis pompier ! <br>";
    }
}
$p = new Pompier();
$p->presentation();

/* 
    On peut hériter autant de fois que l'on souhaite.
    Jusqu'à trouver une classe ayant le mot clef "final"
*/
final class Apprenti extends Pompier{}
$p2 = new Apprenti();
$p2->presentation();
// Impossible de faire hériter "Apprenti" à une autre classe car "Apprenti est "final"
// class enfant extends Apprenti{};

//? --------------- ABSTRACT ---------------------
/* 
    Les classes abtraites sont des classes qui ne peuvent pas être instanciées.
    Elles servent uniquement en tant qu'héritage.
    Elles peuvent être utiles si plusieurs de vos classes partagent les même fonctionnalités.
*/
abstract class Humanity
{
    protected $nom;
    public function talk()
    {
        echo "Je me nomme {$this->nom} ! <br>";
    }
    /* 
        Les classes abstraite peuvent contenir des méthodes abstraites.
        Ces méthodes servent de plan pour guider la construction de la classe qui héritera.
        La classe enfant devra absolument définir toute les méthodes abstraites hérités.
    */
    abstract public function setName(string $n);
}
// Mon héritage provoque une erreur tant que je n'ai pas définie ma méthode abstraite :
class Policier extends Humanity
{
    public function setName(string $n)
    {
        // Peu importe ce que j'y met, tant qu'elle est définie, cela est valide.
        $this->nom = $n;
        return $this;
    }
}
$po = new Policier();
$po->setName("Charle")->talk();

// ? --------------- INTERFACES et TRAIT --------------
/* 
    Une interface est semblable à une classe abstraite, à la différence qu'elle ne contient que des méthodes non définie et public.

    Elle servira uniquement de plan pour construire une classe.
*/
interface Ordinateur
{
    public function excel();
    public function browser(string $url);
}
/* 
    Un trait ressemble lui aussi à une classe abstraite, 
    sauf que toute les propriétés et méthodes doivent être définie.

    On utilisera généralement, une classe abstraite comme parent de plusieurs classes fonctionnant de la même façon.
    Et un trait pour des classes qui ont des rôles différents, mais qui ont besoin d'outils en commun.
*/
trait Electricity
{
    protected $volt = 230;
    public function description()
    {
        echo "Je me branche sur du {$this->volt} volts.<br>";
    }
}
/* 
    Pour utiliser une interface, on utilisera le mot clef "implements" après le mot clef "extends" si celui ci doit apparaître.

    Pour utiliser un trait, on utilisera à l'interieur de la classe le mot clef "use"
*/
class Asus implements Ordinateur
{
    use Electricity;
    public function excel(){}
    public function browser(string $url){}
}
?>