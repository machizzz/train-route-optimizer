<?php

namespace App\Controllers;

use App\Models\Station;

class HomeController 
{
    public function index() 
    {
        // Pobieramy dane z bazy
        $stations = Station::getAll();
        
        // Ładujemy plik widoku (zmienna $stations będzie w nim automatycznie dostępna)
        require_once __DIR__ . '/../Views/home.php';
    }
}