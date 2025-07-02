<?php 
namespace Controller;

use Classes\Abstract\AbstractController;
use Classes\Interface\CrudInterface;
use Entity\UserEntity;
use Model\UserModel;

class UserController extends AbstractController implements CrudInterface
{
    private UserModel $db;
    public function __construct()
    {
        $this->db = new UserModel();
    }
    /**
     * Gère la page d'inscription
     *
     * @return void
     */
    public function create()
    {
        // Si on est connecté, on est redirigé ailleurs
        $this->shouldBeLogged(false, "/07-poo");

        $errors = [];
        $user = new UserEntity();

        if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['userForm']))
        {
            // Je rempli mon entité :
            $user->setUsername($_POST["username"]??"");
            $user->setEmail($_POST["email"]??"");
            $user->setPassword($_POST["password"]??"");
            $user->setPasswordConfirm($_POST["passwordConfirm"]??"");

            // Je vérifie si il y a des erreurs :
            $errors = $user->validate();

            $resultat = $this->db->getOneUserByEmail($user->getEmail());
            if($resultat)
            {
                $errors["email"] = "Cet Email est déjà enregistré";
            }

            if(empty($errors))
            {
                $this->db->addUser($user);
                $this->setFlash("Inscription prise en compte.");

                header("Location: /07-poo");
                exit;
            }
        }
        // J'appelle ma vue :
        $this->render("user/inscription.php", [
            "error"=>$errors,
            "user"=>$user,
            "title"=>"POO - Inscription",
            "required"=>"required"
        ]);
    }
    use \Classes\Trait\Debug;  
    /**
     * Gère la page "liste des utilisateurs"
     *
     * @return void
     */
    public function read()
    {
        $users = $this->db->getAllUsers();
        // $this->dieAndDump($users);
        // $this->dump($users);
        $this->render("user/list.php", [
            "users"=>$users,
            "title"=>"POO - Liste Utilisateur"
        ]);
    }
    public function update(){echo "update user fonctionne";}
    public function delete(){echo "delete user fonctionne";}
}