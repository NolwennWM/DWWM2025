<?php
// 空の文字列として複数の変数を宣言する。
$username = $food = $drink = "";
// エラーを保存するための変数を宣言する。
$error = [];
// フォームで提供される選択肢のリスト：
$foodList = ["welsh", "cannelloni", "oyakodon"];
$drinkList = ["jus de tomate", "milkshake", "limonade"];
// フォームが期待されるメソッドで送信され、かつ少なくとも1つの要素が送信されたかを確認する：
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["meal"]))
{
    // echo "フォームが送信されました！";
    // $_GETの中の名前はフォームのフィールドのname属性に対応する。
    if(empty($_GET["username"]))
    {
        // emptyは引数が空ならtrueを返す。
        $error["username"] = "ユーザー名を入力してください";
    }
    else
    {
        // 文字列の先頭と末尾の空白を削除する
        $username = trim($_GET["username"]);
        // バックスラッシュを削除する
        $username = stripslashes($username);
        // 表示するすべてのデータに対して必ず行う必要がある
        // データベースに保存する前、または表示の直前に実行可能
        $username = htmlspecialchars($username);
        // HTMLの特殊文字（<、>など）をそのコード（&gt;など）に置き換えてコードインジェクションを防止する。
        if(strlen($username) < 3 || strlen($username)>25)
        {
            $error["username"] = "ユーザー名の長さが適切ではありません";
        }
    } // ユーザー名の確認終了
    if(empty($_GET["food"]))
    {
        $error["food"] = "食事を選択してください";
    }
    else
    {
        $food = $_GET["food"];
        if(!in_array($food, $foodList))
        {
<<<<<<< HEAD
            $error["food"] = "この食事は存在しません";
        }
    } // 食事の確認終了
    if(empty($_GET["drink"]))
    {
        $error["drink"] = "飲み物を選択してください";
=======
            $error["food"] = "Ce repas n'existe pas";
        }
    }//fin vérification food
    if(empty($_GET["drink"]))
    {
        $error["drink"] = "Veuillez selectionner une boisson";
>>>>>>> main
    }
    else
    {
        $drink = $_GET["drink"];
        if(!in_array($drink, $drinkList))
        {
<<<<<<< HEAD
            $error["drink"] = "この飲み物は存在しません";
        }
    } // 飲み物の確認終了
    // エラーがなければ
    if(empty($error))
    {
        /* 
            ここでデータベースにデータを送信することができる
        */
    }
} // フォーム確認終了
=======
            $error["drink"] = "Cette boisson n'existe pas";
        }
    }//fin vérification drink
    // Si je n'ai aucune erreur
    if(empty($error))
    {
        /* 
            C'est Ici que l'on pourrait envoyer nos données en BDD
        */
    }
}// fin vérification formulaire
>>>>>>> main

$title = " GET ";
require("../ressources/template/_header.php");
?>

<form action="01-get.php" method="GET">
    <input type="text" placeholder="Entrez un nom" name="username">
<<<<<<< HEAD
    <!-- span.errorはエラーメッセージを表示するために使用される。 -->
    <span class="error"><?= $error["username"]??"" ?></span>
    <br>
    <fieldset>
        <legend>好きな食べ物</legend>
        <input type="radio" name="food" id="welsh" value="welsh"> 
        <label for="welsh">Welsh（チーズ最高）</label>
        <br>
        <input type="radio" name="food" id="cannelloni" value="cannelloni"> 
        <label for="cannelloni">Cannelloni（ラビオリは飽きた）</label>
        <br>
        <input type="radio" name="food" id="oyakodon" value="oyakodon"> 
        <label for="oyakodon">Oyakodon（ブラックユーモアが好き）</label>
        <span class="error"><?= $error["food"]??"" ?></span>
    </fieldset>
    <label for="boisson">好きな飲み物</label>
    <br>
    <select name="drink" id="boisson">
        <option value="jus de tomate">トマトジュース（私は吸血鬼）</option>
        <option value="milkshake">ミルクセーキ（フルーツ味が好き）</option>
        <option value="limonade">レモネード（糖分が必要）</option>
=======
    <!-- les span.error serviront à afficher les messages d'erreur. -->
    <span class="error"><?= $error["username"]??"" ?></span>
    <!-- <span class="error"><?php echo $error["username"]??"" ?></span> -->
    <br>
    <fieldset>
        <legend>Nourriture favorite</legend>
        <input type="radio" name="food" id="welsh" value="welsh"> 
        <label for="welsh">Welsh (car vive le fromage)</label>
        <br>
        <input type="radio" name="food" id="cannelloni" value="cannelloni"> 
        <label for="cannelloni">Cannelloni (car les ravioli c'est surfait)</label>
        <br>
        <input type="radio" name="food" id="oyakodon" value="oyakodon"> 
        <label for="oyakodon">Oyakodon (car j'aime l'humour noir)</label>
        <span class="error"><?= $error["food"]??"" ?></span>
    </fieldset>
    <label for="boisson">Boisson favorite</label>
    <br>
    <select name="drink" id="boisson">
        <option value="jus de tomate">jus de tomate (je suis un vampire)</option>
        <option value="milkshake">Milkshake (aux fruits de préférence)</option>
        <option value="limonade">Limonade (J'ai besoin de sucre)</option>
>>>>>>> main
    </select>
    <span class="error"><?= $error["drink"]??"" ?></span>
    <br>

<<<<<<< HEAD
    <input type="submit" value="送信" name="meal">
=======
    <input type="submit" value="Envoyer" name="meal">
>>>>>>> main
</form>

<?php 
require("../ressources/template/_footer.php");
<<<<<<< HEAD
?>
=======
?>
>>>>>>> main
