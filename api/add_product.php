<?php
header("Access-Control-Allow-Origin: *");


include_once '../config/database.php';
include_once '../objects/product.php';

date_default_timezone_set('Europe/Kiev'); 
// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
 
// создание объекта 'User' 
$product = new Product($db);
$a=json_decode($_POST["description"]);
$b=json_encode($a,JSON_UNESCAPED_UNICODE);

//устанавливаем значения 
$product->name = $_POST["name"];
$product->price = $_POST["price"];
$product->image = $_FILES["image"];
$product->description =$b;
$product->brand = $_POST["brand"];
$product->category = $_POST["category"];
$product->date = date('Y-m-d H:i:s');

$upload_dir = '../uploads/';
$server_url = 'localhost:8888';

// if($product->name && $product->price && $product->image && $product->description && $product->brand && $product->category){

//     $image_name = $_FILES["image"]["name"];
//     $image_tmp_name = $_FILES["image"]["tmp_name"];
//     $error = $_FILES["image"]["error"];

//     if($error > 0){
//         http_response_code(400); 
        
//     }
//     else {
//         $random_name = rand(1000,1000000)."-".$image_name;
//         $upload_name = $upload_dir.strtolower($random_name);
//         $upload_name = preg_replace('/\s+/', '-', $upload_name);

//         if(move_uploaded_file($image_tmp_name , $upload_name)){
//             $product->image=$upload_name;
//             if($product->create()){
//                 http_response_code(200);
//                 echo $random_name; 
//             }
//             else{
//                 http_response_code(400);
//             } 
//         }
//         else{
//             http_response_code(400);
//         }
//     }
    
   
// }
 

// else {
//    http_response_code(400);
// }
