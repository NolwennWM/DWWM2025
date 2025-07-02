<?php
namespace Entity;

use Classes\Abstract\AbstractEntity;
/* 
    このエンティティはデータベース内のテーブルを表します。
    プロパティの名前はテーブルのカラムに対応しています。
*/
class UserEntity extends AbstractEntity
{
    private int $idUser = 0;
    private string $username = "";
    private string $email = "";
    private string $password = "";
    private ?string $passwordConfirm = NULL;
    private ?string $plainPassword = NULL;
    private string $createdAt = "";

    private const REGEX_PASS = "/^(?=.*[!?@#$%^&*+-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/";
    /**
     * エンティティの各フィールドが有効かどうかを確認します。
     *
     * @return array エラーを含む配列
     */
    public function validate():array
    {
        $errors = [];
        // username :
        if(empty($this->username))
        {
            $errors["username"] = "ユーザー名を入力してください";
        }
        elseif(!preg_match("/^[a-zA-Z'\s-]{2,25}$/", $this->username))
        {
            $errors["username"] = "有効なユーザー名を入力してください";
        }
        // email :
        if(empty($this->email))
        {
            $errors["email"] = "メールアドレスを入力してください";
        }
        elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $errors["email"] = "有効なメールアドレスを入力してください";
        }
        // password と confirm password :
        if(empty($this->password) || !empty($this->plainPassword))
        {
            //password :
            if(empty($this->plainPassword))
            {
                $errors["password"] = "パスワードを入力してください";
            }
            elseif(!preg_match(self::REGEX_PASS, $this->plainPassword))
            {
                $errors["password"] = "有効なパスワードを入力してください（通常使用される文字をすべて含む必要があります）";
            }
            //confirm password 
            if(empty($this->passwordConfirm))
            {
                $errors["passwordConfirm"] = "パスワードを確認してください";
            }
            elseif($this->passwordConfirm !== $this->plainPassword)
            {
                $errors["passwordConfirm"] = "同じパスワードを入力してください";
            }
            // エラーがなければパスワードをハッシュ化し、一時的なフィールドを初期化する
            if(empty($errors))
            {
                $this->password = password_hash($this->plainPassword, PASSWORD_DEFAULT);
                $this->plainPassword = "";
                $this->passwordConfirm = "";
            }
        }
        return $errors;
    }
    // Setter et Getter :
    # id :
    public function getIdUser(): int
    {
        return $this->idUser;
    }
    public function setIdUser(int $id):void
    {
        $this->idUser = (int)$id;
    }
    # username :
    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(string $username): void
    {
        $username = $this->cleanData($username);
        //  現在のユーザー名と異なる場合のみ、ユーザー名を変更する
        if($username !== $this->username)
        {
            $this->username = $username;
        }
    }
    #email
    public function getEmail():string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $email = $this->cleanData($email);
        if($email !== $this->email)
        {
            $this->email = $email;
        }
    }
    #password
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $pass): void
    {
        $pass = trim($pass);
        // パスワードがハッシュ化されていない間は plainPassword を使用する
        $this->plainPassword = $pass;
    }
    #confirm password 
    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }
    public function setPasswordConfirm(string $passwordConfirm):void
    {
        $this->passwordConfirm = trim($passwordConfirm);
    }
    #created At
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}