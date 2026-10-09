<?php

namespace App\Controllers;

use App\Models\Station;

class HomeController 
{
    public function index() 
    {

        if(isset($_GET['start']) && isset($_GET['end'])){

        $start = $_GET['start'];
        $end = $_GET['end'];

        echo "Stacja początkowa ID: ".$start;
        echo "<br>";
        echo "Stacja końcowa ID: ".$end;
        echo "<br>";
        echo "<a href='index.php'>Wróć do formularza</a>";

        } else {

        $stations = Station::getAll();
        
        require_once __DIR__ . '/../Views/home.php';



        }
        

    


    }
}