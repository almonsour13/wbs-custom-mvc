<?php
// core/Database.php

require __DIR__ . '/../config.php';
class Database
{
    private static $connection;

    public static function connect()
    {
        if (!isset(self::$connection)) {
            try {
                self::$connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
            } catch (PDOException $e) {
                die('Database connection error: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

?>