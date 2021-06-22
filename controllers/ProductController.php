<?php

namespace app\controllers;

use app\models\Product;
use app\Router;
use app\controllers\AuthenticateController;

class ProductController
{

    public function index(Router $router)
    {
        // $search = $_GET['search'] ?? '';

        $products = new Product();

        $getProducts =  $products->getProducts();

        // $products = $router->db->getProducts();

        // $router->renderView(
        //     'products/index',
        //     [
        //         'products' => $products
        //     ]
        // );
        foreach ($getProducts as $product) {
            if ($product['view_product'] == 1) {
                echo json_encode($product) . '<br>';

                echo '<p>';
            }
        }

        // echo '<pre>';
        // var_dump($products);
        // echo '</pre>';

        //echo json_encode($products);




        exit;
        // echo '<pre>';
        // var_dump($router->getRoutes);
        // echo '</pre>';
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
        }
    }

    public function delete(Router $router)
    {
        $data = json_decode((file_get_contents(("php://input"))));
        $id = $data->id ?? null;

        $product = new Product();
        $productReturned = $product->getProductById($id);

        $id = $productReturned['id'];
        if (!$id) {
            echo 'Product cannot be found';
        } else {
            $product->deleteProduct($id);
            echo 'Product deleted';
        }

        // echo $router->renderView('products/update');
    }
}
