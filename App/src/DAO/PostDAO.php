<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:00
 */
namespace App\src\DAO;

use App\src\model\Post;

class PostDAO extends DAO
{
    public function getAll($publish, $comments_number = false) {
        $sql = "
          SELECT p.id, p.title, p.chapo, p.content, p.author, p.date_added, p.date_amended, p.publish
          ".($comments_number ? ", (SELECT COUNT(c.id) FROM comment as c WHERE c.post_id = p.id) as comment_count" : "")."  
          FROM posts as p WHERE p.publish <> :publish ORDER BY p.id DESC";
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':publish', $publish, \PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetchall();
        $posts = [];
        foreach ($result as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->buildObject($row);
        }
        return $posts;
    }

    public function getPost($idArt)
    {
        $req = 'SELECT * FROM posts WHERE id = :id';
        $result = $this->checkConnection()->prepare($req);
        $result->bindValue(':id', $idArt, \PDO::PARAM_INT);
        $result->execute();
        if ($row = $result->fetch()) {
            return $this->buildObject($row);
        } /*else {
            return $message =  'Aucun article existant avec cet identifiant';
        }*/
    }

    public function add($post)
    {
        $post = $this->buildObject($post);

        $sql = 'INSERT INTO posts (title, chapo, content, author, date_added) 
                VALUES (:title, :chapo, :content, :author, :date_added)';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':title', $post->getTitle(), \PDO::PARAM_STR);
        $req->bindValue(':chapo', $post->getChapo(), \PDO::PARAM_STR);
        $req->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
        $req->bindValue(':author', $post->getAuthor(), \PDO::PARAM_STR);
        $req->bindValue(':date_added', $post->getDateAdded(), \PDO::PARAM_STR);
        $req->execute();
        return $this->checkConnection()->lastInsertId();
    }

    public function update($id, $post, $publish = null)
    {
        if (isset($post)) {
            $post = $this->buildObject($post, true);
        }

        if (isset($publish)) {
            // requète permettant de modifier l'etat de publication.
            $sql = 'UPDATE posts SET publish= :publish WHERE id = :id';

            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':publish', $publish, \PDO::PARAM_STR);
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
            return $req->execute();
        } else {
            // requète permettant de modifier le contenu de l'article.
            $sql = 'UPDATE posts 
                SET title = :title, chapo = :chapo, content = :content, author = :author, date_amended = :date_amended 
                WHERE id = :id';
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':title', $post->getTitle(), \PDO::PARAM_STR);
            $req->bindValue(':chapo', $post->getChapo(), \PDO::PARAM_STR);
            $req->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
            $req->bindValue(':author', $post->getAuthor(), \PDO::PARAM_STR);
            $req->bindValue(':date_amended', $post->getDateAmended(), \PDO::PARAM_STR);
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
            return $req->execute();
        }
        // on execute l'une ou l'autre des requète en fonction du paramètre publish et on retourne l'id de larticle.

    }

    public function delete($id)
    {
        $sql = 'DELETE FROM posts WHERE id = :id';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        return $post = $req->execute();
    }



    public function buildObject(array $data, $updateContent = false): Post
    {
        $post = new Post();
        $post->setId($data['id'] ?? null);
        $post->setTitle($data['title'] ?? null);
        $post->setChapo($data['chapo'] ?? null);
        $post->setContent($data['content'] ?? null);
        $post->setAuthor($data['author'] ?? null);
        if (isset($data['date_added']) OR $updateContent === true) {
            $post->setDateAdded($data['date_added'] ?? null);
        } else {
            $post->setDateAdded(($dateTime = new \DateTime())->format('Y:m:d H:i:s'));
        }
        // si $update vaut true on set avec DateTime sinon on set avec les $data
        if ($updateContent === true) {
            $post->setDateAmended(($dateTime = new \DateTime())->format('Y:m:d H:i:s'));
        } else {
            $post->setDateAmended($data['date_amended'] ?? null);
        }
        $post->setPublish($data['publish'] ?? null);
        $post->setCommentsStatusNumber($data['comment_count'] ?? null);

        return $post;
    }
}