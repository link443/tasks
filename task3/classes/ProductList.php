<?php

namespace classes;

class ProductList
{
    public $order;
    public $userData;

    public function clearBasket($query)
    {
        if (isset($query)) { // очистить корзину
            session_unset();
        }
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getUserData()
    {
        return $this->userData;
    }

    public function unionData($request, $array = [])
    { // объединение данных, полученных от пользователя
        $keys = array_keys($request);
        $values = array_values($request);
        for ($i = 0; $i < count($keys); $i++) {
            if (stristr($keys[$i + 1], $keys[$i])) {
                $array[$i]['brand'] = $keys[$i];
                $array[$i]['model'] = $values[$i];
                $array[$i]['quantity'] = $values[$i + 1];
            }
        }
        return $array;
    }

    public function fillBasket($arr, &$order = [])// наполнить корзину заказа
    {
        foreach ($arr as $value) {// наполнить корзину
            if (empty($value['quantity'])) {
                continue;
            }
            $order[$value['brand']]['model'] = $value['model'];
            $order[$value['brand']]['quantity'] = $value['quantity'];
        }
        return $order;
    }

    public function checkContentBasket($dataSession) // если корзина не пуста, а данные от пользователя не пришли
    {
        if ($dataSession and !$this->order) {
            echo '<p>Ваш заказ:</p>';
            foreach ($dataSession as $key => $value) {
                echo '<p>' . $key . ' ' . $value['model'] . ' - ' . $value['quantity'] . ' ' . 'шт.' . '</p>';
            }
            echo '<a href="index.php">На главную</a>' .
                "<form action='' method='post'>
                    <button name='cleanBasket'>Очистить корзину</button>
                   </form>";
            die();
        }
    }

    public function showOrderContent($dataSession)
    { // вывод содержимого заказа
        if ($dataSession) {
            echo '<p>Ваш заказ:</p>';
            foreach ($dataSession as $key => $value) {
                echo '<p>' . $key . ' ' . $value['model'] . ' - ' . $value['quantity'] . ' ' . 'шт.' . '</p>';
            }
        } else {
            echo 'Ваша корзина пуста';
        }
    }
}
