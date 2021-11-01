<?php
class Rental {

// подключение к базе данных и таблице 'rentals' 
private $conn;
private $table_name = "rentals";

// свойства объекта 
public $id;
public $user_id;
public $book_id;

// конструктор для соединения с базой данных 
public function __construct($db){
    $this->conn = $db;
}

// метод read() - получение аренд 
function read(){

// выбираем все записи 
$query = "select rentals.id, users.name as user_name, books.name as book_name
from rentals
inner join users on rentals.user_id=users.id
inner join books on rentals.book_id=books.id";;

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// выполняем запрос 
$stmt->execute();

return $stmt;
} 

// метод create - создание аренды 
function create(){

// запрос для вставки (создания) записей 
$query = "INSERT INTO
            " . $this->table_name . "(user_id, book_id)
        values(:user_id, :book_id);";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// очистка 
$this->user_id=htmlspecialchars(strip_tags($this->user_id));
$this->book_id=htmlspecialchars(strip_tags($this->book_id));

// привязка значений 
$stmt->bindParam(":user_id", $this->user_id);
$stmt->bindParam(":book_id", $this->book_id);

// выполняем запрос 
if ($stmt->execute()) {
    return true;
}

return false;
}


function update(){

// запрос для обновления записи (аренды) 
$query = "UPDATE
            " . $this->table_name . "
        SET
            user_id = :user_id,
            book_id = :book_id
        WHERE
            id = :id";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// очистка 
$this->user_id=htmlspecialchars(strip_tags($this->user_id));
$this->book_id=htmlspecialchars(strip_tags($this->book_id));
$this->id=htmlspecialchars(strip_tags($this->id));

// привязываем значения 
$stmt->bindParam(":user_id", $this->user_id);
$stmt->bindParam(":book_id", $this->book_id);
$stmt->bindParam(":id", $this->id);

// выполняем запрос 
if ($stmt->execute()) {
    return true;
}

return false;
}

// метод delete - удаление аренды 
function delete(){

// запрос для удаления записи
$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// очистка 
$this->id=htmlspecialchars(strip_tags($this->id));

// привязываем id записи для удаления 
$stmt->bindParam(1, $this->id);

// выполняем запрос 
if ($stmt->execute()) {
    return true;
}

return false;
}
}
?>