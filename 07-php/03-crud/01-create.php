<?php
require "../ressources/service/_pdo.php";
require "../ressources/service/_csrf.php";
require "../ressources/service/_shouldBeLogged.php";

shouldBeLogged(false, "/");
/* 
    For simplicity in this course, no security was added to this form, 
but remember to include it in your projects.
(csrf, captcha, email confirmation...)
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
        // preg_match is used to validate a regex.
        if(!preg_match("/^[a-zA-Z' -]{2,25}$/", $username))
        {
            $error["username"] = "Votre nom d'utilisateur ne doit contenir que des lettres. (entre 2 et 25)";
        }
    }// end of username check
    if(empty($_POST["email"]))
    {
        $error["email"] = "Veuillez saisir un email";
    }
    else
    {
        $email = cleanData($_POST["email"]);
        /* 
            filter_var can return a boolean indicating whether the first parameter is valid according to the specified filter,
or a modified string depending on the given filter.
    FILTER_VALIDATE_*** => boolean
    FILTER_SANITIZE_*** => string
        */
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error["email"] = "Veuillez saisir une adresse email valide";
        }
        else
        {
            // I prepare my query
            $sql = $pdo->prepare("SELECT * FROM users WHERE email=?");
            // I execute my query 
            $sql->execute([$email]);
            // I fetch my result
            $user = $sql->fetch();
            // If I found a user, then this email is already in use
            if($user)
            {
                $error["email"] = "Cet email est déjà utilisé";
            }
        }
    }// fin vérification email
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
            // ! Je hash le mot de passe
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
    }// fin vérification password
    if(empty($_POST["passwordBis"]))
    {
        $error["passwordBis"] = "Veuillez confirmer votre mot de passe";
    }
    elseif($_POST["password"] !== $_POST["passwordBis"])
    {
        $error["passwordBis"] = "Veuillez saisir le même mot de passe";
    }// fin confirmation password
    if(empty($error))
    {
        // Si on n'a pas d'erreur, alors on peut enregistré notre utilisateur en BDD
        $sql = $pdo->prepare("INSERT INTO users(username, email, password) VALUES(?, ?, ?)");
        // je lance la requête :
        $sql->execute([$username, $email, $password]);

        // Une fois terminé, je peux rediriger mon utilisateur ailleurs :
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