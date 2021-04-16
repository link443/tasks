<?php

namespace classes;

class Form
{
    public function createProductList($data, $order)// вывести форму с данными из массива data и input values из order
    {
        foreach ($data as $brand => $models) {
            echo '<p>' .
                "<label for=$brand'>Выберете модель $brand: </label>" .
                "<select id=$brand name=$brand>";
            foreach ($models as $model) {
                echo "<option value='$model'>$model</option>";
            }
            echo "</select>" .
                "<label for='quantity_$brand'>Количество:</label>" .
                "<input type='text' id='$brand' name='quantity_$brand' value=" . $order[$brand]['quantity'] . ">" .
                '</p>';
        }
    }
}