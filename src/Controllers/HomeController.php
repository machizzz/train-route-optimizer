<?php

namespace App\Controllers;

use App\Models\Station;

class HomeController 
{


public function index() 
{
    $stations = \App\Models\Station::getAll();
    $routes = null; 
    $transferRoutes = null; // Deklarujemy pustą zmienną na przesiadki

    if (isset($_GET['start']) && isset($_GET['end'])) {
        $start = $_GET['start'];
        $end = $_GET['end'];
        
        $routes = \App\Models\Connection::findDirectRoute($start, $end);
        
        // Jeśli brak tras bezpośrednich, szukamy przesiadek
        if (empty($routes)) {
            $transferRoutes = \App\Models\Connection::findRouteWithOneTransfer($start, $end);
        }
    }

    require_once __DIR__ . '/../Views/home.php';
}
}
