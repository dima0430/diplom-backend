<?php
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../objects/comment.php';

$database = new Database();
$db = $database->getConnection();
date_default_timezone_set('Europe/Kiev');  

 
$comment = new Comment($db);

$comment->clientText =$_POST['clientText'];
$comment->date = date('Y-m-d H:i:s');
$comment->idClient =$_POST['idClient'];
$comment->idProduct = $_POST['idProduct'];

if($comment->addComment()){
    // echo "ОК";
    $stmt =$comment->getLastComment($comment->idProduct);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

        extract($row);

        $comment_item=array(
            "id" => $idComment,
            "clientText" => $clientText,
            "date" =>$date,
            "firstname" => $firstname,
            "lastname"=> $lastname
        );
    echo json_encode($comment_item,JSON_UNESCAPED_UNICODE);    
}
else echo $comment->clientText;