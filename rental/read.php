<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../config/database.php';
include_once '../objects/rental.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// инициализируем объект 
$rental = new Rental($db);
 
// запрашиваем пользователя 
$stmt = $rental->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей 
if ($num>0) {

    // массив пользователей 
    $rentals_arr=array();
    $rentals_arr["records"]=array();

    // получаем содержимое нашей таблицы 
    // fetch() быстрее, чем fetchAll() 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку 
        extract($row);

        $rental_item=array(
            "id" => $id,
            "user_name" => $user_name,
            "book_name"=>$book_name
        );

        array_push($rentals_arr["records"], $rental_item);
    }

    // устанавливаем код ответа - 200 OK 
    http_response_code(200);

    // выводим данные о пользователях в формате JSON 
    echo json_encode($rentals_arr);
}

else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что пользователи не найдены 
    echo json_encode(array("message" => "пользователи не найдены."), JSON_UNESCAPED_UNICODE);
}