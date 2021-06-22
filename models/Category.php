<?php

namespace app\models;

use PDO;
use app\Database;



class Category extends Database
{
    public ?int $id = null;
    public ?string $cat_name = null;


    public function load($data)
    {
        $this->id = $data['cat_id'] ?? null;
        $this->cat_name = $data['cat_name'];
    }

    public function save()
    {
        $errors = [];
        if (!$this->cat_name) {
            $errors[] = 'Category name is required';
        }


        if (empty($errors)) {


            // $db = Database::$db;
            if ($this->id) {

                $this->updateCategory($this);
            } else {
                $this->createCategory($this);
            }
        }
        return $errors;
    }

    public function getCategories()
    {
        //$db = Database::$db;

        $statement = $this->pdo->prepare('SELECT * FROM category ORDER BY cat_id ASC');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getCategoryById($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM category WHERE cat_id=:id');
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createCategory(Category $category)
    {
        $statement = $this->pdo->prepare("INSERT INTO category(cat_name, status) VALUES( :category, 1)");
        $statement->bindValue(':category', $category->cat_name);
        $statement->execute();
    }


    public function updateCategory(Category $category)
    {

        $statement = $this->pdo->prepare("UPDATE category SET cat_name=:cat_name WHERE cat_id=:cat_id");

        $statement->bindValue(':cat_name', $category->cat_name);
        $statement->bindValue(':cat_id', $category->id);
        $statement->execute();
    }


    public function deleteCategory($id)
    {

        $statement = $this->pdo->prepare("UPDATE category SET status=0 WHERE cat_id=:id");

        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
