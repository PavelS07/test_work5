# test_work5

Задание 1

бд->test.sql

подключение к бд в /config/db_params.php

Задание 2
бд->test.sql
запросы->sql.txt

// Запрос 1
SELECT email FROM `users` GROUP BY email HAVING COUNT(email)>1;

// Запрос 2
SELECT login FROM `users` as u LEFT JOIN `orders` as o ON u.id=o.user_id WHERE user_id IS NULL;

// Запрос 3
SELECT login FROM `users` as u INNER JOIN `orders` as o ON u.id=o.user_id GROUP BY login HAVING COUNT(login)>2;
