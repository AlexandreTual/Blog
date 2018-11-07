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
        $sql = 'SELECT * FROM users WHERE username = :username';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':username', $username, \PDO::PARAM_STR);
        $result->execute();
        if ($user = $result->fetch()) {
            $user = $this->buildObject($user);
            if ($user) {
                if ($user->getPassword() === sha1($password)) {
                    $_SESSION['userId'] = $user->getId();
                    $_SESSION['username'] = $user->getUsername();
                    $_SESSION['is_admin'] = $user->getIsAdmin();
                    return true;
                }
            }
        }
        return false;
    }

    public function logged()
    {
        return isset($_SESSION['auth']);
    }


    public function buildObject(array $data)
    {
        $user = new User();
        $user->setId($data['id'] ?? null);
        $user->setUsername($data['username'] ?? null);
        $user->setPassword($data['password'] ?? null);
        $user->setIsAdmin($data['is_admin'] ?? null);
        return $user;
    }
}