<?php

use classes\Db;
use classes\Form;

session_start();

require_once 'classes/Form.php';
require_once 'classes/Db.php';

$connect = Db::getInstance();// поключение к бд
$posts = $connect->query('SELECT * FROM `comment` ORDER BY `id` DESC')->fetchAll();// запрос к бд для получения постов в виде ассоц.массива

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<h1>Форма обратной связи</h1>
<form enctype="multipart/form-data" action="checkForm.php" method="POST">
    <p>Ваш комментарий:</p>
    <p>
        <textarea name="comment" id="" cols="35" rows="10"></textarea>
    </p>
    <p>
        Ваши Ф.И.О: <input type="text" name="name">
    <p class="errorInput">
        <!-- вывод ощибки имени при наличии -->
        <?= Form::showErrorName(); ?>
    </p>
    </p>
    <p>
        Ваш адрес: <input type="text" name="address">
    </p>
    <p>
        Ваш e-mail: <input type="text" name="email">
    <p class="errorInput">
        <!-- вывод ощибки email при наличии -->
        <?= Form::showErrorEmail(); ?>
    </p>
    </p>
    <p>
        Ваш мобильный телефон: <input type="text" name="phone">
    <p class="errorInput">
        <!-- вывод ощибки номера телефона при наличии -->
        <?= Form::showErrorPhone(); ?>
    </p>
    </p>
    <p>
        <input type="hidden" name="MAX_FILE_SIZE" value="30000000000000000000"/>
        Ваша фотография: <input name="userfile" type="file"/>
    </p>
    <p>
        <input type="submit" value="Отправить форму"/>
    </p>
</form>

<table border="1px">
    <tr>
        <th>Номер</th>
        <th>Комментарий</th>
        <th>Адрес</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Номер телефона</th>
        <th>Изображение</th>
    </tr>
<!-- вывод всех постов в формате таблицы -->
    <?php foreach ($posts as $post) : ?>
        <?= '<tr>' ?>
        <td><?= $post['id'] ?></td>
        <td><?= $post['comment'] ?></td>
        <td><?= $post['address'] ?></td>
        <td><?= $post['name'] ?></td>
        <td><?= $post['email'] ?></td>
        <td><?= $post['phone'] ?></td>
        <td><img width="100px" height="100px" src="<?= 'img/' . $post['img'] ?>" alt=""></td>
        <?= '</tr>' ?>
    <?php endforeach; ?>
</table>

</body>
</html>
