<?php

namespace App\Models;

use PDO;
use PDOException;

class Database 
{
    private static $connection = null;

    private function __construct() {}

    public static function getConnection() 
    {
        if (self::$connection === null) {
            $host = '127.0.0.1';
            $db_name = 'trains'; 
            $username = 'root';
            $password = ''; 

            try {
                $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
                self::$connection = new PDO($dsn, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Błąd połączenia z bazą danych: " . $e->getMessage());
            }
        }
        
        return self::$connection;
    }
}