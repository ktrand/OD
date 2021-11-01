<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../config/database.php';

// создание объекта user 
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
 
// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));
 
// убеждаемся, что данные не пусты 
if (
    !empty($data->name) &&
    !empty($data->email)
) {

    // устанавливаем значения свойств пользователя
    $user->name = $data->name;
    $user->email = $data->email;

    // Добавление книги
    if($user->create()){

        // установим код ответа - 201 добавлено 
        http_response_code(201);

        // сообщим пользователю 
        echo json_encode(array("message" => "Пользователь был добавлен."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается добавить user, сообщим пользователю 
    else {

        // установим код ответа - 503 сервис недоступен 
        http_response_code(503);

        // сообщим пользователю 
        echo json_encode(array("message" => "Невозможно добавить пользователя."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что данные неполные 
else {

    // установим код ответа - 400 неверный запрос 
    http_response_code(400);

    // сообщим пользователю 
    echo json_encode(array("message" => "Невозможно добавить пользователя. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>