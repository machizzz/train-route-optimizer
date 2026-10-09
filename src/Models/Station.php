<?php

namespace App\Models;

class Station 
{
    public static function getAll() 
    {
      
        $db = Database::getConnection();
        
   
        $stmt = $db->query("SELECT id, name, country FROM stations");
        
        return $stmt->fetchAll();
    }
}