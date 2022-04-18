<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
</head>
<body>
<?php if(!empty($errors)): ?>
    <ul>
        <?php foreach($errors as $error): ?>
            <li style="color:red;"><?=$error?></li>
        <?php endforeach;?>
    </ul>
<?php endif; ?>
<form action="/register" method="POST" style="display:flex; flex-direction: column; margin:0 auto; width:500px; ">
    <input type="text" placeholder="Имя" name="name" style="margin-bottom: 10px;" required>
    <input type="text" placeholder="Отчество" name="patronymic" style="margin-bottom: 10px;" required>
    <input type="text" placeholder="Фамилия" name="surname" style="margin-bottom: 10px;" required>
    <input type="text" placeholder="E-mail" name="email" style="margin-bottom: 10px;" required>
    <input type="text" placeholder="Логин" name="login" style="margin-bottom: 10px;" required>
    <input type="password" placeholder="Пароль" name="password" style="margin-bottom: 10px;" required>

    <button type="submit" name="register-button">Регистрация</button>
</form>

</body>
</html>