<?php
include_once '../config/core.php';
include_once '../libs/php-jwt/src/BeforeValidException.php';
include_once '../libs/php-jwt/src/ExpiredException.php';
include_once '../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../objects/client.php';

$data1 = file_get_contents("php://input");
$data = json_decode($data1);

$jwt=isset($data->jwt) ? $data->jwt : "";

if($jwt) {
 

    try {
        $decoded = JWT::decode($jwt, $key, array('HS256')); 
        http_response_code(200);

        echo json_encode(array(
            "message" => "Доступ разрешен.",
            "data" => $decoded->data
        ));
 
    }
  
    catch (Exception $e){
    
         http_response_code(401);
        echo json_encode(array(
            "message" => "Доступ закрыт.",
            "error" => $e->getMessage()
        ));
    }
}
 

else{
 
    http_response_code(401);
  
    echo json_encode(array("message" => "Доступ запрещён."));
}
?>
