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
    public function getAll() {
        $sql = "SELECT * FROM posts ORDER BY id DESC";
        $result = $this->checkConnection()->query($sql);
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
        } else {
            return $message =  'Aucun article existant avec cet identifiant';
        }
    }

    public function buildObject($data)
    {
        $post = new Post();
        $post->setId($data['id'] ?? null);
        $post->setTitle($data['title'] ?? null);
        $post->setContent($data['content'] ?? null);
        $post->setAuthor($data['author'] ?? null);
        $post->setDateAmended($data['date_amended'] ?? null);
        return $post;
    }
}