<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом user 
include_once '../config/database.php';
include_once '../objects/user.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$user = new User($db);

// получаем id пользователя для редактирования 
$data = json_decode(file_get_contents("php://input"));

// установим id свойства пользователя для редактирования 
$user->id = $data->id;

// установим значения свойств пользователя 
$user->name = $data->name;
$user->email = $data->email;


// обновление пользователя 
if ($user->update()) {

    // установим код ответа - 200 ok 
    http_response_code(200);

    // сообщим пользователю 
    echo json_encode(array("message" => "пользователь был обновлён."), JSON_UNESCAPED_UNICODE);
}

// если не удается обновить user, сообщим пользователю 
else {

    // код ответа - 503 Сервис не доступен 
    http_response_code(503);

    // сообщение пользователю 
    echo json_encode(array("message" => "Невозможно обновить user."), JSON_UNESCAPED_UNICODE);
}
?>