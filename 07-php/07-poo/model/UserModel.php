<?php 
namespace Model;

use Classes\Abstract\AbstractModel;
use Entity\UserEntity;

class UserModel extends AbstractModel
{
    protected string $linkedClass = UserEntity::class;

    /**
     * Retrieves all users.
     *
     * @return array|false
     */
    public function getAllUsers(): array|false
    {
        $sql = $this->runQuery("SELECT idUser, username FROM users");
        return $sql->fetchAll();
    }

    /**
     * Finds a user by their email.
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
     * Finds a user by their ID.
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
     * Adds a new user to the database.
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
     * Deletes a user by their ID.
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
     * Updates a user by their ID.
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
