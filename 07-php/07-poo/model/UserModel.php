<?php 
namespace Model;

use Classes\Abstract\AbstractModel;
use Entity\UserEntity;

class UserModel extends AbstractModel
{
    protected string $linkedClass = UserEntity::class;

    /**
     * すべてのユーザーを取得します。
     *
     * @return array|false
     */
    public function getAllUsers(): array|false
    {
        $sql = $this->runQuery("SELECT idUser, username FROM users");
        return $sql->fetchAll();
    }

    /**
     * メールアドレスでユーザーを検索します。
     *
     * @param string $email
     * @return UserEntity|false
     */
    function getOneUserByEmail(string $email): UserEntity|false
    {
        $sql = $this->prepareQuery("SELECT * FROM users WHERE email = :em");
        $sql->execute(["em"=>$email]);
        return $sql->fetch();
    }

    /**
     * IDでユーザーを検索します。
     *
     * @param integer $id
     * @return UserEntity|false
     */
    function getOneUserById(int $id): UserEntity|false
    {
        $sql = $this->prepareQuery("SELECT * FROM users WHERE idUser = ?");
        $sql->execute([$id]);
        return $sql->fetch();
    }

    /**
     * ユーザーをデータベースに追加します。
     *
     * @param UserEntity $user
     * @return void
     */
    function addUser(UserEntity $user): void
    {
        $sql = $this->prepareQuery("INSERT INTO users(username, email, password) VALUES (?,?,?)");
        $sql->execute([$user->getUsername(), $user->getEmail(), $user->getPassword()]);
    }

    /**
     * IDでユーザーを削除します。
     *
     * @param integer $id
     * @return void
     */
    function deleteUserById(int $id):void
    {
        $sql = $this->prepareQuery("DELETE FROM users WHERE idUser = ?");
        $sql->execute([$id]);
    }

    /**
     * IDでユーザーを更新します。
     *
     * @param UserEntity $user
     * @return void
     */
    function updateUserById(UserEntity $user):void
    {
        $sql = $this->prepareQuery("UPDATE users SET username = :us, email = :em, password = :mdp WHERE idUser = :id");
        $sql->execute([
            "us"=>$user->getUsername(),
            "em"=>$user->getEmail(),
            "mdp"=>$user->getPassword(),
            "id"=>$user->getIdUser()
        ]);
    }
}
