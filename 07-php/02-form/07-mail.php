<?php 

/* 
    Coder un envoi de mail via PHP qui soit sécurisé et sans erreur est très complexe.
    C'est pour cela que la plupart des gens passent par un bibliothèque comme par exemple "PHPMailer".
    Pour l'installer nous allons avoir besoin du gestionnaire de packet "composer" qui lui même aura besoin d'une installation de "PHP".

    Pour installer PHPMailer, on tapera la commande :
        * composer require phpmailer/phpmailer
*/
session_start();
// on inclu notre outil de mail.
require "../ressources/service/_mailer.php";
$email = $subject = $body = $envoi = "";
$error = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' 
    && isset($_POST["contact"]))
{
    if(empty($_POST["email"]))
        $error["email"] = "Veuillez entrer un email";
    else{
        $email = cleanData($_POST["email"]);
        /* 
            La fonction filter_var prend un string en premier paramètre
            et en second paramètre une constante qui correspond 
            à plusieurs traitements que l'on peut effectuer sur le string.
            filter_validate_email permet de vérifier si le string en premier paramètre correspond à un email.
        */
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $error["email"] = "Veuillez entrer un email valide";
    }  
    if(empty($_POST["sujet"]))
        $error["sujet"] = "";
    else
        $subject = cleanData($_POST["sujet"]);
    if(empty($_POST["corps"]))
        $error["corps"] = "";
    else
        $body = cleanData($_POST["corps"]);
        
    if(!isset($_POST['captcha'], $_SESSION['captchaStr']) 
    || $_POST['captcha'] != $_SESSION['captchaStr'])
        $error["captcha"] = "CAPTCHA incorrecte !";
    // Si tout s'est bien passé, on envoi le mail
    if(empty($error))
        $envoi = sendMail(
            $email,
            "cours@nolwenn.fr", 
            $subject, 
            $body
        );
}
function cleanData(string $data): string{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}
$title = " Email ";
require("../ressources/template/_header.php");
if(!empty($envoi)):
?>
<p>
    <?php echo $envoi ?>
</p>
<?php endif; ?>
<form action="" method="post">
    <input type="email" name="email" placeholder="Votre email">
    <span class="error"><?php echo $error["email"]??"" ?></span>
    <br>
    <input type="text" name="sujet" placeholder="Sujet de votre message">
    <span class="error"><?php echo $error["sujet"]??"" ?></span>
    <br>
    <textarea name="corps" cols="30" rows="10" placeholder="Votre message"></textarea>
    <span class="error"><?php echo $error["corps"]??"" ?></span>
    <br>
    <div>
        <label for="captcha">Veuillez recoppier le texte ci-dessous pour valider :</label>
        <br>
        <img src="../ressources/service/_captcha.php" alt="CAPTCHA">
        <br>
        <input type="text" id="captcha" name="captcha" pattern="[A-Z0-9]{6}">
    <span class="error"><?php echo $error["captcha"]??"" ?></span>
    </div>
    <input type="submit" value="Envoyer" name="contact">
</form>
<?php
require("../ressources/template/_footer.php");
?>