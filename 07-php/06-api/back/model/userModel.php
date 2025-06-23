<?php 
require __DIR__."/../../../ressources/service/_pdo.php";
$pdo = connexionPDO();

/**
 * 全ユーザーを取得する。
 *
 * @return array
 */
function getAllUsers(): array{
    global $pdo;
    $sql = $pdo->query("SELECT idUser, username FROM users");
    return $sql->fetchAll();
}

/**
 * メールアドレスでユーザーを1人取得する。
 *
 * @param string $email
 * @return array|false
 */
function getOneUserByEmail(string $email): array|false{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM users WHERE email=:em");
    $sql->execute(["em" => $email]);
    return $sql->fetch();
}

/**
 * IDでユーザーを1人取得する。
 *
 * @param int $id
 * @return array|false
 */
function getOneUserById(int $id): array|false{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM users WHERE idUser=?");
    $sql->execute([$id]);
    return $sql->fetch();
}

/**
 * 新しいユーザーをデータベースに追加する。
 *
 * @param string $us
 * @param string $em
 * @param string $pass
 * @return array
 */
function addUser(string $us, string $em, string $pass): array{
    global $pdo;
    $sql = $pdo->prepare(
        "INSERT INTO users(username, email, password) 
        VALUES(?, ?, ?)"
    );
    $sql->execute([$us,$em,$pass]);
    
    $id = $pdo->lastInsertId();
    return getOneUserById($id);
}

/**
 * IDでユーザーを削除する。
 *
 * @param int $id
 * @return void
 */
function deleteUserById(int $id):void{
    global $pdo;
    $sql = $pdo->prepare("DELETE FROM users WHERE idUser=?");
    $sql->execute([$id]);
}

/**
 * IDでユーザー情報を更新する。
 *
 * @param string $username
 * @param string $email
 * @param string $password
 * @param int $id
 * @return array
 */
function updateUserById(string $username, string $email, string $password, int $id):array{
    global $pdo;
    $sql = $pdo->prepare("UPDATE users SET 
            username=:us, 
            email = :em,
            password = :mdp
            WHERE idUser = :id"
    );
    $sql->execute([
        "id" => $id,
        "em" => $email,
        "mdp" => $password,
        "us" => $username
    ]);
    return getOneUserById($id);
}