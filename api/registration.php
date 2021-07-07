<?php
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../objects/client.php';

 
// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
 
$client = new Client($db);
$data1 = file_get_contents('php://input');
$data =json_decode($data1);

$client->firstname = $data->firstname;
$client->lastname = $data->lastname;
$client->phone = $data->phone;
$client->email = $data->email;
$client->password = $data->password;




if (
    !empty($client->firstname) &&
    !empty($client->email) &&
    !empty($client->password) &&
    $client->create()
) {
    
    http_response_code(200);
 
    echo ("message => Пользователь был создан.");
}
 
else {
 
    http_response_code(400);
 
    echo ("message => Невозможно создать пользователя.");
}
?>