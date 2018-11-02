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
    private $content;
    private $author;
    private $date_added;
    private $date_amended;

    public function __construct()
    {
        $this->setDateAdded(($dateTime = new \DateTime())->format('d/m/Y H:i'));
    }

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
        $this->title = (string) $title;
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
        $this->content = (string) $content;
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
        $this->author = (string) $author;
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
        $this->date_added = $date_added;
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
        $this->date_amended = $date_amended;
        return $this;
    }


}
