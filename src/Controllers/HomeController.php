<?php

namespace App\Controllers;

use App\Models\Station;

class HomeController 
{


public function index() 
{
    $stations = \App\Models\Station::getAll();
    $journeySegments = [];
    $totalPrice = 0;
    $searchPerformed = false;

    if (isset($_GET['stops']) && is_array($_GET['stops']) && count($_GET['stops']) >= 2) {
        $stops = $_GET['stops'];
        $searchPerformed = true;

        
        for ($i = 0; $i < count($stops) - 1; $i++) {
            $startId = $stops[$i];
            $endId = $stops[$i + 1];

            
            if ($startId == $endId) continue;

            // Szukamy najpierw połączenia bezpośredniego
            $routes = \App\Models\Connection::findDirectRoute($startId, $endId);

            if (!empty($routes)) {
                $journeySegments[] = [
                    'type' => 'direct',
                    'data' => $routes[0] 
                ];
                $totalPrice += $routes[0]['price'];
            } else {
                
                $transferRoutes = \App\Models\Connection::findRouteWithOneTransfer($startId, $endId);
                
                if (!empty($transferRoutes)) {
                    $journeySegments[] = [
                        'type' => 'transfer',
                        'data' => $transferRoutes[0]
                    ];
                    $totalPrice += $transferRoutes[0]['total_price'];
                } else {
                    
                    $journeySegments[] = [
                        'type' => 'not_found',
                        'start' => $startId,
                        'end' => $endId
                    ];
                }
            }
        }
    }

    require_once __DIR__ . '/../Views/home.php';
}
}
