<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение необходимых файлов 
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/product.php';

// создание подключения к БД 
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$keywords=$_POST["search"] ;

$stmt = $product->search($keywords);
$num = $stmt->rowCount();


if ($num>0) {

    $products_arr=array();
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);

        $product_item=array(
            "id" => $idProduct,
            "name" =>$name,
            "description" => $description,
            "price" => $price,
            "brand" =>$brand,
            "category_id" => $idCategory
        );

        array_push($products_arr, $product_item);
    }

    http_response_code(200);


    echo json_encode($products_arr,JSON_UNESCAPED_UNICODE);
}

else {
    http_response_code(404);

 
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}