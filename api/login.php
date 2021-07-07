<?php
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../objects/client.php';

 
// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
 
// создание объекта 'client' 
$client = new Client($db);
$data1 = file_get_contents('php://input');
$data =json_decode($data1);

$client->email = $data->email;
$email_exists = $client->emailExists();


include_once '../config/core.php';
include_once '../libs/php-jwt/src/BeforeValidException.php';
include_once '../libs/php-jwt/src/ExpiredException.php';
include_once '../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;
 
// существует ли электронная почта и соответствует ли пароль тому, что находится в базе данных 
if ( $email_exists && password_verify($data->password, $client->password) ) {
 
    $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "id" => $client->id,
           "firstname" => $client->firstname,
           "lastname" => $client->lastname,
           "phone"=> $client->phone,
           "email" => $client->email
       )
    );
 
    http_response_code(200);
 

    $jwt = JWT::encode($token, $key);
    echo json_encode(
        array(
            "message" =>0,
            "jwt" => $jwt
        )
    );
 
}
 
else {
 
  http_response_code(401);


  echo json_encode(array("message" =>1));
}
?>