<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04/11/2018
 * Time: 16:35
 */
namespace App\src\model;

class User
{
    private $id;
    private $username;
    private $password;
    private $is_admin;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return User
     */
    public function setUsername($username)
    {
        if (is_string($username)) {
            $this->username = $username;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->password = $password;
        }
        return $this;
    }/**
 * @return mixed
 */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }/**
     * @param mixed $is
     * @return User
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = (int) $is_admin;
        return $this;
    }


}