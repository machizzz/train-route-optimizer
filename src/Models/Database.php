<?php

namespace App\Models;

use PDO;
use PDOException;

class Database 
{
    private static $connection = null;

    // Prywatny konstruktor blokuje tworzenie wielu instancji (wzorzec Singleton)
    private function __construct() {}

    public static function getConnection() 
    {
        if (self::$connection === null) {
            $host = '127.0.0.1';
            $db_name = 'trains'; // Wpisz tu nazwę swojej bazy danych z phpMyAdmin
            $username = 'root';
            $password = ''; // W XAMPP domyślnie hasło jest puste

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