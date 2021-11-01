<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом book 
include_once '../config/database.php';
include_once '../objects/book.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$book = new Book($db);

// получаем id книги для редактирования 
$data = json_decode(file_get_contents("php://input"));

// установим id свойства книги для редактирования 
$book->id = $data->id;

// установим значения свойств книги 
$book->name = $data->name;
$book->author = $data->author;
$book->quantity = $data->quantity;


// обновление книги 
if ($book->update()) {

    // установим код ответа - 200 ok 
    http_response_code(200);

    // сообщим пользователю 
    echo json_encode(array("message" => "книга была обновлён."), JSON_UNESCAPED_UNICODE);
}

// если не удается обновить книгу, сообщим пользователю 
else {

    // код ответа - 503 Сервис не доступен 
    http_response_code(503);

    // сообщение пользователю 
    echo json_encode(array("message" => "Невозможно обновить книгу."), JSON_UNESCAPED_UNICODE);
}
?>