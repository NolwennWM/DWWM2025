<?php 
// この行は今は無視してください。パート「b」で説明します。
namespace Cours\POO;

/* 
    JSと同様に、コードは手続き型でもオブジェクト指向プログラミング（OOP）でも記述できます。

    OOPの基本原則の復習：
        オブジェクトのコンストラクターとなるクラスを作成し、他のクラスのメソッドを継承できるようにする。

    重要なキーワードは2つ：
        - "class" は新しいクラスを定義します。
        - "new" は新しいオブジェクトをインスタンス化します。
*/
// 新しいクラスを定義します（慣例として、先頭は大文字にします）
class Chaussette{};
// クラスから新しいオブジェクトをインスタンス化します
$a = new Chaussette();
var_dump($a);

/* 
    クラスには、プロパティやメソッドを追加できます。
    それらには次のキーワードを付けることができます：
        - public（どこからでもアクセス可能）
        - protected（クラスとその子クラス内のみアクセス可能）
        - private（定義されたクラス内でのみアクセス可能）
    指定がなければ、デフォルトは "public" です。
*/
class Fruit
{
    public $famille = "植物";
    public function talk()
    {
        echo "私はフルーツです！<br>";
    }
}
/* 
    オブジェクトのプロパティやメソッドにアクセスするには "->" を使います：
        $myObject->myProperty;
        $myObject->myMethod();
*/
$f = new Fruit();
// "Fruit" オブジェクトの "talk" メソッドを呼び出します
$f->talk();
// プロパティにアクセスする際、"$" は消えます：
echo $f->famille, "<br>";
// "famille" プロパティを変更します：
$f->famille = "生き物";

// ?--------------THIS と PRIVATE ----------------

class Humain
{
    // "private" プロパティはクラス内でしかアクセスできません。
    private $age;
    // 外部からアクセスするには、setter/getterを使用します。
    public function setAge(int $a)
    {
        if($a < 0)
        {
            // $this は現在のオブジェクトを指します。
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
// private プロパティには外部からアクセスできません：
// echo $h->age;

//? --------------- CONSTRUCT と DESTRUCT ------------
/* 
    クラスには特別なメソッドがあります：
        - "__construct" はオブジェクト生成時に実行されます。
        - "__destruct" はオブジェクト破棄時に実行されます。
    ※ どちらも名前の前に「__」が付きます。
*/
class Humain2
{
    public $nom;
    // コンストラクタの引数はインスタンス化時に渡されます。
    function __construct($nom)
    {
        $this->nom = $nom;
        echo $this->nom . " が誕生しました！<br>";
    }
    function __destruct()
    {
        echo $this->nom . " は亡くなりました！<br>";
    }
}
// "construct" に必要な引数を渡します：
$h2 = new Humain2("モーリス");
// new Humain2("パトリック");
// PHPはスクリプト終了時に自動で変数を破棄します。
echo "こんにちは、皆さん！<br>";
// 明示的に破棄することもできます：
unset($h2);
// unsetを使うとその場で destruct が呼ばれます。
echo "construct/destruct の説明終了<br>";

//? ----------- メソッドチェーン ---------
$f->talk();
$f->talk();
$f->talk();
/* 
    メソッドに戻り値がない場合でも、
    自分自身（$this）を返すことで、
    メソッドを連続で呼び出すことができます。
*/
class Fruit2
{
    public function talk():self
    {
        echo "私はフルーツです！<br>";
        return $this;
    }
}
$f2 = new Fruit2();
$f2->talk()->talk()->talk();
/* 
    複数行に分けて書くことも可能です：
    $f2 ->talk()
        ->talk()
        ->talk();
*/
// ? ------------ 定数と STATIC ---------------
/* 
    クラスには次のような特殊なプロパティやメソッドがあります：
        - "const" 定数（インスタンス化不要）
        - "static" 静的メソッド（同上）

    これらはクラス名で直接呼び出せます。
    呼び出しには "->" の代わりに "::" を使用します。
*/
class Humain3
{
    public const MEMBRES = "腕2本、脚2本、胴体と頭";
    public static function description()
    {
        /* 
            static や const を使う場合、
            $this は使えません（インスタンスがないため）。
            代わりに self を使います。
        */
        echo "人間は通常 ". self::MEMBRES ."<br>";
    }
}
echo Humain3::MEMBRES, "<br>";
Humain3::description();
// JSと違って、インスタンスからでもアクセス可能です：
$h3 = new Humain3();
$h3::description();

// ? ------------------- 継承 -----------------
/* 
    クラスは他のクラスを継承できます。
    子クラスは親のメソッドやプロパティを受け継ぎます。
        - private は継承されません。
        - protected は継承されますが外部からは使えません。
*/
class Humain4
{
    private $age = 28;
    protected $nom = "モーリス";
    private function loisir()
    {
        echo "ボウリングが好きです！<br>";
    }
    protected function talk()
    {
        echo "こんにちは、私は ". $this->nom ." です！<br>";
        $this->loisir();
    }
}
// "extends" で継承します。
class Pompier extends Humain4
{
    public function presentation()
    {
        $this->talk();
        echo "私は消防士です！<br>";
    }
}
$p = new Pompier();
$p->presentation();

/* 
    複数回継承することができます。
    ただし、"final" クラスを継承することはできません。
*/
final class Apprenti extends Pompier{}
$p2 = new Apprenti();
$p2->presentation();
// final クラスは継承できません
// class Enfant extends Apprenti{};

//? --------------- 抽象クラス ---------------------
/* 
    抽象クラスはインスタンス化できません。
    継承専用です。
    複数のクラスで共通のロジックを持たせたい場合に使います。
*/
abstract class Humanity
{
    protected $nom;
    public function talk()
    {
        echo "私の名前は {$this->nom} です！<br>";
    }
    /* 
        抽象メソッドは定義されずに宣言のみ行います。
        子クラスは必ずこのメソッドを定義する必要があります。
    */
    abstract public function setName(string $n);
}
// 抽象メソッドを定義しないとエラーになります：
class Policier extends Humanity
{
    public function setName(string $n)
    {
        $this->nom = $n;
        return $this;
    }
}
$po = new Policier();
$po->setName("シャルル")->talk();

// ? --------------- インターフェース と トレイト --------------
/* 
    インターフェースは抽象クラスに似ていますが、
    すべてのメソッドは public かつ未定義でなければなりません。

    クラスの設計図として使用します。
*/
interface Ordinateur
{
    public function excel();
    public function browser(string $url);
}
/* 
    トレイトも抽象クラスに似ていますが、
    すべてのプロパティやメソッドは定義済みでなければなりません。

    抽象クラスは親子関係に使い、
    トレイトは異なる機能に共通機能を追加するのに使います。
*/
trait Electricity
{
    protected $volt = 230;
    public function description()
    {
        echo "{$this->volt} ボルトで動作します。<br>";
    }
}
/* 
    インターフェースは "implements"、
    トレイトはクラス内で "use" を使って組み込みます。
*/
class Asus implements Ordinateur
{
    use Electricity;
    public function excel(){}
    public function browser(string $url){}
}
?>
