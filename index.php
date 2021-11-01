<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/jquery.js"></script>
    <title>All books</title>
</head>
<body>
   <div id="page-content" >

   </div>
</body>
</html>
<script>
    var json_url="http://odresp-api/book/read.php";
    
    $.getJSON(json_url, function(data){
        var read_books_html = ` 
        <table>
            <tr>
                <th>Название</th>
                <th>Автор</th>
                <th>Количество</th>
            </tr>`;
            // перебор возвращаемого списка данных 
    $.each(data.records, function(key, book) {

// создание новой строки таблицы для каждой записи 
read_books_html+=`<tr>

    <td>` + book.name + `</td>
    <td>` + book.author + `</td>
    <td>` + book.quantity + `</td>`            
    });

    read_books_html +=`</tr></table>`;
    $("#page-content").html(read_books_html);
});
</script> 