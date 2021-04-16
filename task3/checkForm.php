<?php

use classes\ProductList;

session_start();

spl_autoload_register(function ($class) {
    require_once __DIR__ . '/' . $class . '.php';
})

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--  подключить bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<?php

$productList = new ProductList();
$productList->clearBasket($_POST['cleanBasket']);// очистить корзину
$productList->userData = $productList->unionData($_POST);// объединить данные, пришедшие от пользователя
$productList->order = $productList->fillBasket($productList->getUserData(), $order);// наполнить корзину
$productList->checkContentBasket($_SESSION['order'], $productList->getOrder());// проверка содержимого корзины
$_SESSION['order'] = $productList->getOrder();// сохранение заказа в сессию
$productList->showOrderContent($_SESSION['order']);// отобразить содержимое корзины

?>

<a href="index.php">На главную</a>
<form action="" method="post">
    <button name="cleanBasket">Очистить корзину</button>
</form>
</body>
</html>
