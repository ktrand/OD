<?php
class User {

// подключение к базе данных и таблице 'users' 
private $conn;
private $table_name = "users";

// свойства объекта 
public $id;
public $name;
public $email;

// конструктор для соединения с базой данных 
public function __construct($db){
    $this->conn = $db;
}

// метод read() - получение книг 
function read(){

// выбираем все записи 
$query = "select * from users";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// выполняем запрос 
$stmt->execute();

return $stmt;
} 

// метод create - создание пользователя 
function create(){

// запрос для вставки (создания) записей 
$query = "INSERT INTO
            " . $this->table_name . "(name, email)
        VALUES(:name, :email);";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// очистка 
$this->name=htmlspecialchars(strip_tags($this->name));
$this->email=htmlspecialchars(strip_tags($this->email));

// привязка значений 
$stmt->bindParam(":name", $this->name);
$stmt->bindParam(":email", $this->email);

// выполняем запрос 
if ($stmt->execute()) {
    return true;
}

return false;
}


function update(){

// запрос для обновления записи (пользователя) 
$query = "update users 
    set name = :name, email = :email 
    where id = :id";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// очистка 
$this->name=htmlspecialchars(strip_tags($this->name));
$this->email=htmlspecialchars(strip_tags($this->email));
$this->id=htmlspecialchars(strip_tags($this->id));

// привязываем значения 
$stmt->bindParam(":name", $this->name);
$stmt->bindParam(":email", $this->email);
$stmt->bindParam(":id", $this->id);

// выполняем запрос 
if ($stmt->execute()) {
    return true;
}

return false;
}

// метод delete - удаление пользователя 
function delete(){

// запрос для удаления записи (пользователя) 
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