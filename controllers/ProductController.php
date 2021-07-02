<?php

namespace app\controllers;

use app\models\Product;
use app\Router;
use app\controllers\AuthenticateController;

class ProductController
{

    public function index(Router $router)
    {

        if (!isset($_GET['page'])) {

            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $results_per_page = $_GET['results_per_page'];



        $products = new Product();

        $getProducts =  $products->getProducts($page, $results_per_page);


        // print_r($getProducts);

        echo json_encode($getProducts, true);
        http_response_code(200);
    }

    public function create(Router $router)
    {

        $data = json_decode((file_get_contents(("php://input"))));

        $authenticateUser = new AuthenticateController();

        $errors = [];
        $user = [

            "user_id" => '',
            "user_token" => ''

        ];

        $productData = [
            'title' => '',
            'description' => '',
            'price' => '',
            'image' => ''
        ];

        $user["id"] = $data->user_id;
        $user['user_token'] = $data->user_token;

        $res = $authenticateUser->validateUser($user, $router);

        if ($res == "true") {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                header("Content-Type: application/json; charset=UTF-8");

                $productData['title'] = $data->title;
                $productData['description'] = $data->description;
                $productData['price'] = $data->price;
                $productData['encodedImage'] = $data->image;

                $product = new Product();
                $product->load($productData);
                $errors = $product->save();
                if (empty($errors)) {

                    echo "product created";
                    http_response_code(201);
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

        $errors = [];
        if ($method === 'GET') {


            if (!$id) {
                header('Location: /products');
                exit;
            }

            $product = new Product();
            $productData = $product->getProductById($id);
            $router->renderView(
                'products/update',
                [
                    'product' => $productData,
                    'errors' => $errors,
                ]

            );
        } else {


            if ($res == "true") {
                $productData = [
                    'id' => '',
                    'title' => '',
                    'description' => '',
                    'price' => '',
                ];



                $productData['id'] = $data->id;
                $productData['title'] = $data->title;
                $productData['description'] = $data->description;
                $productData['price'] = $data->price;

                //get image path from database
                //$productInfo = $router->db->getProductById($productData['id']);


                $product = new Product();
                $product->load($productData);
                $errors = $product->save();
                if (empty($errors)) {
                    // header('Location: /products');
                    echo "product updated";
                    exit;
                } else {
                    var_dump($errors);
                }
            } else {

                echo "token invalid";
                http_response_code(401);
                exit;
            }
        }
    }

    public function delete(Router $router)
    {
        $data = json_decode((file_get_contents(("php://input"))));
        $id = $data->id ?? null;

        $authenticateUser = new AuthenticateController();

        $user = [

            "user_id" => '',
            "user_token" => ''

        ];

        $user["id"] = $data->user_id;
        $user['user_token'] = $data->user_token;

        $res = $authenticateUser->validateUser($user, $router);

        if ($res == "true") {
            $product = new Product();
            $productReturned = $product->getProductById($id);

            $id = $productReturned['id'];
            if (!$id) {
                echo 'Product cannot be found';
            } else {
                $product->deleteProduct($id);
                echo 'Product deleted';
            }
        } else {

            echo "token invalid";
            http_response_code(401);
            exit;
        }



        // echo $router->renderView('products/update');
    }
}
