<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\AuthenticateController;
use app\Router;
use app\controllers\ProductController;
use app\controllers\CategoryController;
use app\controllers\OrderController;


header('Content-Type: application/json');


$router = new Router();

//AUTHENTICATION ROUTES
$router->get('/', [AuthenticateController::class, 'index']);
$router->post('/', [AuthenticateController::class, 'authenticateUser']);
$router->get('/dashboard', [AuthenticateController::class, 'dashboard']);

//PRODUCT ROUTES
$router->get('/api/products', [ProductController::class, 'index']);
$router->get('/api/products/create', [ProductController::class, 'create']); //Create view
$router->post('/api/products/create', [ProductController::class, 'create']);
$router->post('/api/products/update', [ProductController::class, 'update']);
$router->get('/api/products/update', [ProductController::class, 'update']); //UPDATE view
$router->post('/api/products/delete', [ProductController::class, 'delete']);

//CATEGORY_ROUTES
$router->get('/api/categories', [CategoryController::class, 'index']);
$router->post('/api/categories/create', [CategoryController::class, 'create']);
$router->post('/api/categories/update', [CategoryController::class, 'update']);
$router->post('/api/categories/delete', [CategoryController::class, 'delete']);


//ORDER_ROUTES
$router->get('/api/orders', [OrderController::class, 'index']);
$router->post('/api/orders/create', [OrderController::class, 'create']);
$router->post('/api/orders/update', [OrderController::class, 'update']);
$router->post('/api/categories/delete', [OrderController::class, 'delete']);

//CANCELED_ORDER_ROUTES


//RATINGS_CRUD



$router->resolve();
