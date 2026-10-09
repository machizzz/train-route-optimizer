<?php

namespace App\Models;

use PDO;

class Connection 
{

    public static function findDirectRoute($startId, $endId) 
    {
           $db = Database::getConnection();
        
$sql = "SELECT 
            c.departure_time, 
            c.arrival_time, 
            c.price,
            s1.name AS start_station_name, 
            s2.name AS end_station_name
        FROM connections c
        JOIN stations s1 ON c.station_start_id = s1.id
        JOIN stations s2 ON c.station_end_id = s2.id
        WHERE c.station_start_id = :start_id AND c.station_end_id = :end_id";

        $stmt = $db->prepare($sql);
        

        $stmt->execute([
            ':start_id' => $startId,
            ':end_id' => $endId
        ]);
        

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findRouteWithOneTransfer($startId, $endId)
{
    $db = Database::getConnection();
    
$sql = "SELECT 
                s_start.name AS start_station_name,
                s_mid.name AS transfer_station_name,
                s_end.name AS end_station_name,
                c1.departure_time AS leg1_departure,
                c1.arrival_time AS leg1_arrival,
                c2.departure_time AS leg2_departure,
                c2.arrival_time AS leg2_arrival,
                TIMEDIFF(c2.departure_time, c1.arrival_time) AS transfer_time,
                (c1.price + c2.price) AS total_price
            FROM connections c1
            JOIN connections c2 ON c1.station_end_id = c2.station_start_id
            JOIN stations s_start ON c1.station_start_id = s_start.id
            JOIN stations s_mid ON c1.station_end_id = s_mid.id
            JOIN stations s_end ON c2.station_end_id = s_end.id
            WHERE c1.station_start_id = :start_id 
              AND c2.station_end_id = :end_id
              AND c2.departure_time >= c1.arrival_time";
              
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':start_id' => $startId,
        ':end_id' => $endId
    ]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}