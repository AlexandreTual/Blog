<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15/11/2018
 * Time: 15:17
 */

namespace app\src\dao;

use app\src\model\Category;

class CategoryDAO extends DAO
{
    public function getCategory()
    {
        $sql = 'SELECT id, name FROM category ORDER BY id';
        $req = $this->checkConnection()->query($sql);
        $result = $req->fetchall();
        $category = [];
        foreach ($result as $row) {
            $categoryId = $row['id'];
            $category[$categoryId] = $this->buildObject($row);
        }
        return $category;
    }

    public function add($post)
    {
        $category = $this->buildObject($post);
        $sql = 'INSERT INTO category (name) VALUES (:name)';
        $req = $this->checkConnection()->prepare($sql);
        $req->bindValue(':name', $category->getName(), \PDO::PARAM_STR);
        return $req->execute();
    }

    public function buildObject(array $data): Category
    {
        $category = new Category();
        $category->setId($data['id'] ?? null);
        $category->setName($data['name'] ?? null);

        return $category;
    }

}