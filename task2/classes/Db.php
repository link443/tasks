<?php

namespace classes;

class Db extends \PDO// класс подключения в бд
{
    private static $connect;

    public static function getInstance()
    {
        if (!isset(self::$connect)) {
            self::$connect = new self('mysql:host=localhost;dbname=tasks', 'root', 'root');
            return self::$connect;
        }
        return self::$connect;
    }
}