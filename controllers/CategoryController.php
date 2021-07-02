<?php

namespace app\controllers;

use app\models\Category;
use app\Router;
use app\controllers\AuthenticateController;

class CategoryController
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

        if ($res == "true") {
            $category = new Category();

            $getCategory =  $category->getCategories();


            echo json_encode($getCategory);
        } else {

            echo "token invalid";
            http_response_code(401);
        }





        // echo '<pre>';
        // var_dump($router->getRoutes);
        // echo '</pre>';
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

        if ($res == "true") {

            $errors = [];
            $CategoryData = [
                'cat_name' => ''
            ];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {


                $CategoryData['cat_name'] = $data->cat_name;


                $category = new Category();
                $category->load($CategoryData);
                $errors = $category->save();
                if (empty($errors)) {

                    echo "category created";
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
        }


        // $router->renderView('products/create', [
        //     'product' => $productData,
        //     'errors' => $errors
        // ]);
    }

    public function update(Router $router)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $id = $_GET['id'] ?? null;

        $data = json_decode((file_get_contents(("php://input"))));


        $errors = [];
        if ($method === 'GET') {
        } else {

            $categoryData = [
                'cat_id' => '',
                'cat_name' => ''
            ];



            $categoryData['cat_id'] = $data->cat_id;
            $categoryData['cat_name'] = $data->cat_name;


            //get image path from database
            //$productInfo = $router->db->getProductById($productData['id']);


            $category = new Category();
            $category->load($categoryData);
            $errors = $category->save();
            if (empty($errors)) {
                // header('Location: /products');
                echo "category updated";
                exit;
            } else {
                var_dump($errors);
            }
        }
    }

    public function delete(Router $router)
    {
        $data = json_decode((file_get_contents(("php://input"))));
        $id = $data->cat_id ?? null;

        $category = new Category();
        $categoryReturned = $category->getCategoryById($id);

        $id = $categoryReturned['cat_id'];
        if (!$id) {
            echo 'Product cannot be found';
        } else {
            $category->deleteCategory($id);
            echo 'Category deleted';
        }

        // echo $router->renderView('products/update');
    }
}
