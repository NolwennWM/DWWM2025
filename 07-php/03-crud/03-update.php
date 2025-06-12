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
    // If the "username" field is empty, keep the current username
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
    } // End of username check
    // If the field is empty or hasn't changed, keep the current email
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
    }// End of email check
    // If the password is empty, keep the current password
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
    }// End of password check
    if(empty($error))
    {
        $sql = $db->prepare("UPDATE users SET username=:us, email=:em, password=:mdp WHERE idUser=:id");
        $sql->execute([
            "id"=>$user["idUser"],
            "mdp"=>$password,
            "us"=>$username,
            "em"=>$email
        ]);
        
        // I update the session-stored information:
        $_SESSION["username"] = $username;
        // I create a flash message that will disappear on reload:
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
    <!-- username -->
    <label for="username">Nom d'Utilisateur :</label>
    <input type="text" name="username" id="username" value="<?php echo $user["username"] ?>">
    <span class="erreur"><?php echo $error["username"]??""; ?></span>
    <br>
    <!-- Email -->
    <label for="email">Adresse Email :</label>
    <input type="email" name="email" id="email" value="<?php echo $user["email"] ?>">
    <span class="erreur"><?php echo $error["email"]??""; ?></span> 
    <br>
    <!-- Password -->
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password">
    <span class="erreur"><?php echo $error["password"]??""; ?></span> 
    <br>
    <!-- password verify -->
    <label for="passwordBis">Confirmation du mot de passe :</label>
    <input type="password" name="passwordBis" id="passwordBis">
    <span class="erreur"><?php echo $error["passwordBis"]??""; ?></span> 
    <br>

    <input type="submit" value="Mettre à jour" name="update">
</form>
<?php else: ?>
    <p>Aucun Utilisateur trouvé</p>
<?php 
endif;
require("../ressources/template/_footer.php");
?>