<?php

namespace app\models;

use PDO;
use app\Database;



class Order extends Database
{
    public ?int $order_id = null;
    public ?string $user_id = null;
    public ?string $product_ids = null;


    public function load($data)
    {
        $this->order_id = $data['order_id'];
        $this->user_id = $data['user_id'];
        $this->product_ids = $data['product_ids'];
    }

    public function save()
    {
        $errors = [];
        if (!$this->product_ids) {
            $errors[] = 'Products should be selected to place an order';
        }


        if (empty($errors)) {


            // $db = Database::$db;
            if ($this->id) {

                // $this->updateOrder($this);
            } else {
                $this->createOrder($this);
            }
        }
        return $errors;
    }

    public function getOrders()
    {


        $statement = $this->pdo->prepare('SELECT * FROM orders ORDER BY order_id ASC');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    // public function getOrderById($id)
    // {
    //     $statement = $this->pdo->prepare('SELECT * FROM category WHERE order_id=:id');
    //     $statement->bindValue(':id', $id);
    //     $statement->execute();
    //     return $statement->fetch(PDO::FETCH_ASSOC);
    // }

    public function createOrder(Order $order)
    {
        $statement = $this->pdo->prepare("INSERT INTO orders(user_id, product_ids, date_purchased, status ) VALUES( :user_id, :product_ids, :date_purchased, 1)");
        $statement->bindValue(':user_id', $this->user_id);
        $statement->bindValue(':product_ids', $this->product_ids);
        $statement->bindValue(':date_purchased', date('Y-m-d H:i:s'));
        $statement->execute();
    }


    // public function updateOrder(Order $order)
    // {

    //     $statement = $this->pdo->prepare("UPDATE orders SET cat_name=:cat_name WHERE cat_id=:cat_id");

    //     $statement->bindValue(':cat_name', $category->cat_name);
    //     $statement->bindValue(':cat_id', $category->id);
    //     $statement->execute();
    // }


    // public function deleteCategory($id)
    // {

    //     $statement = $this->pdo->prepare("UPDATE category SET status=0 WHERE cat_id=:id");

    //     $statement->bindValue(':id', $id);
    //     $statement->execute();
    // }
}
