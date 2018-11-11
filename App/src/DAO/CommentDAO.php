<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/11/2018
 * Time: 16:49
 */
namespace App\src\DAO;

use App\src\model\Comment;

class CommentDAO extends DAO
{
    public function getCommentFromPost($idArt)
    {
        $sql = "SELECT comment.*, users.username AS username  
                FROM comment  
                LEFT JOIN users ON comment.user_id = users.id
                WHERE comment.post_id= :id AND publish = 'valid'
                ORDER BY comment.id DESC";
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
            $sql = 'SELECT * FROM comment WHERE comment.id = :id';
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':id', $idComment, \PDO::PARAM_INT);
            $req->execute();
            $row = $req->fetch();
            return $this->buildObject($row);
    }

    public function getComments($publish)
    {
        $sql = 'SELECT c.id, c.content, c.date_added, u.username as username 
                FROM comment as c
                LEFT JOIN users u on c.user_id = u.id
                WHERE c.publish = :publish ORDER BY id' ;
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

    public function add($comment, $idArt, $userId)
    {
        $comment = $this->buildObject($comment);
        $sql = "INSERT INTO comment (content, date_added, post_id, user_id) VALUES (:content, :date_added, :post_id, :user_id)";
        $insert = $this->checkConnection()->prepare($sql);
        $insert->bindValue(':content', $comment->getContent(), \PDO::PARAM_STR);
        $insert->bindValue(':date_added', $comment->getDateAdded(), \PDO::PARAM_STR);
        $insert->bindValue(':post_id', $idArt, \PDO::PARAM_INT);
        $insert->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        return $insert->execute();
    }

    public function update($idComment, $comment = null , $publish = null)
    {
        if (isset($publish)) {
            $sql = 'UPDATE comment SET publish = :publish WHERE id = :idComment';
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':idComment', $idComment, \PDO::PARAM_INT);
            $req->bindValue(':publish', $publish, \PDO::PARAM_STR);
            $req->execute();

        } else {
            $comment = $this->buildObject($comment, true);
            $sql = "UPDATE comment SET content = :content, date_amended = :date_amended, publish = 'waiting' WHERE id = :idComment";
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':content', $comment->getContent(), \PDO::PARAM_STR);
            $req->bindValue(':date_amended', $comment->getDateAmended(), \PDO::PARAM_STR);
            $req->bindValue(':idComment', $idComment, \PDO::PARAM_INT);
            return $req->execute();
        }
    }

    public function delete($id)
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
        $comment->setUsername($data['username'] ?? null);
        $comment->setContent($data['content'] ?? null);
        if (isset($data['date_added']) || $update === true) {
            $comment->setDateAdded($data['date_added'] ?? null);
        } else {
            $comment->setDateAdded(($dateTime = new \DateTime())->format('Y:m:d H:i:s'));
        }
        // si $update vaut true on set avec DateTime sinon on set avec les $data
        if ($update === true) {
            $comment->setDateAmended(($dateTime = new \DateTime())->format('Y:m:d H:i:s'));
        } else {
            $comment->setDateAmended($data['date_amended'] ?? null);
        }
        $comment->setPostId($data['post_id'] ?? null);
        $comment->setUserId($data['user_id'] ?? null);
        $comment->setPublish($data['publish'] ?? null);
        return $comment;
    }



}