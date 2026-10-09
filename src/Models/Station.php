<?php

namespace App\Models;

class Station 
{
    public static function getAll() 
    {
        // Pobieramy jedyne, otwarte połączenie z bazą
        $db = Database::getConnection();
        
        // Wykonujemy zapytanie do tabeli stations
        $stmt = $db->query("SELECT id, name, country FROM stations");
        
        return $stmt->fetchAll();
    }
}