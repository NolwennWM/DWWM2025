<?php 
require "../ressources/service/_csrf.php";

$title = "Security";
require "../ressources/template/_header.php";
/* 
    As web developers, we need to protect our sites from common attacks such as:
        - XSS (inserting JS scripts or HTML and CSS directly into the page)
        - CSRF (sending a request from a third-party form to a form on our site)
        - Brute Force (multiple login attempts with different credentials)
        - SQL Injection (sending SQL queries via user input)
        - spam bots (multiple emails via contact or registration forms)

    ------------------ XSS ------------------
    XSS (Cross Site Scripting)
    If we do not protect user input from this, they can inject any HTML, CSS, or JS into any form.
    To protect ourselves, we filter data meant for display, either before storing in the database or at display time using:
        - htmlspecialchars()
        or
        - htmlentities()
*/
$XSS_attack = "<script>document.querySelector('header').style.backgroundColor = 'chartreuse';</script>";
// Not secure:
echo $XSS_attack;
// Secure:
echo htmlspecialchars($XSS_attack), "<br>";
echo htmlentities($XSS_attack), "<br>";
// these functions replace certain characters like "<" with their HTML code "&gt;"

/* 
    ----------------------------CSRF---------------------------
    Cross Site Request Forgery.
    The principle is to build a request on any site or form.
    But instead of staying on that site, the request is sent to another site.
    For example, a small poll about your favorite fruit which hides invisible fields and when submitted, sends the request to a site you control to submit a form accessible only to you.

    To protect against this, we generate a random token (a sequence of letters and numbers) saved in the session and included in a hidden field in the form.
    When submitting the form, we check if this token matches the one stored in the session.
    A third-party form won't have the token.
    (see file ressources/service/_csrf.php)

    -------------------- Brute Force --------------
    Brute force is simply trying all possible identifiers (email/password) until finding a valid one.
    Doing it manually is very slow, but a bot can attempt thousands of tries per second.
    Possible solutions to protect against it:
        - Force users to use complex passwords (at least 8 or 12 characters, lowercase, uppercase, numbers, special chars)
        - Block account access after a certain number of failures (either temporarily or until email confirmation)
        - Force a wait time between attempts (even 1 or 2 seconds)

    -------------------------- SQL Injection ---------------------
    This consists of sending SQL commands through a form and having them executed.
    Whether to retrieve data, delete entries, or modify them.

    To protect against this, never insert user data directly into SQL queries:
    $user_message = "(DELETE FROM users;)";
    ! DON'T DO:
    $sql = "INSERT INTO messages (content) VALUES ($user_message)";
    ! This results in the query:
    "INSERT INTO messages (content) VALUES ((DELETE FROM users;))";

    ? The right solution is to use prepared statements:
    We'll see detailed usage later but simply put,
    Use a first function to read the SQL without user data:
        prepare("INSERT INTO messages (content) VALUES (?)")
    Then use a second function to send the data:
        values($user_message)
    No matter what the user input is, the database treats it as text.

    ------------------- spam bot -------------------------
    Forms accessible without login (contact forms, registration, less often login forms) are vulnerable to bots.
    Without protection, you might receive hundreds of emails from your contact form.

    - The most classic protection is to use a CAPTCHA (Completely Automated Public Turing test to tell Computers and Humans Apart)
    - Another is to use a Honey Pot, a deliberate trap which if filled proves it's a bot.
    For example, adding an invisible field (via CSS but not hidden input type) that humans won't fill but bots might.

    --------------------------- Hashing -------------------

    Not a security flaw but important: all passwords stored in the database must be hashed.
    An admin or hacker with DB access should not instantly know user passwords.
    We say hashing passwords, not encrypting, because encrypted text can be decrypted, while hashes cannot be reversed.
    ? Bonus:
        - Make sure forms containing private info use POST.
        - Make sure pages that require login are not accessible without login.

    Small example of a secure form:
*/
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['password']))
{
    if(!isCSRFValid())
    {
        $error = "The method used is not allowed!";
    }
    if(!isset($_POST["captcha"], $_SESSION['captchaStr']) || $_POST["captcha"] !== $_SESSION['captchaStr'])
    {
        $error = "Incorrect Captcha!";
    }
    if(empty($_POST["password"]))
    {
        $error = "Please enter a password";
    }
    else
    {
        $password = trim($_POST["password"]);
        /* 
            password_hash will hash the password given in the first parameter,
            using the algorithm specified in the second parameter.
            This algorithm is represented by a PHP constant, chosen among:
                PASSWORD_BCRYPT
                PASSWORD_ARGON2I
                PASSWORD_ARGON2ID
                (PASSWORD_DEFAULT lets PHP choose the most secure one)
            An optional third parameter can modify algorithm options.
        */
        $password = password_hash($password, PASSWORD_DEFAULT);
    }
}
?>
<hr>
<form action="06-security.php" method="POST">
    <label for="password">Hash a password:</label>
    <input type="password" name="password" id="password">
    <!-- captcha added -->
    <div>
        <label for="captcha">Please retype the following text:</label>
        <br>
        <img src="../ressources/service/_captcha.php" alt="captcha">
        <br>
        <input type="text" name="captcha" id="captcha" pattern="[A-Z0-9]{6}">
    </div>
    <!-- end captcha -->
    <!-- CSRF -->
        <?php setCSRF(); ?>
    <!-- end CSRF -->
    <br>
    <input type="submit" value="Send">
    <span class="error"><?= $error??"" ?></span>
</form>

<?php 
if(empty($error) && !empty($password))
{
    // This is an example but never display anyone's password like this
    echo "<p>Your hashed password is : $password</p>";
}
require "../ressources/template/_footer.php";
?>
