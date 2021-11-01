--sql запрос для создании таблицы пользователей
"create table if not exists users(
id serial primary key,
name varchar(100) not null,
email varchar(100) not null
);"

--запрос для создания талицы книг
"create table if not exists books(
id serial primary key,
name varchar(100) not null unique,
author varchar(100) not null,
quantity integer
);"

--запрос для создания таблицы аренд(прокатов)

"create table if not exists rentals(
id serial primary key,
user_id integer not null 
references users(id) on delete cascade,
book_id integer not null
references books(id) on delete cascade,
constraint unique_user_and_book unique(user_id,book_id)
);"