<?php
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../objects/category.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
 
$category =new Category($db);

$stmt = $category->read();
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей 
if ($num>0) {

    // массив 
    $categories_arr=array();
    $categories_arr["records"]=array();

    // получим содержимое нашей таблицы 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлекаем строку 
        extract($row);

        $category_item=array(
            "id" => $idCategories,
            "name" => $name,
        );

        array_push($categories_arr["records"], $category_item);
    }

    // код ответа - 200 OK 
    http_response_code(200);

    // покажем данные категорий в формате json 
    echo json_encode($categories_arr);
} else {

    // код ответа - 404 Ничего не найдено 
    http_response_code(404);

    // сообщим пользователю, что категории не найдены 
    echo json_encode(array("message" => "Категории не найдены."), JSON_UNESCAPED_UNICODE);
}
?>

