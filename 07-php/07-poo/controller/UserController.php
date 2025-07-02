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
     * 登録ページを処理します。
     *
     * @return void
     */
    public function create()
    {
        // ユーザーがログインしている場合は、他のページへリダイレクト。
        $this->shouldBeLogged(false, "/07-poo");

        $errors = [];
        $user = new UserEntity();

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userForm']))
        {
            // フォームのデータでエンティティを埋める。
            $user->setUsername($_POST["username"] ?? "");
            $user->setEmail($_POST["email"] ?? "");
            $user->setPassword($_POST["password"] ?? "");
            $user->setPasswordConfirm($_POST["passwordConfirm"] ?? "");

            // バリデーションエラーを確認する。
            $errors = $user->validate();

            $resultat = $this->db->getOneUserByEmail($user->getEmail());
            if($resultat)
            {
                $errors["email"] = "このメールアドレスは既に登録されています";
            }

            if(empty($errors))
            {
                $this->db->addUser($user);
                $this->setFlash("登録が成功しました.");

                header("Location: /07-poo");
                exit;
            }
        }

        // ビューをレンダリングする。
        $this->render("user/inscription.php", [
            "error"   => $errors,
            "user"    => $user,
            "title"   => "POO - Registration",
            "required"=> "required"
        ]);
    }


    /**
     * ユーザー一覧ページを処理します。
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
        echo "ユーザーの更新が機能します";
    }

    public function delete()
    {
        echo "ユーザーの削除が機能します";
    }
}
