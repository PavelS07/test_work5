<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователь <?=$user['id']?></title>
</head>

<body>
<h3>Логин - <?=$user['login']?></h3>
    <form action="/cabinet/update" method="POST" style="display:flex; flex-direction: column; margin-bottom: 20px; width:500px;">
        <p>Имя</p>
        <input type="text" value="<?=$user['name']?>" name="name" style="margin-bottom: 10px;">
        <p>Отчество</p>
        <input type="text" value="<?=$user['patronymic']?>" name="patronymic" style="margin-bottom: 10px;">
        <p>Фамилия</p>
        <input type="text" value="<?=$user['surname']?>" name="surname" style="margin-bottom: 10px;">
        <p>Новый пароль</p>
        <input type="password" value="" name="password" style="margin-bottom: 10px;">
        <input type="hidden" value="<?=$user['password']?>" name="old_password" style="margin-bottom: 10px;">
        <button type="submit">Обновить данные</button>
    </form>
    <form action="/logout" method="POST" style="margin-bottom: 20px;">
        <button type="submit" name="button_logout">Выход</button>
    </form>
</body>
</html>
