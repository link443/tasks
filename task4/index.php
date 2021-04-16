<?php

/*
   Создайте веб-страницу, на которой cookie-файл используется для слежения за количеством ее
   просмотров отдельным пользователем. Когда отдельный пользователь просматривает страницу
   в первый раз, на странице должно быть выведено сообщение вроде "Number of views: 1"
   (Количество просмотров: 1), а когда данный пользователь просматривает страницу во второй
   раз — сообщение "Number of views: 1" и т.д.
/*

/*
function checkUserVisits()
{
    if (!isset($_COOKIE['user'])) {
        setcookie('user', '1');
        echo 'Number of views: 1';
    } else {
        $visits = $_COOKIE['user'] + 1;
        setcookie('user', $visits);
        echo 'Number of views: ' . $visits;
    }
}

checkUserVisits();
*/

/*
    Видоизмените веб-страницу из первого упражнения таким образом, чтобы на ней выводилось
    специальное сообщение при 5-м, 10-м и 15-м просмотре страницы, а после 20-го просмотра
    должен быть удален cookie-файл и подсчет просмотров страницы начат с самого начала.
*/

function checkUserVisits()
{
    if (!isset($_COOKIE['user'])) {
        setcookie('user', '1');
        echo 'Число просмотров данной страницы: 1';
    } else {
        $visits = $_COOKIE['user'] + 1;
        if ($visits === 20) {
            setcookie('user', '', time());
            die('Кука удалена!');
        }
        $arr = [5, 10, 15];
        foreach ($arr as $elem) {
            if ($elem === $visits) {
                setcookie('user', $visits);
                die('Специальное сообщение: число просмотров страницы - ' . $visits);
            }
        }
        setcookie('user', $visits);
        echo 'Число просмотров данной страницы: ' . $visits;
    }
}

checkUserVisits();