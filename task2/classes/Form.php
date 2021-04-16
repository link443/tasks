<?php

namespace classes;

class Form // класс для работы с формой
{
    public $comment;
    public $name;
    public $address;
    public $email;
    public $phone;
    public $tmpNameImg;
    public $nameImg;
    public $imgExtension;
    public $newNameImg;
    public $addedPostId;

    public function __construct($request)// при создании экзмепляра класса туда передается post запрос.
        // содержимое полей запроса обрабатывается функцией htmlspecialchars для защиты от xss атак
    {
        $this->comment = htmlspecialchars($request['comment'], ENT_QUOTES, 'UTF-8');
        $this->name = htmlspecialchars($request['name'], ENT_QUOTES, 'UTF-8');
        $this->address = htmlspecialchars($request['address'], ENT_QUOTES, 'UTF-8');
        $this->email = htmlspecialchars($request['email'], ENT_QUOTES, 'UTF-8');
        $this->phone = htmlspecialchars($request['phone'], ENT_QUOTES, 'UTF-8');
    }

    public function checkName()// проверка поля на с именем на пустоту и запись в сессию информации, в случае пустого запроса
    {
        if (empty($this->name)) {
            $_SESSION['emptyName'] = 'Вы не заполнили свое имя!';
        }
    }

    public function checkPhone() { // проверка поля на с телефоном на пустоту и запись в сессию информации, в случае пустого запроса
        if (empty($this->phone)) {
            $_SESSION['emptyPhone'] = 'Вы не заполнили свой номер телефона!';
        }
    }

    public function checkEmail() {
        if (stristr($this->email, '@gmail.com')) { // // проверка поля на с email-ом на содержание в строке @gmail.com
            $_SESSION['errorEmail'] = 'Регистрация пользователей с таким почтовым адресом невозможна';
        }
    }

    public static function showErrorName()// вывод сообщения о пустом имени
    {
        echo $_SESSION['emptyName'];
        unset($_SESSION['emptyName']);
    }

    public static function showErrorEmail() //вывод сообщения о некоректном email
    {
        echo $_SESSION['errorEmail'];
        unset($_SESSION['errorEmail']);
    }

    public static function showErrorPhone() //вывод сообщения о пустом телефоне
    {
        echo $_SESSION['emptyPhone'];
        unset($_SESSION['emptyPhone']);
    }

    public function checkInputData()// проверка на наличие ошибок и остановка скрипта в случае их наличия
    {
        if (empty($this->name) or empty($this->phone) or stristr($this->email, '@gmail.com')) {
            $this->checkName();
            $this->checkPhone();
            $this->checkEmail();
            header('Location: index.php');
            die();
        }
    }

    public function checkImage($filesArray)// проверка наличие отправленной картинки
    {
        if (!$filesArray) {// если $_FILES пуст - выйти
            return;
        }
        $this->tmpNameImg = $filesArray['userfile']['tmp_name'];// временное имя файла
        $this->nameImg = $filesArray['userfile']['name'];// имя файла при передаче
        $this->imgExtension = (new SplFileInfo($this->nameImg))->getExtension();// узнаем расширение картинки
        $this->newNameImg = 'img' . $this->addedPostId . '.' . $this->imgExtension;// определяем имя картинки для записи в бд
    }

    public function addPost(Db $connection) {// добавление поста в бд
        $query = $connection->prepare(("INSERT INTO `comment`(`comment`, `address`, `name`, `email`, `phone`) VALUES (:comment, :address, :name, :email, :phone)"));// делаем подготовленный запрос с данными из полей ввода для защиты sql-иньекций
        $query->bindParam(':comment',$this->comment);
        $query->bindParam(':address',$this->address);
        $query->bindParam(':name',$this->name);
        $query->bindParam(':email',$this->email);
        $query->bindParam(':phone',$this->phone);
        $query->execute();// выполняем запрос
        $this->addedPostId = $connection->lastInsertId();// узнаем id последнего запроса к бд
    }

    public function addImage($request, $connection)// добавить картинку на сервер
    {
        if (!$request) { // если $_FILES пуст - выйти
            return;
        }
        if (move_uploaded_file($this->tmpNameImg, 'img/' . $this->newNameImg)) {// если картинка перемещена в директорию img под новым именем
            $query = $connection->prepare("UPDATE `comment` SET `img` =:img WHERE `id` = '$this->addedPostId'");// делаем подготовленный запрос с новым именем картинки для защиты sql-иньекций
            $query->bindParam(':img', $this->newNameImg);
            $query->execute();// выполняем запрос
        }
    }
}