<?php
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../objects/comment.php';

$database = new Database();
$db = $database->getConnection();
$comment = new Comment($db);
$id=$_POST['id'];
$stmt = $comment->getComments($id);
$num = $stmt->rowCount();


if ($num>0) {

    $comments_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $comment_item=array(
            "id" => $idComment,
            "clientText" => $clientText,
            "date" =>$date,
            "firstname" => $firstname,
            "lastname"=> $lastname
        );

        array_push($comments_arr, $comment_item);
    }


    http_response_code(200);


    echo json_encode($comments_arr,JSON_UNESCAPED_UNICODE);
}

else {

    http_response_code(404);

    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}  