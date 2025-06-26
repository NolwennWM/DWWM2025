<?php 
// 最後の方法として、同じ名前空間内で作業することもできます:
namespace Cours\POO;

require "./10-a-poo.php";
/* 
    名前空間が同じなので、「Humain」はこの名前空間内から直接探されます。
*/
class enfant4 extends Humain{};
/* 
    ！注意
    名前空間が宣言されると、それ以降、PHP はクラス名が明示的でない限り、
    すべてその名前空間内で探そうとします。
*/
// new Exception();
// このエラーを避けるには、PHPのデフォルトクラスには必ず「\」をつけます
new \Exception();
?>
