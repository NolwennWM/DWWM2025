<?php
// 空の文字列として複数の変数を宣言する。
$username = $food = $drink = "";
// エラーを保存するための変数を宣言する。
$error = [];
// フォームで提供される選択肢のリスト：
// $foodList = ["welsh", "cannelloni", "oyakodon"];
$foodList = [
    "welsh"=>"Welsh（チーズ最高）", 
    "cannelloni"=>"Cannelloni（ラビオリは飽きた）", 
    "oyakodon"=>"Oyakodon（ブラックユーモアが好き）",
    "pizza"=>"ピザ（できればパイナップル）"
];
$drinkList = [
    "jus de tomate"=>"トマトジュース（私は吸血鬼）", 
    "milkshake"=>"ミルクセーキ（フルーツ味が好き）", 
    "limonade"=>"レモネード（糖分が必要）"
];
// フォームがPOSTメソッドで送信され、かつ少なくとも1つの要素が送信されたかを確認する：
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["meal"]))
{
    // echo "フォームが送信されました！";
    // $_POSTの中の名前はフォームのフィールドのname属性に対応する。
    if(empty($_POST["username"]))
    {
        // emptyは引数が空ならtrueを返す。
        $error["username"] = "ユーザー名を入力してください";
    }
    else
    {
        // 文字列の先頭と末尾の空白を削除する
        $username = trim($_POST["username"]);
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
    if(empty($_POST["food"]))
    {
        $error["food"] = "食事を選択してください";
    }
    else
    {
        $food = $_POST["food"];
        if(!array_key_exists($food, $foodList))
        {
            $error["food"] = "この食事は存在しません";
        }
    } // 食事の確認終了
    if(empty($_POST["drink"]))
    {
        $error["drink"] = "飲み物を選択してください";
    }
    else
    {
        $drink = $_POST["drink"];
        if(!array_key_exists($drink, $drinkList))
        {
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

$title = " POST ";
require("../ressources/template/_header.php");
?>

<form action="02-post.php" method="POST">
    <input 
        type="text" 
        placeholder="Enter a name" 
        name="username" 
        value="<?= $username ?>" 
        class="<?= empty($error["username"])?"":"formError" ?>"
        >
    <!-- span.errorはエラーメッセージを表示するために使用される。 -->
    <span class="error"><?= $error["username"]??"" ?></span>
    <br>
    <fieldset>
        <legend>好きな食べ物</legend>
        <!-- foodList配列の各要素にループする -->
        <?php foreach($foodList as $key => $value): ?>
            <!-- 配列のキーをidとvalueに設定する -->
            <input 
                type="radio" 
                name="food" 
                id="<?= $key ?>" 
                value="<?= $key ?>"
                <?= $food === $key?"checked":"" ?>
                > 
                <!-- 変数$foodがいずれかのinputと一致する場合、"checked"属性を追加する -->
                <!-- for属性に配列のキー、テキストに配列の値を設定 -->
            <label for="<?= $key ?>"><?= $value ?></label>
            <br>
        <?php endforeach; ?>
        <span class="error"><?= $error["food"]??"" ?></span>
    </fieldset>
    <label for="boisson">好きな飲み物</label>
    <br>
    <select name="drink" id="boisson">
        <?php foreach($drinkList as $key => $value){ ?>
            <!-- 変数$drinkが選択肢と一致する場合、"selected"属性を追加 -->
            <option value="<?= $key ?>" <?= $drink === $key?"selected":"" ?>>
                <?= $value ?>
            </option>
        <?php } ?>
    </select>
    <span class="error"><?= $error["drink"]??"" ?></span>
    <br>

    <input type="submit" value="送信" name="meal">
</form>

<?php 
require("../ressources/template/_footer.php");
?>

