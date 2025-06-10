<?php 
/* 
    PHPには、データベースに接続するためのツールがいくつかあります。
    例としては、「mysqli」や「pdo」などがあります。
    ここでは、「pdo」（PHPデータオブジェクト）について説明します。

    PDOに接続するには、DSN（データソース名）が必要です。
    これは、データベースを見つけるために必要なすべての情報を含む文字列です。
    {driver}:host={アドレス};port={接続ポート};dbname={データベース名};charset={使用する文字セット}
*/
$dsn = "mysql:host=bddsql;port=3306;dbname=biere;charset=utf8mb4";
/* 
    新しいPDOインスタンスを作成する際、以下のパラメータを受け取ります。
        1. DSN
        2. データベースに接続するためのユーザー名
        3. データベースのパスワード
        4. PDO設定を含む配列
*/
$pdo = new PDO($dsn, "root", "root", [
    // PDO が表示するエラーの種類:    
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // データベースから取得したデータをどのように表示するか
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // PDO に準備されたステートメントをエミュレートしないように指示します (下記参照)
    // PDO::ATTR_EMULATE_PREPARES => false
]);

// データベースにリクエストを送信する:
$sqlCouleur = $pdo->query("SELECT * FROM couleur");
// var_dump($sql);

// データを取得する :
$couleurs = $sqlCouleur->fetchAll();
// var_dump($couleurs);
// 最初の結果だけを取得したい場合は、「fetch」を使用します。
$sqlType = $pdo->query("SELECT * FROM type");
$type = $sqlType->fetch();

/* 
    クエリがユーザー入力を必要としない場合は、「query」で十分です。
    しかし、クエリにユーザー入力が含まれる場合は、絶対にqueryを使用しないでください。SQLインジェクションのリスクがあります。

    準備済みステートメントを使用する必要があります。
    データベースドライバ（mysql、mariadb、postgresqlなど）が準備済みステートメントをサポートしていない場合は、
    PDOでエミュレートできます。（ここではmariadbがサポートしているため、エミュレーションは無効になっています。）

    「prepare」メソッドを使用してSQLクエリを記述し、ユーザー入力を「?」または「:aChosenWord」に置き換えます。
*/
$sqlCouleur2 = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = ?");
/* 
    次に、ユーザー入力を、以下で説明するメソッド、または配列を渡す「execute」メソッドのいずれかで渡します。
    「?」を使用した場合、配列の最初の要素が最初の「?」に格納され、以下同様に続きます。
    「:aWord」を使用した場合は、連想配列を返します。
    「SELECT * FROM color WHERE COLOR_NAME = :mySuperColor」
    execute(["mySuperColor"=>$entryUser]);
*/
$entreUtilisateur = "Blanche";
$sqlCouleur2->execute([$entreUtilisateur]);
$couleurFromPrepare = $sqlCouleur2->fetch();
/* 
    execute の場合、渡されるすべてのパラメータは文字列として扱われます。
    これは、制限を指定する場合など、特定のケースで問題となる可能性があります。
    パラメータを渡す別の方法があります。
        「bindValue」と「bindParam」
        どちらも同じように動作します。
            最初のパラメータ: 準備済みステートメント内の名前、
            2番目のパラメータ: 使用する値、
            3番目のパラメータ: 値の型を示す PDO 定数
                PDO::PARAM_NULL
                PDO::PARAM_BOOL
                PDO::PARAM_INT
                PDO::PARAM_STR
*/
$sqlArticle = $pdo->prepare("SELECT * FROM article LIMIT :lim");
$sqlArticle->bindValue("lim", 5, PDO::PARAM_INT);
// この場合、実行は空のままです:
$sqlArticle->execute();
// 例えば、PDOが準備されたステートメントをエミュレートする場合、これはエラーを引き起こします。 :
// $sqlArticle->execute(["lim"=>5]);
$articles = $sqlArticle->fetchAll();

// ? bindValueとbindParamの違い :

// ? bindValueの例 :
// 色を選ぶ
$UserCouleur = "Blanche";
// リクエストを準備中です
$sqlBindValue = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = :col");
// bindValueを呼び出す
$sqlBindValue->bindValue("col", $UserCouleur, PDO::PARAM_STR);
// 色を変える
$UserCouleur = "Ambrée";
// クエリを実行する
$sqlBindValue->execute();
$couleurBindValue = $sqlBindValue->fetch();

// ? bindParamの例 :
// 色を選ぶ
$UserCouleur = "Blanche";
// リクエストを準備中です
$sqlBindParam = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = :col");
// bindParamを呼び出す
$sqlBindParam->bindParam("col", $UserCouleur, PDO::PARAM_STR);
// 色を変える
$UserCouleur = "Ambrée";
// クエリを実行する
$sqlBindParam->execute();
$couleurBindParam = $sqlBindParam->fetch();
/* 
    bindValue を使用すると、変数の値がそのまま準備されたステートメントに渡されます。
    bindParam を使用すると、変数全体が渡されます。そのため、実行前に変数の値が変更されると、ステートメントも変更されます。
*/

$title = " Connexion à la Base de donnée ";
require("../ressources/template/_header.php");

echo '<pre>'.print_r($couleurs, 1).'</pre>';
echo '<pre>'.print_r($type, 1).'</pre>';
echo '<pre>'.print_r($couleurFromPrepare, 1).'</pre>';
echo '<pre>'.print_r($articles, 1).'</pre>';
echo '<pre>'.print_r($couleurBindValue, 1).'</pre>';
echo '<pre>'.print_r($couleurBindParam, 1).'</pre>';


require("../ressources/template/_footer.php");
?>