<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 23:41
 */
namespace App\src\DAO;

use App\src\model\User;


class UserDAO extends DAO
{
    public function getLogin($username, $password)
    {
        $sql = 'SELECT id, username, password, is_admin, status FROM users WHERE username = :username';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':username', $username, \PDO::PARAM_STR);
        $result->execute();
        if ($user = $result->fetch()) {
            $user = $this->buildObject($user);
            if ($user) {
                if ($user->getStatus() === 'active') {
                    if ($user->getPassword() === sha1($password)) {
                        $_SESSION['userId'] = $user->getId();
                        $_SESSION['username'] = $user->getUsername();
                        $_SESSION['is_admin'] = $user->getIsAdmin();
                        $_SESSION['status'] = $user->getStatus();

                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function logged()
    {
        return isset($_SESSION['auth']);
    }

    public function getUser($id =null, $username = null, $email = null)
    {
        if (isset($id)) {
            $sql = 'SELECT id, username, password, email, is_admin, status  FROM users WHERE id = :id';
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetch();
            return $this->buildObject($result);
        } elseif (isset($username)) {
            $sql = 'SELECT username FROM users WHERE username = :username';
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':username', $username, \PDO::PARAM_STR);
            $req->execute();
            return $result = $req->fetch();

        } elseif (isset($email)) {
            $sql = 'SELECT email FROM users WHERE email = :email';
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':email', $email, \PDO::PARAM_STR);
            $req->execute();
            return $result = $req->fetch();
        }
    }


    public function add($username, $email, $password, $status)
    {
        $sql = 'INSERT INTO users (username, password, email, status) VALUES (:username, :password, :email, :status)';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':username', $username, \PDO::PARAM_STR);
        $req->bindValue(':password', $password, \PDO::PARAM_STR);
        $req->bindValue(':email', $email, \PDO::PARAM_STR);
        $req->bindValue(':status', $status, \PDO::PARAM_STR);
        return $req->execute();
    }

    public function update($id, $status)
    {
        $sql = 'UPDATE users SET status = :status WHERE id = :id';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':status', $status, \PDO::PARAM_STR);
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        return $req->execute();
    }


    public function buildObject(array $data)
    {
        $user = new User();
        $user->setId($data['id'] ?? null);
        $user->setUsername($data['username'] ?? null);
        $user->setEmail($data['email'] ?? null);
        $user->setPassword($data['password'] ?? null);
        $user->setIsAdmin($data['is_admin'] ?? null);
        $user->setStatus($data['status'] ?? null);
        return $user;
    }
}