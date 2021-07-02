<?php

namespace app\controllers;

use app\models\Order;
use app\Router;
use app\controllers\AuthenticateController;

class OrderController
{
    public function index(Router $router)
    {

        $data = json_decode((file_get_contents(("php://input"))));

        $authenticateUser = new AuthenticateController();


        $user = [

            "user_id" => '',
            "user_token" => ''

        ];

        $user["id"] = $data->user_id;
        $user['user_token'] = $data->user_token;

        $res = $authenticateUser->validateUser($user, $router);

        $errors = [];

        if ($res == "true") {
            $order = new Order();


            $getOrders =  $order->getOrders();


            foreach ($getOrders as $order) {
                if ($order['deleted'] == 0) {
                    echo json_encode($order);
                }
            }
        } else {
            echo "token invalid";
            http_response_code(401);
            exit;
        }
    }



    public function create(Router $router)
    {

        $data = json_decode((file_get_contents(("php://input"))));

        $authenticateUser = new AuthenticateController();


        $user = [

            "user_id" => '',
            "user_token" => ''

        ];

        $user["id"] = $data->user_id;
        $user['user_token'] = $data->user_token;

        $res = $authenticateUser->validateUser($user, $router);


        $errors = [];


        if ($res == "true") {
            $OrderData = [
                'customer_id' => '',
                'payment_type' => '',
                'payment_status' => ''

            ];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {


                $OrderData['customer_id'] = $data->customer_id;
                $OrderData['payment_type'] = $data->payment_type;
                $OrderData['payment_status'] = $data->payment_status;


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
        } else {
            echo "token invalid";
            http_response_code(401);
            exit;
        }
    }

    public function update(Router $router)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $id = $_GET['id'] ?? null;

        $data = json_decode((file_get_contents(("php://input"))));

        $authenticateUser = new AuthenticateController();

        $user = [

            "user_id" => '',
            "user_token" => ''

        ];

        $user["id"] = $data->user_id;
        $user['user_token'] = $data->user_token;

        $res = $authenticateUser->validateUser($user, $router);

        if ($res == 'true') {


            $errors = [];


            $orderData = [
                'order_id' => '',
                'payment_type' => '',
                'payment_status' => '',
            ];



            $orderData['order_id'] = $data->order_id;
            $orderData['payment_type'] = $data->payment_type;
            $orderData['payment_status'] = $data->payment_status;

            //get image path from database
            //$productInfo = $router->db->getProductById($productData['id']);


            $order = new Order();
            $order->load($orderData);
            $errors = $order->save();
            if (empty($errors)) {
                // header('Location: /products');
                echo "product updated";
                exit;
            } else {
                var_dump($errors);
            }
        }
    }
}
