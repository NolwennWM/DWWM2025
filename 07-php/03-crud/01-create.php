<?php
require "../ressources/service/_pdo.php";
require "../ressources/service/_csrf.php";
require "../ressources/service/_shouldBeLogged.php";

shouldBeLogged(false, "/");
/* 
    この講座では簡略化のため、このフォームにセキュリティは追加していませんが、
実際のプロジェクトでは必ず追加してください。
（CSRF、キャプチャ、メール確認など）
*/
$username = $email = $password = "";
$error = [];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['inscription']))
{
    $pdo = connexionPDO();

    if(empty($_POST["username"]))
    {
        $error["username"] = "Veuillez saisir un nom d'utilisateur";
    }
    else
    {
        $username = cleanData($_POST["username"]);
        // preg_match は正規表現を確認するために使用されます。
        if(!preg_match("/^[a-zA-Z' -]{2,25}$/", $username))
        {
            $error["username"] = "Votre nom d'utilisateur ne doit contenir que des lettres. (entre 2 et 25)";
        }
    }// ユーザー名の確認終了
    if(empty($_POST["email"]))
    {
        $error["email"] = "Veuillez saisir un email";
    }
    else
    {
        $email = cleanData($_POST["email"]);
        /* 
            filter_var は、第1引数が第2引数のフィルターに従って有効かどうかのブール値、
またはフィルターに従って変更された文字列を返します。
    FILTER_VALIDATE_*** => ブール値
    FILTER_SANITIZE_*** => 文字列
        */
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error["email"] = "Veuillez saisir une adresse email valide";
        }
        else
        {
            // クエリを準備します
            $sql = $pdo->prepare("SELECT * FROM users WHERE email=?");
            // クエリを実行します 
            $sql->execute([$email]);
            // 結果を取得します
            $user = $sql->fetch();
            // ユーザーが見つかった場合、そのメールアドレスはすでに使用されています
            if($user)
            {
                $error["email"] = "Cet email est déjà utilisé";
            }
        }
    }// メール確認の終了
    if(empty($_POST["password"]))
    {
        $error["password"] = "Veuillez saisir un mot de passe";
    }
    else
    {
        $password = trim($_POST["password"]);
        if(!preg_match("/^(?=.*[!?@#$%^&*+-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/", $password))
        {
            $error["password"] = "Veuillez utiliser au moins 6 minuscule, majuscule, chiffre et caractère speciaux";
        }
        else
        {
            // ! パスワードをハッシュ化します
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
    }// パスワード確認の終了
    if(empty($_POST["passwordBis"]))
    {
        $error["passwordBis"] = "Veuillez confirmer votre mot de passe";
    }
    elseif($_POST["password"] !== $_POST["passwordBis"])
    {
        $error["passwordBis"] = "Veuillez saisir le même mot de passe";
    }// パスワード確認終了
    if(empty($error))
    {
        // エラーがなければ、ユーザーをデータベースに保存できます
        $sql = $pdo->prepare("INSERT INTO users(username, email, password) VALUES(?, ?, ?)");
        // クエリを実行します :
        $sql->execute([$username, $email, $password]);

        // 完了したら、ユーザーを他の場所にリダイレクトできます：
        header("Location: /");
        exit;
    }
}

$title = " CRUD - Create ";
require("../ressources/template/_header.php");
?>
<form action="./01-create.php" method="post">
    <!-- username -->
    <label for="username">Nom d'Utilisateur :</label>
    <input type="text" name="username" id="username" required>
    <span class="erreur"><?php echo $error["username"]??""; ?></span>
    <br>
    <!-- Email -->
    <label for="email">Adresse Email :</label>
    <input type="email" name="email" id="email" required>
    <span class="erreur"><?php echo $error["email"]??""; ?></span> 
    <br>
    <!-- Password -->
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>
    <span class="erreur"><?php echo $error["password"]??""; ?></span> 
    <br>
    <!-- password verify -->
    <label for="passwordBis">Confirmation du mot de passe :</label>
    <input type="password" name="passwordBis" id="passwordBis" required>
    <span class="erreur"><?php echo $error["passwordBis"]??""; ?></span> 
    <br>

    <input type="submit" value="Inscription" name="inscription">
</form>
<?php 
require("../ressources/template/_footer.php");
?>