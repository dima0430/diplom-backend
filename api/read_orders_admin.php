<?php
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../objects/order.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

$stmt = $order->getOrdersAdmin();
$num = $stmt->rowCount();


if ($num>0) {

    $orders_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $products_arr=array();
        $count=0;
        $sum=0;
        $stmt1 = $order->getOrderProductsAdmin(intval($idOrder));
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
            extract($row1);
            $order_product=array(
                "count" => $count_product,
                "name" => $name,
                "price" =>$price,
                "image" => $image
            );
            $count+=intval($count_product);
            $sum+=intval($count_product)* intval($price);
            array_push($products_arr, $order_product);   
        }
        $order_item=array(
            "id" => $idOrder,
            "date" => $date,
            "firstname" =>$firstname,
            "lastname" => $lastname,
            "phone"=> $phone,
            "email" =>$email, 
            "product"=>$products_arr,
            "count"=>$count,
            "sum"=>$sum
        );
        array_push($orders_arr, $order_item);
    }
       
    http_response_code(200);
    echo json_encode($orders_arr,JSON_UNESCAPED_UNICODE);
}
else {

    http_response_code(404);

    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}  

?>