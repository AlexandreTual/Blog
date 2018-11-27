<?php
namespace app\src\model;

class Comment
{
    private $id;
    private $author;
    private $content;
    private $dateAdded;
    private $postId;
    private $publish;

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
        $this->id = (int)$id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        if (is_string($author)) {
            if (strlen($author) > 0 && strlen($author) < 30) {
                $this->author = $author;
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
        $this->postId = (int)$postId;
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
        $this->userId = (int)$userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * @param mixed $publish
     * @return Comment
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
        return $this;
    }


}