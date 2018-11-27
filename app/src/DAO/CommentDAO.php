<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 16:49
 */

namespace app\src\dao;

use app\src\model\Comment;

class CommentDAO extends DAO
{
    public function getCommentFromPost($idArt)
    {
        $sql = "SELECT id, content, date_added, post_id, author
                FROM comment  
                WHERE post_id= :id AND publish = 'valid'
                ORDER BY id DESC";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $idArt, \PDO::PARAM_INT);
        $result->execute();
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }

        return $comments;
    }



    public function getComment($idComment)
    {
        $sql = 'SELECT id, content, date_added, author, post_id
                    FROM comment 
                    WHERE comment.id = :id';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':id', $idComment, \PDO::PARAM_INT);
        $req->execute();
        $row = $req->fetch();

        return $this->buildObject($row);
    }

    public function getComments($publish)
    {
        $sql = 'SELECT id, content, date_added, author 
                FROM comment
                WHERE publish = :publish ORDER BY id';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':publish', $publish, \PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetchall();
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }

        return $comments;

    }

    public function add($comment, $idArt) : bool
    {
        $comment = $this->buildObject($comment);
        $sql = "INSERT INTO comment (content, date_added, post_id, author) VALUES (:content, :date_added, :post_id, :author)";
        $insert = $this->checkConnection()->prepare($sql);
        $insert->bindValue(':content', $comment->getContent(), \PDO::PARAM_STR);
        $insert->bindValue(':date_added', $comment->getDateAdded(), \PDO::PARAM_STR);
        $insert->bindValue(':post_id', $idArt, \PDO::PARAM_INT);
        $insert->bindValue(':author', $comment->getAuthor(), \PDO::PARAM_STR);

        return $insert->execute();
    }

    public function update($idComment, $comment = null, $publish = null) : bool
    {
        if (isset($publish)) {
            $sql = 'UPDATE comment SET publish = :publish WHERE id = :idComment';
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':idComment', $idComment, \PDO::PARAM_INT);
            $req->bindValue(':publish', $publish, \PDO::PARAM_STR);

            return $req->execute();
        } else {
            $comment = $this->buildObject($comment, true);
            $sql = "UPDATE comment SET content = :content, publish = 'waiting' WHERE id = :idComment";
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':content', $comment->getContent(), \PDO::PARAM_STR);
            $req->bindValue(':idComment', $idComment, \PDO::PARAM_INT);

            return $req->execute();
        }
    }

    public function delete($id) : bool
    {
        $sql = 'DELETE FROM comment WHERE id = :id';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        return $req->execute();
    }

    public function buildObject(array $data, $update = false): Comment
    {
        $comment = new Comment();
        $comment->setId($data['id'] ?? null);
        $comment->setAuthor($data['author'] ?? null);
        $comment->setContent($data['content'] ?? null);
        if (isset($data['date_added']) || $update === true) {
            $comment->setDateAdded($data['date_added'] ?? null);
        } else {
            $comment->setDateAdded(($dateTime = new \DateTime())->format('Y:m:d H:i:s'));
        }
        $comment->setPostId($data['post_id'] ?? null);
        $comment->setPublish($data['publish'] ?? null);

        return $comment;
    }
}