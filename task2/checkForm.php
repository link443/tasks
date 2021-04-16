<?php

use classes\Db;
use classes\Form;

session_start();

require_once 'classes/Form.php';
require_once 'classes/Db.php';

$formData = new Form($_POST);// принимаем данные от пользователя
$formData->checkInputData();// проверяем их корректность
$connect = Db::getInstance();// подключаемся к бд
$formData->addPost($connect);// записываем их в бд
$formData->checkImage($_FILES);// проверяем наличие картинки от пользователя
$formData->addImage($_FILES, $connect);// добавляем картинку на сервер и запись в бд с именем картинки
header('Location: index.php');// редирект на главную

