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
}