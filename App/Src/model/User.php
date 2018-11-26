<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04/11/2018
 * Time: 16:35
 */

namespace app\src\model;

class User
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $quality;
    private $status;
    private $validationKey;

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
        $this->id = (int)$id;
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
    }

    /**
     * @return mixed
     */
    public function getquality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $is
     * @return User
     */
    public function setquality($quality)
    {
        if (is_string($quality)) {
            $this->quality = $quality;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return User
     */
    public function setStatus($status)
    {
        $status = (bool)$status;
        if (is_bool($status)) {
            $this->status = $status;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidationKey()
    {
        return $this->validationKey;
    }

    /**
     * @param mixed $validationKey
     * @return User
     */
    public function setValidationKey($validationKey)
    {
        $this->validationKey = $validationKey;
        return $this;
    }




}