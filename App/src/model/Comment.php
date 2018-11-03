<?php

namespace App\src\model;


class Comment
{
    private $id;
    private $pseudo;
    private $content;
    private $dateAdded;
    private $dateAmended;

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
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     * @return Comment
     */
    public function setPseudo($pseudo)
    {
        if (is_string($pseudo)) {
            if (strlen($pseudo) > 0 && strlen($pseudo) < 30) {
                $this->pseudo = $pseudo;
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


}