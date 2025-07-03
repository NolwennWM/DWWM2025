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
    /**
     * プロフィール更新ページを処理します。
     *
     * @return void
     */
    public function update()
    {
        // プロフィールを更新するにはログインが必要です。
        $this->shouldBeLogged(true, "/07-poo");

        // ユーザー情報を取得する。
        $user = $this->db->getOneUserById((int)$_SESSION["idUser"]);

        $errors = [];

        // フォームが送信された場合：
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userForm']))
        {
            // 現在のメールアドレスを取得する。
            $oldEmail = $user->getEmail();

            // 新しいデータでユーザーオブジェクトを埋める。
            $user->setUsername($_POST["username"] ?? "");
            $user->setEmail($_POST["email"] ?? "");
            $user->setPassword($_POST["password"] ?? "");
            $user->setPasswordConfirm($_POST["passwordConfirm"] ?? "");

            // 入力をバリデーション。
            $errors = $user->validate();

            // 新しいメールアドレスが入力されたか確認。
            if(!empty($_POST["email"]) && trim($_POST["email"]) !== $oldEmail)
            {
                // 他のユーザーが既にこのメールアドレスを使っていないか確認。
                $exist = $this->db->getOneUserByEmail($user->getEmail());
                if($exist)
                {
                    $errors["email"] = "このメールアドレスは既に使用されています。";
                }
            } // メール確認の終了

            // エラーがなければデータベースを更新。
            if(empty($errors))
            {
                $this->db->updateUserById($user);

                // 確認メッセージをセット。
                $this->setFlash("プロフィールが更新されました。");

                // ユーザーをリダイレクト。
                header("Location: /07-poo");
                exit;
            }
        } // フォーム送信の確認終了

        // ビューを読み込む。
        $this->render("user/update.php", [
            "error" => $errors,
            "user" => $user,
            "title" => "POO - Profile Update"
        ]);
    }

    /**
     * アカウント削除ページを処理します。
     *
     * @return void
     */
    public function delete()
    {
        // ユーザーがログインしていない場合はリダイレクト。
        $this->shouldBeLogged(true, "/07-poo");

        // 現在ログインしているユーザーのアカウントを削除する。
        $this->db->deleteUserById((int)$_SESSION["idUser"]);

        // ユーザーをログアウトさせる。
        session_destroy();
        unset($_SESSION);
        setCookie("PHPSESSID", "", time()-3600);

        // 数秒後にリダイレクト。
        header("refresh: 5;url=/07-poo");

        // 確認メッセージを表示。
        $this->render("user/delete.php", ["title" => "POO - Account Deletion"]);
    }
}