<?php

//Есть строка в которой содержатся открывающие и закрывающие скобки в арифметическом выражении - ( и ) соответственно. Необходимо проверить, совпадает ли количество открывающихся и закрывающихся скобок. Последовательность расставления скобок должна быть корректная:
//5 * (4 - 2) - всё ок
//5 * (4 - 2( - ошибика

$openBracket = '(';
$indexOpenBracket = [];// задаем пустой массив открытых скобок
$closeBracket = ')';
$indexCloseBracket = [];// задаем пустой массив закрытых скобок

$string = '5 * (4 - 2)(2+1)';
$splitString = str_split($string, 1);// разбиваем строку на символы

for ($i = 0; $i < count($splitString); $i++) {// получим индексы открытых и закрытых скобок
    if ($splitString[$i] == $openBracket) {
        $indexOpenBracket[] = $i;
    }
    if ($splitString[$i] == $closeBracket) {
        $indexCloseBracket[] = $i;
    }
}

if (count($indexOpenBracket) != count($indexCloseBracket)) {// проверяем, соответствует количество открытых скобок количеству закрытых
    die('Число открытых скобок не равняется числу закрытых!');
}

$indexBrackets = [];// задаем массив, который будет содержать последовательность индексов скобок

for ($i = 0; $i < count($indexOpenBracket); $i++) { // заполняем этот массив индексами открытых и закрытых скобок
    $indexBrackets[] = $indexOpenBracket[$i];
    $indexBrackets[] = $indexCloseBracket[$i];
}

for ($i = 0; $i < count($indexBrackets); $i++) { // проверим, чтобы за открытой скобкой всегда шла закрытая
    if (!$indexBrackets[$i + 1]) {// остановим цикл, если элемент массива не существует
        break;
    }
    if ($indexBrackets[$i + 1] < $indexBrackets[$i]) {// если за открытой скобкой не идет закрытая, а за закрытой - открытая, то остановим скрипт
        die('Скобки расставлены не корректно!');
    }
}

echo 'Скобки расставлены корректно!';// в случае успешного выполнения скрипта выведется надпись







