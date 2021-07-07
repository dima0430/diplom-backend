<?php
header("Access-Control-Allow-Origin: *");


include_once '../config/database.php';
include_once '../objects/order.php';

date_default_timezone_set('Europe/Kiev');  
$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

$order->date = date('Y-m-d H:i:s');
$order->idClient = $_POST['idClient'];

$lastID=$order->addOrder();
if($lastID){
    $arr =json_decode($_POST['items']);
    foreach ($arr as $key => $value) {
        if($order->addOrderProducts($lastID,$value->id,$value->count)){
            echo 'zbs';
        }
        else echo 'loh';
    }
}
else echo 'loh1';
