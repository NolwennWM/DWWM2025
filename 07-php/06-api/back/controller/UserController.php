<?php 
// Specifies the methods allowed for this page:
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");

session_start();
require __DIR__."/../model/userModel.php";
require __DIR__."/../../../ressources/service/_csrf.php";

$regexPass = "/^(?=.*[!?@#$%^&*+-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/";

/* 
    The principle of a REST API (REpresentational State Transfer)
    is to have the same endpoint (here /06-api/back/user)
    perform different actions depending on the HTTP method used:
*/
switch($_SERVER["REQUEST_METHOD"])
{
    case "POST": create(); break;
    case "GET": read(); break;
    case "PUT": update(); break;
    case "DELETE": delete(); break;
}

/**
 * Handles the registration page.
 *
 * @return void
 */
function create():void
{
    // Retrieve data in JSON format:
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $username = $email = $password = "";
    $error = setError();
    if($data && isset($data->userForm))
    {
        // Username processing
        if(empty($data->username)){
            setError("username", "Please enter a username");
        }else{
            $username = cleanData($data->username);
            if(!preg_match("/^[a-zA-Z' -]{2,25}$/", $username)){
                setError("username", "Please enter a valid username");
            }
        }
        // Email processing
        if(empty($data->email))
        {
            setError("email", "Please enter an email");
        }
        else
        {
            $email = cleanData($data->email);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                setError("email", "Please enter a valid email");
            }
            // Check if the user already exists in the DB
            $resultat = getOneUserByEmail($email);
            if($resultat)
            {
                setError("email", "This email is already registered.");
            }
        }
        // Password processing
        if(empty($data->password))
        {
            setError("password", "Please enter a password");
        }
        else
        {
            $password = cleanData($data->password);
            // use the regex defined above.
            global $regexPass;
            if(!preg_match($regexPass, $password))
            {
                setError("password", "Please enter a valid password");
            }
            else
            {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
        }
        // Password confirmation check
        if(empty($data->passwordBis))
        {
            setError("passwordBis", "Please re-enter your password");
        }
        elseif($data->password != $data->passwordBis)
		{
			setError("passwordBis", "Passwords do not match");
		}
        $error = setError();
        // Data submission
        if(empty($error["violations"]))
        {
            // Add the user to the DB
            $user = addUser($username, $email, $password);
            sendResponse($user, 200, "Registration successful");
        }
    }
    sendResponse($error, 400, "Invalid form data");
}

/**
 * Handles the user list
 *
 * @return void
 */
function read():void
{
    // Retrieve all users
    if(isset($_GET["id"]))
        $users = getOneUserById((int)$_GET["id"]);
    else
        $users = getAllUsers();
    sendResponse($users, 200, "User(s) retrieved.");
}

/**
 * Handles the user update page.
 *
 * @return void
 */
function update():void
{
    if(!isset($_GET["id"],$_SESSION["idUser"]) || $_SESSION["idUser"] != $_GET["id"])
    {
        sendResponse(setError(), 400, "Access denied!");
    }
    // Retrieve the user's current data
    $user = getOneUserById((int)$_GET["id"]);

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $username = $password = $email = "";
    $error = setError();

    if($data && isset($data->userForm))
    {
		// Username processing
        if(!empty($data->username))
        {
            $username= cleanData($data->username);
            if(!preg_match("/^[a-zA-Z' -]{2,25}$/", $username))
            {
                setError("username", "Your username may only contain letters.");
            }
        }
        else
        {
            $username = $user["username"];
        }
		// Email processing
        if(!empty($data->email))
        {
            $email= cleanData($data->email);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                setError("email","Please enter a valid email");
            }
            elseif($email != $user["email"])
            {
                $exist = getOneUserByEmail($email);
                if($exist)
                {
                    setError("email","This email already exists");
                }
            }
        }
        else
        {
            $email = $user["email"];
        }
		// Password processing
        if(!empty($data->password))
        {
            if(empty($data->passwordBis))
            {
                setError("passwordBis","Please re-enter your password");
            }
            elseif($data->password != $data->passwordBis)
            {
                setError("passwordBis","Passwords do not match");
            }
            $password = cleanData($data->password);
            global $regexPass;
            if(!preg_match($regexPass, $password))
            {
                setError("password","Please enter a valid password");
            }
            else
            {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
        }
        else
        {
            $password = $user["password"];
        }
        $error = setError();
        if(empty($error["violations"]))
        {
            // Update user in DB
            $user = updateUserById($username, $email, $password, $user["idUser"]);
            
            sendResponse($user, 200, "User updated");
        }
    }
    
    sendResponse($error, 400, "Invalid form data");
}

/**
 * Handles the user deletion page.
 *
 * @return void
 */
function delete():void
{
    if(!isset($_GET["id"], $_SESSION["idUser"]) || $_SESSION["idUser"] != $_GET["id"])
    {
        sendResponse($_SESSION, 400, "Access denied!");
    }
    // Delete the user
    deleteUserById((int)$_GET["id"]);
    // Log the user out
    unset($_SESSION);
    session_destroy();
    setcookie("PHPSESSID","", time()-3600);
        
    sendResponse([], 200, "Account deleted and logged out");
}
