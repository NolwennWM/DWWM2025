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

    public function update()
    {
        echo "update user works";
    }

    public function delete()
    {
        echo "delete user works";
    }
}
