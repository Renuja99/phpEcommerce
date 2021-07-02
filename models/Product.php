<?php

namespace app\models;

use PDO;
use app\Database;
use app\helpers\UtilHelper;
use Exception;

class Product extends Database
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?float $price = null;
    public ?string $image = null;




    public function load($data)
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'];
        $this->image = $data['encodedImage'];
    }

    public function save()
    {
        $errors = [];
        if (!$this->title) {
            $errors[] = 'Product title is required';
        }

        if (!$this->price) {
            $errors[] = 'Product price is required';
        }

        if (!is_dir(__DIR__ . '/../public/images')) {

            mkdir(__DIR__ . '/../public/images');
        }


        if (empty($errors)) {


            if ($this->image) {
                $target_dir =  'images/';
                $decoded_file = base64_decode($this->image);
                $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE);

                $extension = UtilHelper::mime2ext($mime_type); //extract extension from mime type
                $file = uniqid() . '.' . $extension; //rename file as a unique name





                $file_dir  = $target_dir . uniqid() . '.' . $extension;
                $this->image = $file_dir;
                try {
                    file_put_contents($file_dir, $decoded_file);
                } catch (Exception $e) {
                }
            }

            if ($this->id) {

                $this->updateProduct($this);
            } else {
                $this->createProduct($this);
            }
        }
        return $errors;
    }

    public function getProducts($page, $results_per_page)
    {



        $offset = ($page - 1) * $results_per_page;



        //GET TOTAL NUMBER OF PAGES

        $count_statement = $this->pdo->prepare('SELECT COUNT(id) FROM products_table');
        $count_statement->execute();
        $array_count = $count_statement->fetchAll(PDO::FETCH_ASSOC);



        foreach ($array_count as $key => $value) {

            $total_number_of_rows =  $value["COUNT(id)"];
        }




        //determine the total number of pages available  
        $number_of_pages = ceil($total_number_of_rows / $results_per_page);


        //Retrieve data and send JSON responses the results;


        $sql_query = "SELECT * FROM products_table LIMIT :offset,:results_per_page ";

        $statement = $this->pdo->prepare($sql_query);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $statement->bindValue(':results_per_page', (int)$results_per_page, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $productsResult = [];
        $result['additionalinfo'] = array();

        //$result[] = $number_of_pages;
        //display the retrieved result on the webpage  
        foreach ($results as $key => $value) {
            $productsResult[] = $value;
        }

        $item_array = array(
            'numberofpages' => $number_of_pages,
            'numberofrecords' => $total_number_of_rows
        );
        array_push($result['additionalinfo'], $item_array);


        $returnedArrays = [];
        array_push($returnedArrays, $result['additionalinfo'], $productsResult);


        // echo '<pre>';
        // var_dump($productsResult);
        // exit();
        // $statement = $this->pdo->prepare('SELECT * FROM products_table ORDER BY create_date DESC');
        // $statement->execute();
        // $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $returnedArrays;
    }


    // public function getProductById($id)
    // {
    //     $statement = $this->pdo->prepare('SELECT * FROM products_table WHERE id=:id');
    //     $statement->bindValue(':id', $id);
    //     $statement->execute();
    //     return $statement->fetch(PDO::FETCH_ASSOC);
    // }


    public function updateProduct(Product $product)
    {

        $statement = $this->pdo->prepare("UPDATE products_table SET title= :title ,price= :price, description =:description , image =:image WHERE id=:id");

        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':image', $product->image);
        $statement->bindValue(':id', $product->id);
        $statement->execute();
    }


    public function createProduct(Product $product)
    {
        $statement = $this->pdo->prepare("INSERT INTO products_table(title,price, description, create_date, view_product,  image ) VALUES( :title,:price,:description, :date,1, :image)");
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));
        $statement->bindValue(':image', $product->image);
        $statement->execute();
    }

    public function deleteProduct($id)
    {

        $statement = $this->pdo->prepare("UPDATE products_table SET view_product=0 WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
