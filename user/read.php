<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../config/database.php';
include_once '../objects/user.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// инициализируем объект 
$user = new User($db);
 
// запрашиваем пользователя 
$stmt = $user->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей 
if ($num>0) {

    // массив пользователей 
    $users_arr=array();
    $users_arr["records"]=array();

    // получаем содержимое нашей таблицы 
    // fetch() быстрее, чем fetchAll() 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку 
        extract($row);

        $user_item=array(
            "id" => $id,
            "name" => $name,
            "email"=>$email
        );

        array_push($users_arr["records"], $user_item);
    }

    // устанавливаем код ответа - 200 OK 
    http_response_code(200);

    // выводим данные о пользователях в формате JSON 
    echo json_encode($users_arr);
}

else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что пользователи не найдены 
    echo json_encode(array("message" => "пользователи не найдены."), JSON_UNESCAPED_UNICODE);
}