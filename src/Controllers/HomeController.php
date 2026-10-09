<?php

namespace App\Controllers;

use App\Models\Station;

class HomeController 
{


public function index() 
{
    $stations = \App\Models\Station::getAll();
    
    $routes = null; 

    if (isset($_GET['start']) && isset($_GET['end'])) {
        $start = $_GET['start'];
        $end = $_GET['end'];
        
        $routes = \App\Models\Connection::findDirectRoute($start, $end);
    }

    require_once __DIR__ . '/../Views/home.php';
}
    }
