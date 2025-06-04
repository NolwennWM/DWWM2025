<?php
// I declare several variables as empty strings.
$username = $food = $drink = "";
// I declare a variable that will be used to store my errors:
$error = [];
// List of options offered in the form:
$foodList = ["welsh", "cannelloni", "oyakodon"];
$drinkList = ["jus de tomate", "milkshake", "limonade"];
// I will check that the expected method is used by the form and that at least one element from the form is provided:
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["meal"]))
{
    // echo "Form submitted!";
    // The name in the $_GET superglobal corresponds to the "name" attribute of the form fields.
    if(empty($_GET["username"]))
    {
        // empty returns true if the parameter is empty.
        $error["username"] = "Please enter a username";
    }
    else
    {
        // removes spaces at the beginning and end of the string
        $username = trim($_GET["username"]);
        // removes any backslashes in the string.
        $username = stripslashes($username);
        // Must always be done for any data that will be displayed
        // This can be done either before storing in the database or just before displaying
        $username = htmlspecialchars($username);
        // Replaces all special HTML characters (<, >, ...) with their HTML code (&gt;, ...) to prevent any code injection.
        if(strlen($username) < 3 || strlen($username)>25)
        {
            $error["username"] = "Your username length is not appropriate";
        }
    } // end of username check
    if(empty($_GET["food"]))
    {
        $error["food"] = "Please select a meal";
    }
    else
    {
        $food = $_GET["food"];
        if(!in_array($food, $foodList))
        {
<<<<<<< HEAD
            $error["food"] = "This meal does not exist";
        }
    } // end of food check
    if(empty($_GET["drink"]))
    {
        $error["drink"] = "Please select a drink";
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
            $error["drink"] = "This drink does not exist";
        }
    } // end of drink check
    // If I have no errors
    if(empty($error))
    {
        /* 
            This is where we could send our data to the database
        */
    }
} // end of form check
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
<<<<<<< HEAD
    <input type="text" placeholder="Enter a name" name="username">
    <!-- the span.error will be used to display error messages -->
=======
    <input type="text" placeholder="Entrez un nom" name="username">
    <!-- les span.error serviront à afficher les messages d'erreur. -->
>>>>>>> main
    <span class="error"><?= $error["username"]??"" ?></span>
    <!-- <span class="error"><?php echo $error["username"]??"" ?></span> -->
    <br>
    <fieldset>
<<<<<<< HEAD
        <legend>Favorite food</legend>
        <input type="radio" name="food" id="welsh" value="welsh"> 
        <label for="welsh">Welsh (because cheese is life)</label>
        <br>
        <input type="radio" name="food" id="cannelloni" value="cannelloni"> 
        <label for="cannelloni">Cannelloni (because ravioli are overrated)</label>
        <br>
        <input type="radio" name="food" id="oyakodon" value="oyakodon"> 
        <label for="oyakodon">Oyakodon (because I like dark humor)</label>
        <span class="error"><?= $error["food"]??"" ?></span>
    </fieldset>
    <label for="boisson">Favorite drink</label>
    <br>
    <select name="drink" id="boisson">
        <option value="jus de tomate">Tomato juice (I'm a vampire)</option>
        <option value="milkshake">Milkshake (preferably fruit)</option>
        <option value="limonade">Lemonade (I need sugar)</option>
=======
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
    <input type="submit" value="Submit" name="meal">
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
