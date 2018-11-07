<?php

namespace App\src\model;


class Comment
{
    private $id;
    private $username;
    private $content;
    private $dateAdded;
    private $dateAmended;
    private $postId;
    private $userId;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Comment
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
     * @return Comment
     */
    public function setUsername($username)
    {
        if (is_string($username)) {
            if (strlen($username) > 0 && strlen($username) < 30) {
                $this->username = $username;
            }
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Comment
     */
    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     * @return Comment
     */
    public function setDateAdded($dateAdded)
    {
        if (is_string($dateAdded)) {
            $this->dateAdded = $dateAdded;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateAmended()
    {
        return $this->dateAmended;
    }

    /**
     * @param mixed $dateAmended
     * @return Comment
     */
    public function setDateAmended($dateAmended)
    {
        if (is_string($dateAmended)) {
            $this->dateAmended = $dateAmended;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param mixed $postId
     * @return Comment
     */
    public function setPostId($postId)
    {
        $this->postId = (int) $postId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return Comment
     */
    public function setUserId($userId)
    {
        $this->userId = (int) $userId;
        return $this;
    }





}