<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../config/database.php';
include_once '../objects/book.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// инициализируем объект 
$book = new Book($db);
 
// запрашиваем книги 
$stmt = $book->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей 
if ($num>0) {

    // массив книг 
    $books_arr=array();
    $books_arr["records"]=array();

    // получаем содержимое нашей таблицы 
    // fetch() быстрее, чем fetchAll() 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку 
        extract($row);

        $book_item=array(
            "id" => $id,
            "name" => $name,
            "author"=>$author,
            "quantity"=>$quantity
        );

        array_push($books_arr["records"], $book_item);
    }

    // устанавливаем код ответа - 200 OK 
    http_response_code(200);

    // выводим данные о книгах в формате JSON 
    echo json_encode($books_arr);
}

else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что книги не найдены 
    echo json_encode(array("message" => "книги не найдены."), JSON_UNESCAPED_UNICODE);
}