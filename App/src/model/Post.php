<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:08
 */

namespace App\src\model;

class Post
{
    private $id;
    private $title;
    private $chapo;
    private $content;
    private $author;
    private $date_added;
    private $date_amended;
    private $publish;
    private $comments_status_number;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Post
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Post
     */
    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * @param mixed $chapo
     * @return Post
     */
    public function setChapo($chapo)
    {
        if (is_string($chapo)) {
            $this->chapo = $chapo;
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
     * @return Post
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
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Post
     */
    public function setAuthor($author)
    {
        if (is_string($author)) {
        $this->author = $author;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->date_added;
    }

    /**
     * @param mixed $date_added
     * @return Post
     */
    public function setDateAdded($date_added)
    {
        if (is_string($date_added)) {
            $this->date_added = $date_added;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateAmended()
    {
        return $this->date_amended;
    }

    /**
     * @param mixed $date_amended
     * @return Post
     */
    public function setDateAmended($date_amended)
    {
        if (is_string($date_amended)) {
            $this->date_amended = $date_amended;
        }
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
     * @return Post
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentsStatusNumber()
    {
        return $this->comments_status_number;
    }

    /**
     * @param mixed $comments_status_number
     * @return Post
     */
    public function setCommentsStatusNumber($comments_status_number)
    {
        $this->comments_status_number = $comments_status_number;
        return $this;
    }






}
