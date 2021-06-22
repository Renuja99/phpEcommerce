<?php

namespace app;

use PDO;
use app\models\Product;

class Database
{
    public PDO $pdo;
    public static Database $db;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=phpEcommerceDatabase', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }


    public function authenticateUser($array)
    {

        $username = $array['username'];
        $password = $array['password'];
        $statement = $this->pdo->prepare('SELECT * FROM user WHERE username=:username AND password=:password');
        $statement->bindValue(':username', "$username");
        $statement->bindValue(':password', "$password");

        $statement->execute();

        $userInfo  =  $statement->fetch(PDO::FETCH_ASSOC);

        if ($userInfo) {
            return $userInfo;
        } else {

            return false;
        }
    }


    public function validateUser($array)
    {
        $id = $array['id'];
        $token = $array['user_token'];
        $statement = $this->pdo->prepare('SELECT * FROM user WHERE user_id=:id AND user_token=:token');
        $statement->bindValue(':id', "$id");
        $statement->bindValue(':token', "$token");

        $statement->execute();

        $userInfo  =  $statement->fetch(PDO::FETCH_ASSOC);

        if ($userInfo) {
            return true;
        } else {

            return false;
        }
    }
}
