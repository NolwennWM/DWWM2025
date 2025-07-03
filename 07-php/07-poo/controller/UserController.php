<?php 
namespace Controller;

use Classes\Abstract\AbstractController;
use Classes\Interface\CrudInterface;
use Entity\UserEntity;
use Model\UserModel;

class UserController extends AbstractController implements CrudInterface
{
    use \Classes\Trait\Debug;

    private UserModel $db;

    public function __construct()
    {
        $this->db = new UserModel();
    }

    /**
     * Handles the registration page.
     *
     * @return void
     */
    public function create()
    {
        // If the user is logged in, redirect elsewhere.
        $this->shouldBeLogged(false, "/07-poo");

        $errors = [];
        $user = new UserEntity();

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userForm']))
        {
            // Fill the entity with form data.
            $user->setUsername($_POST["username"] ?? "");
            $user->setEmail($_POST["email"] ?? "");
            $user->setPassword($_POST["password"] ?? "");
            $user->setPasswordConfirm($_POST["passwordConfirm"] ?? "");

            // Check for validation errors.
            $errors = $user->validate();

            $resultat = $this->db->getOneUserByEmail($user->getEmail());
            if($resultat)
            {
                $errors["email"] = "This email is already registered.";
            }

            if(empty($errors))
            {
                $this->db->addUser($user);
                $this->setFlash("Registration successful.");

                header("Location: /07-poo");
                exit;
            }
        }

        // Render the view.
        $this->render("user/inscription.php", [
            "error"   => $errors,
            "user"    => $user,
            "title"   => "POO - Registration",
            "required"=> "required"
        ]);
    }

    /**
     * Handles the "user list" page.
     *
     * @return void
     */
    public function read()
    {
        $users = $this->db->getAllUsers();
        // $this->dieAndDump($users);
        // $this->dump($users);

        $this->render("user/list.php", [
            "users" => $users,
            "title" => "POO - User List"
        ]);
    }
    /**
     * Handles the profile update page.
     *
     * @return void
     */
    public function update()
    {
        // You must be logged in to update your profile.
        $this->shouldBeLogged(true, "/07-poo");

        // Retrieve the user's information.
        $user = $this->db->getOneUserById((int)$_SESSION["idUser"]);

        $errors = [];

        // If the form was submitted:
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userForm']))
        {
            // Get the user's current email.
            $oldEmail = $user->getEmail();

            // Fill the user object with new data.
            $user->setUsername($_POST["username"] ?? "");
            $user->setEmail($_POST["email"] ?? "");
            $user->setPassword($_POST["password"] ?? "");
            $user->setPasswordConfirm($_POST["passwordConfirm"] ?? "");

            // Validate input.
            $errors = $user->validate();

            // Check if a new email was provided.
            if(!empty($_POST["email"]) && trim($_POST["email"]) !== $oldEmail)
            {
                // Check if another user is already using the new email.
                $exist = $this->db->getOneUserByEmail($user->getEmail());
                if($exist)
                {
                    $errors["email"] = "This email is already in use.";
                }
            } // End of email check

            // If there are no errors, update the database.
            if(empty($errors))
            {
                $this->db->updateUserById($user);

                // Set a confirmation message.
                $this->setFlash("Your profile has been updated.");

                // Redirect the user.
                header("Location: /07-poo");
                exit;
            }
        } // End of form submission check

        // Include the view.
        $this->render("user/update.php", [
            "error" => $errors,
            "user" => $user,
            "title" => "POO - Profile Update"
        ]);
    }

    /**
     * Handles the account deletion page.
     *
     * @return void
     */
    public function delete()
    {
        // If the user is not logged in, redirect.
        $this->shouldBeLogged(true, "/07-poo");

        // Delete the currently logged-in user's account.
        $this->db->deleteUserById((int)$_SESSION["idUser"]);

        // Log out the user.
        session_destroy();
        unset($_SESSION);
        setCookie("PHPSESSID", "", time()-3600);

        // Redirect after a few seconds.
        header("refresh: 5;url=/07-poo");

        // Display a confirmation message.
        $this->render("user/delete.php", ["title" => "POO - Account Deletion"]);
    }
}