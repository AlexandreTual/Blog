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
        $sql = 'SELECT id, pseudo, content, date_added, date_amended FROM comment WHERE comment.post_id= :id ORDER BY id DESC';
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

    public function buildObject(array $data) {
        $comment = new Comment();
        $comment->setId($data['id'] ?? null);
        $comment->setPseudo($data['pseudo'] ?? null);
        $comment->setContent($data['content'] ?? null);
        if (isset($data['date_added'])) {
            $comment->setDateAdded($data['date_added'] ?? null);
        } else {
            $comment->setDateAdded(($dateTime = new \DateTime())->format('d/m/Y H:i'));
        }
        $comment->setDateAmended($data['date_amended'] ?? null);
        return $comment;
    }

}