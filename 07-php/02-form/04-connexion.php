<?php 
if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
    // If no session lifetime is specified, the user will be logged out when the browser is closed.
}

// If the user is already logged in
if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)
{
    // Redirect them elsewhere
    header("Location: /");
    exit;
}

$email = $pass = "";
$error = [];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['login']))
{
    if(empty($_POST["email"]))
    {
        $error["email"] = "Please enter an email address";
    }
    else
    {
        $email = trim($_POST["email"]);
    } // End of email check

    if(empty($_POST["password"]))
    {
        $error["password"] = "Please enter a password";
    }
    else
    {
        $pass = trim($_POST["password"]);
    } // End of password check

    if(empty($error))
    {
        /* 
            Normally, this is where we would retrieve user data from the database.
            But for now, we're using a JSON file.

            file_get_contents() allows us to read data from a file.
        */
        $users = file_get_contents("../ressources/users.json");
        /* 
            json_decode translates a JSON-formatted string
            into PHP-readable data.
            By default, JSON objects are converted to PHP objects.
            But if we pass true as the second parameter,
            JSON objects are converted to associative arrays.
        */
        $users = json_decode($users, true);
        // var_dump($users);

        // Check if a user with this email exists
        $user = $users[$email] ?? false;

        // If a user is found:
        if($user)
        {
            /* 
                Passwords stored in a database (or JSON here) should be hashed.
                Because the hash is different each time, we can’t use == for comparison.
                We use password_verify() instead:
                    - First argument: the plain password from the form
                    - Second argument: the hashed password from storage
            */
            if(password_verify($pass, $user["password"]))
            {
                /* 
                    Correct email and password.
                    The user is now logged in.
                    To persist login status across pages,
                    we set something in the session, like $_SESSION["logged"] = true;
                */
                $_SESSION["logged"] = true;
                /* 
                    We can also store other user info to reuse across pages,
                    such as username or avatar
                */
                $_SESSION["username"] = $user["username"];
                /* 
                    Or anything else we may want to validate across pages,
                    like a session timeout if login duration is limited
                */
                $_SESSION["expire"] = time()+3600;
                // Once logged in, redirect the user elsewhere (e.g., profile or homepage)
                header("Location: /");
                exit;
            } else
            {
                $error["login"] = "Incorrect email or password (password)";
            } // End of password check
        }
        else
        {
            $error["login"] = "Incorrect email or password (email)";
        } // End of email check
    }
}

$title = " Login ";
require("../ressources/template/_header.php");
?>
    <form action="04-connexion.php" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <span class="error"><?= $error["email"]??"" ?></span>
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <span class="error"><?= $error["password"]??"" ?></span>
        <br>
        <button type="submit" name="login">Login</button>
        <span class="error"><?= $error["login"]??"" ?></span>
    </form>

<?php 
require("../ressources/template/_footer.php");
?>
