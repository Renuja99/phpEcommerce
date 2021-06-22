<?php

namespace app\controllers;

use app\models\Order;
use app\Router;

class OrderController
{
    public function index(Router $router)
    {
        // $search = $_GET['search'] ?? '';

        $order = new Order();

        $getOrders =  $order->getOrders();


        foreach ($getOrders as $order) {
            if ($order['status'] == 1) {
                echo json_encode($order) . '<br>';

                echo '<p>';
            }
        }
    }

    public function create(Router $router)
    {

        $data = json_decode((file_get_contents(("php://input"))));


        $errors = [];
        $OrderData = [
            'user_id' => '',
            'product_ids' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            header("Content-Type: application/json; charset=UTF-8");



            $OrderData['user_id'] = $data->user_id;


            $OrderData['product_ids'] = $data->product_ids;


            //explode(' ', $OrderData['product_ids']);  CONVERT STRING TO ARRAY
            $order = new Order();
            $order->load($OrderData);
            $errors = $order->save();
            if (empty($errors)) {

                echo "ORDER created";
                // header('Location: /products');
                exit;
            } else {
                var_dump($errors);

                exit;
            }
        }
    }
}
