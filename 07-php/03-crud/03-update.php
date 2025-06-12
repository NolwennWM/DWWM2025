<?php 
require "../ressources/service/_csrf.php";
require "../ressources/service/_pdo.php";
require "../ressources/service/_shouldBeLogged.php";

shouldBeLogged(true, "/");

$db = connexionPDO();
$sql = $db->prepare("SELECT * FROM users WHERE idUser=?");
$sql->execute([(int)$_SESSION["user_id"]]);

$user = $sql->fetch();

$username = $password = $email = "";
$error = [];
$regexPassword = "/^(?=.*[!?@#$%^&*+-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/";

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update']))
{
    // "username" フィールドが空の場合、既存のユーザー名を保持する
    if(empty($_POST["username"]))
    {
        $username = $user["username"];
    }
    else
    {
        $username = cleanData($_POST["username"]);
        
        if(!preg_match("/^[a-zA-Z' -]{2,25}$/", $username))
        {
            $error["username"] = "Votre nom d'utilisateur ne doit contenir que des lettres. (entre 2 et 25)";
        }
    } // ユーザー名のチェック終了
    // フィールドが空、または変更されていない場合、既存のメールアドレスを保持する
    if(empty($_POST["email"]) || $_POST["email"] === $user["email"])
    {
        $email = $user["email"];
    }
    else
    {
        $email = cleanData($_POST["email"]);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error["email"] = "Veuillez saisir une adresse email valide";
        }
        else
        {
            $sql = $pdo->prepare("SELECT * FROM users WHERE email=?");
            $sql->execute([$email]);
            $user = $sql->fetch();
            if($user)
            {
                $error["email"] = "Cet email est déjà utilisé";
            }
        }
    }// メールアドレスのチェック終了
    // パスワードが空であれば、既存のパスワードを保持する
    if(empty($_POST["password"]))
    {
        $password = $user["password"];
    }
    else
    {
        $password = trim($_POST["password"]);
        if(empty($_POST["passwordBis"]))
        {
            $error["passwordBis"] = "Veuillez confirmer votre mot de passe";
        }
        elseif($_POST["password"] !== $_POST["passwordBis"])
        {
            $error["passwordBis"] = "Veuillez saisir le même mot de passe";
        }
        if(!preg_match($regexPassword, $password))
        {
            $error["password"] = "Veuillez saisir un mot de passe plus complexe";
        }
        else
        {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
    }// パスワードのチェック終了
    if(empty($error))
    {
        $sql = $db->prepare("UPDATE users SET username=:us, email=:em, password=:mdp WHERE idUser=:id");
        $sql->execute([
            "id"=>$user["idUser"],
            "mdp"=>$password,
            "us"=>$username,
            "em"=>$email
        ]);
        // セッションに保存されている情報を更新する
        $_SESSION["username"] = $username;
        // リロード時に消えるフラッシュメッセージを作成する
        $_SESSION["flash"] = "Profil mis à jour";
        header("Location: ./02-read.php");
        exit;
    }
}

$title = " CRUD - Mise à jour du Profil ";
require("../ressources/template/_header.php");
if($user):
?>
<form action="" method="post">
    <!-- ユーザー名 -->
    <label for="username">Nom d'Utilisateur :</label>
    <input type="text" name="username" id="username" value="<?php echo $user["username"] ?>">
    <span class="erreur"><?php echo $error["username"]??""; ?></span>
    <br>
    <!-- メールアドレス  -->
    <label for="email">Adresse Email :</label>
    <input type="email" name="email" id="email" value="<?php echo $user["email"] ?>">
    <span class="erreur"><?php echo $error["email"]??""; ?></span> 
    <br>
    <!-- パスワード  -->
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password">
    <span class="erreur"><?php echo $error["password"]??""; ?></span> 
    <br>
    <!-- パスワード確認 -->
    <label for="passwordBis">Confirmation du mot de passe :</label>
    <input type="password" name="passwordBis" id="passwordBis">
    <span class="erreur"><?php echo $error["passwordBis"]??""; ?></span> 
    <br>

    <input type="submit" value="Mettre à jour" name="update">
</form>
<?php else: ?>
    <p>ユーザーが見つかりません</p>
<?php 
endif;
require("../ressources/template/_footer.php");
?>