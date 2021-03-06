<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 17:00
 */

namespace app\src\dao;

use app\src\model\Post;

class PostDAO extends DAO
{
    /**
     * @param $publish
     * @param null $category
     * @param bool $comments_number
     * @param null $userId
     * @return array
     * @throws \Exception
     */
    public function getAll($publish, $category = null, $comments_number = false)
    {
        $sql = "
          SELECT p.id, p.title, p.chapo, p.content, p.date_added, p.date_amended, p.publish, c.name as category, u.username as author
          " . ($comments_number ? ", (SELECT COUNT(c.id) FROM comment as c WHERE c.post_id = p.id) as comment_count" : "") . "  
          FROM post as p 
          LEFT JOIN user u on p.user_id = u.id
          LEFT JOIN category c on p.category_id = c.id
          WHERE p.publish <> :publish";
        if (isset($category)) {
            $sql.= " AND category_id = :category";
        } else {
            $sql.= " ORDER BY p.id DESC";
        }
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':publish', $publish, \PDO::PARAM_STR);
        if (isset($category)) {
            $req->bindValue(':category', $category, \PDO::PARAM_INT);
        }
        $req->execute();
        $result = $req->fetchall();
        $posts = [];
        foreach ($result as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->buildObject($row);
        }

        return $posts;
    }

    public function getLastPost($limitNumber)
    {
        $sql = "SELECT id, title FROM post WHERE publish = 'published' ORDER BY id DESC LIMIT :number";
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':number', $limitNumber, \PDO::PARAM_INT);
        $req->execute();
        $req->execute();
        $result = $req->fetchall();
        $posts = [];
        foreach ($result as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->buildObject($row);
        }

        return $posts;
    }

    /**
     * @param $idArt
     * @return Post|bool
     */
    public function getPost($idArt)
    {
        $req = 'SELECT p.id, p.title, p.chapo, p.content, p.date_added, p.date_amended, p.publish, c.name as category, u.username as author
                FROM post p 
                LEFT JOIN user u on p.user_id = u.id
                LEFT JOIN category c on p.category_id = c.id
                WHERE p.id = :id';
        $result = $this->checkConnection()->prepare($req);
        $result->bindValue(':id', $idArt, \PDO::PARAM_INT);
        $result->execute();
        if ($row = $result->fetch()) {
            return $this->buildObject($row);
        }

        return false;
    }

    /**
     * @param $post
     * @param $userId
     * @return string
     */
    public function add($post, $userId) : string
    {
        $userId = (int)$userId;
        $post = $this->buildObject($post);
        $category  = (int)$post->getCategory();
        $sql = 'INSERT INTO post (title, chapo, content, date_added, category_id, user_id) 
                VALUES (:title, :chapo, :content, :date_added, :category, :user_id)';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':title', $post->getTitle(), \PDO::PARAM_STR);
        $req->bindValue(':chapo', $post->getChapo(), \PDO::PARAM_STR);
        $req->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
        $req->bindValue(':date_added', $post->getDateAdded(), \PDO::PARAM_STR);
        $req->bindValue(':category', $category, \PDO::PARAM_INT);
        $req->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $req->execute();

        return $this->checkConnection()->lastInsertId();
    }

    /**
     * @param $id
     * @param $post
     * @param null $publish
     * @return bool
     */
    public function update($postId, $post, $publish = null) : bool
    {
        if (isset($post)) {
            $post = $this->buildObject($post, true);
            $category = (int)$post->getCategory();
        }
        if (isset($publish)) {
            // requète permettant de modifier l'etat de publication.
            $sql = 'UPDATE post SET publish= :publish WHERE id = :id';

            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':publish', $publish, \PDO::PARAM_STR);
            $req->bindValue(':id', $postId, \PDO::PARAM_INT);

            return $req->execute();
        } else {
            // requète permettant de modifier le contenu de l'article.
            $sql = 'UPDATE post 
                SET title = :title, chapo = :chapo, content = :content, date_amended = :date_amended, category_id = :category_id 
                WHERE id = :id';
            $req = $this->checkConnection()->prepare($sql);
            $req->bindValue(':title', $post->getTitle(), \PDO::PARAM_STR);
            $req->bindValue(':chapo', $post->getChapo(), \PDO::PARAM_STR);
            $req->bindValue(':content', $post->getContent(), \PDO::PARAM_STR);
            $req->bindValue(':date_amended', $post->getDateAmended(), \PDO::PARAM_STR);
            $req->bindValue(':category_id', $category, \PDO::PARAM_INT);
            $req->bindValue(':id', $postId, \PDO::PARAM_INT);

            return $req->execute();
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($postId) : bool
    {
        $sql = 'DELETE FROM post WHERE id = :id';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':id', $postId, \PDO::PARAM_INT);

        return $req->execute();
    }

    /**
     * @param array $data
     * @param bool $updateContent
     * @return Post
     * @throws \Exception
     */
    public function buildObject(array $data, $updateContent = false): Post
    {
        $post = new Post();
        $post->setId($data['id'] ?? null);
        $post->setTitle($data['title'] ?? null);
        $post->setChapo($data['chapo'] ?? null);
        $post->setContent($data['content'] ?? null);
        $post->setAuthor($data['author'] ?? null);
        $post->setCategory($data['category'] ?? null);
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
        $post->setUserId($data['user_id'] ?? null);

        return $post;
    }
}