<?php

namespace app\models;

use PDO;
use app\Database;



class Order extends Database
{
    public ?int $order_id        = null;
    public ?int $customer_id     = null;
    public ?string $payment_type    = null;
    public ?string $payment_status = null;
    public ?bool $deleted        = null;


    public function load($data)
    {
        $this->order_id          = $data['order_id'];
        $this->customer_id       = $data['customer_id'];
        $this->payment_type      = $data['payment_type'];
        $this->payment_status    = $data['payment_status'];
        $this->deleted           = $data['deleted'];

        // var_dump($this);
        // exit;
    }

    public function save()
    {

        // $db = Database::$db;
        if ($this->order_id) {

            $this->updateOrder($this);
        } else {

            $errors = [];
            if (!$this->customer_id) {
                $errors[] = 'There has to exist a customer';
            }

            if (!$this->payment_type) {
                $errors[] = 'Payment type should be mentioned';
            }

            if (empty($errors)) {
                $this->createOrder($this);
            }
            return $errors;
        }
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

        $statement = $this->pdo->prepare("INSERT INTO orders( customer_id, payment_type, payment_status, order_date, deleted ) VALUES( :customer_id , :payment_type , :payment_status, :order_date, 0)");
        $statement->bindValue(':customer_id', $order->customer_id);
        $statement->bindValue(':payment_type', $order->payment_type);
        $statement->bindValue(':payment_status', $order->payment_status);
        $statement->bindValue(':order_date', date('Y-m-d H:i:s'));
        $statement->execute();
    }


    public function updateOrder(Order $order)
    {

        $statement = $this->pdo->prepare("UPDATE orders SET payment_status=:payment_status, payment_type=:payment_type  WHERE order_id=:order_id ");

        $statement->bindValue(':payment_type', $order->payment_type);
        $statement->bindValue(':payment_status', $order->payment_status);
        $statement->bindValue(':order_id', $order->order_id);
        $statement->execute();
    }


    // public function deleteCategory($id)
    // {

    //     $statement = $this->pdo->prepare("UPDATE category SET status=0 WHERE cat_id=:id");

    //     $statement->bindValue(':id', $id);
    //     $statement->execute();
    // }
}
