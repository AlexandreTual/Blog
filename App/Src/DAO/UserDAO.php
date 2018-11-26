<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 23:41
 */

namespace app\src\dao;

use app\src\model\User;


class UserDAO extends DAO
{
    public function getLogin($username, $password)
    {
        $sql = 'SELECT id, username, password, quality, status FROM user WHERE username = :username';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':username', $username, \PDO::PARAM_STR);
        $result->execute();
        if ($user = $result->fetch()) {
            $user = $this->buildObject($user);
            if ($user) {
                if ($user->getStatus()) {
                    if ($user->getPassword() === sha1($password)) {
                        $_SESSION['userId'] = $user->getId();
                        $_SESSION['username'] = $user->getUsername();
                        $_SESSION['quality'] = $user->getquality();
                        $_SESSION['status'] = $user->getStatus();

                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function getUser($column, $info)
    {
        $sql = 'SELECT id, username, password, email, quality, status, validation_key  FROM user';
        $sql .= ' WHERE ' . $column . ' = :'. $column;
        $req = $this->checkConnection()->prepare($sql);
        if (is_int($info)) {
            $req->bindValue(':'. $column , $info, \PDO::PARAM_INT);
        } elseif (is_string($info)) {
            $req->bindValue(':' . $column , $info, \PDO::PARAM_STR);
        } elseif (is_bool($info)) {
            $req->bindValue(':' . $column , $info, \PDO::PARAM_BOOL);
        }
        $req->execute();
        $result = $req->fetch();
        if (!$result) {
            return false;
        } else {
            return $this->buildObject($result);
        }
    }

    public function getAllUser()
    {
        $sql = 'SELECT id, username, quality, status FROM user ORDER BY id';
        $req = $this->checkConnection()->query($sql);
        $result = $req->fetchall();
        $users = [];
        foreach ($result as $row) {
            $userId = $row['id'];
            $users[$userId] = $this->buildObject($row);
        }
        return $users;
    }

    public function add($username, $email, $password, $validationKey) : bool
    {
        $sql = 'INSERT INTO user (username, password, email, validation_key) 
                VALUES (:username, :password, :email, :validation_key)';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':username', $username, \PDO::PARAM_STR);
        $req->bindValue(':password', $password, \PDO::PARAM_STR);
        $req->bindValue(':email', $email, \PDO::PARAM_STR);
        $req->bindValue(':validation_key', $validationKey, \PDO::PARAM_STR);

        return $req->execute();
    }

    public function update($id, $password, $email, $quality, $status, $validationKey)
    {
        $sql = 'UPDATE user 
                SET password = :password, email = :email, quality = :quality, status = :status,
                validation_key = :validation_key 
                WHERE id = :id';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':password', $password, \PDO::PARAM_STR);
        $req->bindValue(':email', $email, \PDO::PARAM_STR);
        $req->bindValue(':quality', $quality, \PDO::PARAM_STR);
        $req->bindValue(':status', $status, \PDO::PARAM_BOOL);
        $req->bindValue(':validation_key', $validationKey, \PDO::PARAM_STR);
        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        return $req->execute();
    }

    public function addNewsletter($email)
    {
        $sql = 'INSERT INTO newsletter (email) VALUES (:email)';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':email', $email, \PDO::PARAM_STR);

        return $req->execute();
    }

    public function getNewsletter($email)
    {
        $sql = 'SELECT email FROM newsletter WHERE email = :email';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':email', $email, \PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch();
        if ($result) {
            return true;
        }
        return false;
    }


    public function buildObject(array $data): User
    {
        $user = new User();
        $user->setId($data['id'] ?? null);
        $user->setUsername($data['username'] ?? null);
        $user->setEmail($data['email'] ?? null);
        $user->setPassword($data['password'] ?? null);
        $user->setquality($data['quality'] ?? null);
        $user->setStatus($data['status'] ?? null);
        $user->setValidationKey($data['validation_key'] ?? null);

        return $user;
    }
}