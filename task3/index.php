<?php

use classes\Form;

require_once 'components/data.php';
require_once 'autoload.php';

session_start();

$order = $_SESSION['order'];// содержимое заказа
$form = new Form();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<form method="POST" action="checkForm.php">
<!-- Создать форму из исходного массива data, order - данные, записанные в сессию -->
    <?php $form->createProductList($data, $order); ?>
    <p>
        <input type="submit" value="Добавить в корзину"/>
    </p>
    <p>
        <a href="checkForm.php">Просмотреть корзину</a>
    </p>
</form>
</body>
</html>
