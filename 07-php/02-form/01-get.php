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
            $error["food"] = "This meal does not exist";
        }
    } // end of food check
    if(empty($_GET["drink"]))
    {
        $error["drink"] = "Please select a drink";
    }
    else
    {
        $drink = $_GET["drink"];
        if(!in_array($drink, $drinkList))
        {
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

$title = " GET ";
require("../ressources/template/_header.php");
?>

<form action="01-get.php" method="GET">
    <input type="text" placeholder="Enter a name" name="username">
    <!-- the span.error will be used to display error messages -->
    <span class="error"><?= $error["username"]??"" ?></span>
    <!-- <span class="error"><?php echo $error["username"]??"" ?></span> -->
    <br>
    <fieldset>
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
    </select>
    <span class="error"><?= $error["drink"]??"" ?></span>
    <br>

    <input type="submit" value="Submit" name="meal">
</form>

<?php 
require("../ressources/template/_footer.php");
?>
