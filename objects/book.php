<?php
class Book {

// подключение к базе данных и таблице 'books' 
private $conn;
private $table_name = "books";

// свойства объекта 
public $id;
public $name;
public $author;
public $quantity;

// конструктор для соединения с базой данных 
public function __construct($db){
    $this->conn = $db;
}

// метод read() - получение книг 
function read(){

// выбираем все записи 
$query = "select * from books";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// выполняем запрос 
$stmt->execute();

return $stmt;
} 

// метод create - создание книги 
function create(){

// запрос для вставки (создания) записей 
$query = "insert into books(name, author, quantity) 
values(:name, :author, :quantity);";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// очистка 
$this->name=htmlspecialchars(strip_tags($this->name));
$this->author=htmlspecialchars(strip_tags($this->author));
$this->quantity=htmlspecialchars(strip_tags($this->quantity));

//привязка значений 
$stmt->bindParam(":name", $this->name);
$stmt->bindParam(":author", $this->author);
$stmt->bindParam(":quantity", $this->quantity);


// выполняем запрос 
if ($stmt->execute()) {
    return true;
}

return false;
}


function update(){

// запрос для обновления записи (книги) 
$query = "update books 
set name = :name, author = :author, quantity = :quantity 
where id = :id";

// подготовка запроса 
$stmt = $this->conn->prepare($query);

// очистка 
$this->name=htmlspecialchars(strip_tags($this->name));
$this->author=htmlspecialchars(strip_tags($this->author));
$this->quantity=htmlspecialchars(strip_tags($this->quantity));

// привязываем значения 
$stmt->bindParam(":name", $this->name);
$stmt->bindParam(":author", $this->author);
$stmt->bindParam(":quantity", $this->quantity);
$stmt->bindParam(":id", $this->id);
// $data['name'] =  $this->name;
// $data['author'] =  $this->author;
// $data['quantity'] =  $this->quantity;


// выполняем запрос 
if ($stmt->execute($data)) {
    return true;
}

return false;
}

// метод delete - удаление книги 
function delete(){

// запрос для удаления записи (книги) 
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