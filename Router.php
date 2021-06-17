<?php

namespace app;


class Router
{

    public array $getRoutes = [];
    public array $postRoutes = [];
    public Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }


    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
        // echo '<pre>';
        // var_dump($this->postRoutes[$url]);
        // echo '</pre>';
    }

    public function resolve()
    {
        // echo '<pre>';
        // var_dump($_SERVER);
        // echo '</pre>';

        // exit;

        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl];
        } else {
            $fn = $this->postRoutes[$currentUrl];
        }




        if ($fn) {
            if (is_array($fn)) {
                $fn[0] = new $fn[0]();  //$fn= [AuthenticateController, delete]
                //$fn[0] = new ProductController()
            }




            call_user_func($fn, $this);
        } else {
            echo "Page not found";
        }
    }

    public function renderView($view, $assocArray = [])
    {
        foreach ($assocArray as $key => $value) {
            $$key = $value;
            // $products = $value;

            //echo $$key; //$products


        }




        include_once __DIR__ . "/views/$view.php";
    }
}
