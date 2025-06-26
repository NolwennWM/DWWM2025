<?php
/*
	TODO : checkbox "Voulez vous rester connecté ?"
*/
require __DIR__."/../../../ressources/service/_shouldBeLogged.php";
shouldBeLogged(false, "/04-router/");
$email = $pass = "";
$error = [];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])){
    if(empty($_POST["email"])){
        $error["email"] = "Veuillez entrer un email.";
    }else{
        $email = trim($_POST["email"]);
    }
    if(empty($_POST["password"])){
        $error["pass"] = "Veuillez entrer un mot de passe.";
    }else{
        $pass = trim($_POST["password"]);
    }
    if(empty($error)){
        require __DIR__."/../../../ressources/service/_pdo.php";
        $pdo = connexionPDO();
        $sql = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $sql->execute([$email]);
        $user = $sql->fetch();
        if($user){
            if(password_verify($pass, $user["password"])){
                $_SESSION["logged"] = true; 
                $_SESSION["username"] = $user["username"];
                $_SESSION["idUser"] = $user["idUser"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["expire"] = time()+ (60*60);
                header("Location: /04-router/");
				exit;
            }
            else{
                $error["login"] = "Email ou Mot de passe incorrecte.";
            }
        }
        else{
            $error["login"] = "Email ou Mot de passe incorrecte.";
        }
    }
}
$title = " Connexion ";
require(__DIR__."/../../../ressources/template/_header.php");
?>

<form action="/04-router/connexion" method="post">
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    <br>
    <span class="error"><?php echo $error["email"]??""; ?></span>
    <br>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password">
    <br>
    <span class="error"><?php echo $error["pass"]??""; ?></span>
    <br>
    <input type="submit" value="Connexion" name="login">
    <br>
    <span class="error"><?php echo $error["login"]??""; ?></span>
</form>
<?php
require(__DIR__."/../../../ressources/template/_footer.php");
?>