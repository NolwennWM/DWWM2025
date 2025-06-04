<?php
// I declare several variables as empty strings.
$username = $food = $drink = "";
// I declare a variable that will be used to store my errors:
$error = [];
// List of options offered in the form:
// $foodList = ["welsh", "cannelloni", "oyakodon"];
$foodList = [
    "welsh"=>"Welsh (because cheese is life)", 
    "cannelloni"=>"Cannelloni (because ravioli are overrated)", 
    "oyakodon"=>"Oyakodon (because I like dark humor)",
    "pizza"=>"Pizza (preferably with pineapple)"
];
$drinkList = [
    "jus de tomate"=>"Tomato Juice (I'm a vampire)", 
    "milkshake"=>"Milkshake (preferably fruit)", 
    "limonade"=>"Lemonade (I need sugar)"
];
// I will check that the expected method is used by the form and that at least one element from the form is provided:
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["meal"]))
{
    // echo "Form submitted!";
    // The name in the $_POST superglobal corresponds to the "name" attribute of the form fields.
    if(empty($_POST["username"]))
    {
        // empty returns true if the parameter is empty.
        $error["username"] = "Please enter a username";
    }
    else
    {
        // removes spaces at the beginning and end of the string
        $username = trim($_POST["username"]);
        // removes any backslashes in the string
        $username = stripslashes($username);
        // Must always be done for any data that will be displayed
        // This can be done either before storing in the database or just before displaying
        $username = htmlspecialchars($username);
        // Replaces all special HTML characters (<, >, ...) with their HTML code (&gt;, ...) to prevent code injection
        if(strlen($username) < 3 || strlen($username)>25)
        {
            $error["username"] = "Your username length is not appropriate";
        }
    } // end username validation
    if(empty($_POST["food"]))
    {
        $error["food"] = "Please select a meal";
    }
    else
    {
        $food = $_POST["food"];
        if(!array_key_exists($food, $foodList))
        {
<<<<<<< HEAD
            $error["food"] = "This meal does not exist";
        }
    } // end food validation
    if(empty($_POST["drink"]))
    {
        $error["drink"] = "Please select a drink";
=======
            $error["food"] = "Ce repas n'existe pas";
        }
    }//fin vérification food
    if(empty($_POST["drink"]))
    {
        $error["drink"] = "Veuillez selectionner une boisson";
>>>>>>> main
    }
    else
    {
        $drink = $_POST["drink"];
        if(!array_key_exists($drink, $drinkList))
        {
<<<<<<< HEAD
            $error["drink"] = "This drink does not exist";
        }
    } // end drink validation
    // If there are no errors
    if(empty($error))
    {
        /* 
            This is where we could send our data to the database
        */
    }
} // end form validation
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

$title = " POST ";
require("../ressources/template/_header.php");
?>

<form action="02-post.php" method="POST">
    <input 
        type="text" 
<<<<<<< HEAD
        placeholder="Enter a name" 
=======
        placeholder="Entrez un nom" 
>>>>>>> main
        name="username" 
        value="<?= $username ?>" 
        class="<?= empty($error["username"])?"":"formError" ?>"
        >
<<<<<<< HEAD
    <!-- span.error will be used to display error messages -->
=======
    <!-- les span.error serviront à afficher les messages d'erreur. -->
>>>>>>> main
    <span class="error"><?= $error["username"]??"" ?></span>
    <!-- <span class="error"><?php echo $error["username"]??"" ?></span> -->
    <br>
    <fieldset>
<<<<<<< HEAD
        <legend>Favorite food</legend>
        <!-- Loop through each item in the foodList array -->
        <?php foreach($foodList as $key => $value): ?>
            <!-- Set the array key as the id and value -->
=======
        <legend>Nourriture favorite</legend>
        <!-- Je boucle sur chaque élément du tableau foodList -->
        <?php foreach($foodList as $key => $value): ?>
            <!-- Je place en id et en value la clef du tableau -->
>>>>>>> main
            <input 
                type="radio" 
                name="food" 
                id="<?= $key ?>" 
                value="<?= $key ?>"
                <?= $food === $key?"checked":"" ?>
                > 
<<<<<<< HEAD
                <!-- If the $food variable matches one of the inputs, add the "checked" attribute -->
                <!-- Set the array key as the 'for' attribute and the value as the label text -->
=======
                <!-- Si la variable $food correspond à l'un de mes inputs, alors on lui ajoute l'attribut "checked" -->
                <!-- Je place en for la clef du tableau et en texte la value du tableau -->
>>>>>>> main
            <label for="<?= $key ?>"><?= $value ?></label>
            <br>
        <?php endforeach; ?>
        <span class="error"><?= $error["food"]??"" ?></span>
    </fieldset>
<<<<<<< HEAD
    <label for="boisson">Favorite drink</label>
    <br>
    <select name="drink" id="boisson">
        <?php foreach($drinkList as $key => $value){ ?>
            <!-- If the $drink variable matches one of the options, add the "selected" attribute -->
=======
    <label for="boisson">Boisson favorite</label>
    <br>
    <select name="drink" id="boisson">
        <?php foreach($drinkList as $key => $value){ ?>
            <!-- Si la variable $drink correspond à l'une des options, alors on lui ajoute l'attribut "selected" -->
>>>>>>> main
            <option value="<?= $key ?>" <?= $drink === $key?"selected":"" ?>>
                <?= $value ?>
            </option>
        <?php } ?>
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
