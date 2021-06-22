<?php

namespace app\controllers;

use app\Router;

class AuthenticateController
{


    public function index(Router $router)
    {

        $router->renderView(
            'index',
            []
        );
    }

    public function dashboard(Router $router)
    {

        $router->renderView(
            'dashboard',
            []
        );
    }


    public function authenticateUser(Router $router)
    {
        $errors = [];

        $userInfo = [
            'username' => '',
            'password' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userInfo['username'] = $_POST['username'];
            $unhashedPassword = $_POST['password'];
            $userInfo['password'] = md5($unhashedPassword);

            $authenticateUser = $router->db->authenticateUser($userInfo);
        }

        // echo '<pre>';
        // var_dump($authenticateUser["userType_id"]);
        // echo '</pre>';
        // exit;



        if ($authenticateUser) {

            if ($authenticateUser["userType_id"] === "1") {
                $router->renderView(
                    'dashboard',
                    []
                );
            } elseif ($authenticateUser["userType_id"] === "2") {
                echo "User is an admin";
            } else {
                echo "User is not an admin";
            };
        } else {

            $errors[] = "Password invalid";

            $router->renderView(
                'index',
                [
                    'errors' => $errors,
                ]
            );
        }
    }

    public function validateUser($userInfo, $router)
    {
        $errors = [];


        $validateeUser = $router->db->validateUser($userInfo);

        if ($validateeUser) {
            return true;
        } else {
            return false;
        }
    }
}
