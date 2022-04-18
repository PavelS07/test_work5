<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Статус</title>
</head>
<body>
<?php if(!empty($errors)): ?>
    <ul>
    <?php foreach($errors as $error): ?>
        <li style="color:red;"><?=$error?></li>
    <?php endforeach;?>
    </ul>
<?php else: ?>
    <p>Данные успешно обновлены!</p>
<?php endif; ?>
<a href="/cabinet">Перейти в кабинет</a>
</body>
</html>