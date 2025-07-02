<?php
namespace Entity;

use Classes\Abstract\AbstractEntity;
/* 
    The entity represents a table in our database.
    It has properties whose names correspond to the columns of our table.
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
     * Check that the various fields of the entity are valid.
     *
     * @return array an array containing the errors;
     */
    public function validate():array
    {
        $errors = [];
        // username :
        if(empty($this->username))
        {
            $errors["username"] = "Please enter a username";
        }
        elseif(!preg_match("/^[a-zA-Z'\s-]{2,25}$/", $this->username))
        {
            $errors["username"] = "Please enter a valid username";
        }
        // email :
        if(empty($this->email))
        {
            $errors["email"] = "Please enter an email";
        }
        elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $errors["email"] = "Please enter a valid email";
        }
        // password et confirm password :
        if(empty($this->password) || !empty($this->plainPassword))
        {
            //password :
            if(empty($this->plainPassword))
            {
                $errors["password"] = "Please enter a password";
            }
            elseif(!preg_match(self::REGEX_PASS, $this->plainPassword))
            {
                $errors["password"] = "Please enter a valid password (all usual character types)";
            }
            //confirm password 
            if(empty($this->passwordConfirm))
            {
                $errors["passwordConfirm"] = " Please confirm your password";
            }
            elseif($this->passwordConfirm !== $this->plainPassword)
            {
                $errors["passwordConfirm"] = "Please enter the same password";
            }

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
        // Change the username only if it's different from the current one.
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
        // I use plainPassword as long as the password is not hashed.
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