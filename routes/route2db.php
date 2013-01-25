<?php

include('../db_connect.php');

try {
    resetTable('step');
    resetTable('route');
    $routeId;
    
    $filename = $argv[1];

    $routeKml = simplexml_load_file($filename);
    $routeKml->registerXPathNamespace("maps","http://earth.google.com/kml/2.2");

    //
    // Insert route to Routes table
    //    
    $routeName = $routeKml->xpath("//maps:Document/maps:name");

    foreach ($routeName as $name) {
        echo "Processing route: " . $name . "\n";
        $insertRoute = $db->prepare("INSERT INTO route (title) VALUES(?)");
        $insertRoute->bindParam(1,$name);
        $insertRoute->execute();
        $routeIdQuery = $db->prepare("SELECT id FROM route WHERE title=?");
        $routeIdQuery->bindParam(1,$name);
        $routeIdQuery->execute();
        $routeResult = $routeIdQuery->fetch();
        if (!isset($routeResult['id'])) die("Route id not found!");
        $routeId = $routeResult['id'];
    }

    //
    // Insert coordinates to Steps table
    //    
    $routeCoord = $routeKml->xpath("//maps:LineString/maps:coordinates");

    $step_nbr = 1;
    $prev_lat = 0.0;
    $prev_lng = 0.0;
    $distance = 0.0;
    $heading = 0;
        
    foreach ($routeCoord as $coord) {
        $lines = explode("\n", $coord);
        
        foreach ($lines as $line) {
            $line = trim($line);

            if ($line) {
                // echo $line;
                $pattern = '/(.+),(.+),(.+)/';
                preg_match($pattern, $line, $matches);
                $lng = $matches[1];
                $lat = $matches[2];
                $heading = 0;
                
                if ($step_nbr > 1) {
                    $distance += haversineDistance($prev_lat,$prev_lng,$lat,$lng);                                       
                }
                
                $insertStep = $db->prepare("INSERT INTO step (lat,lng,distance,heading,route) VALUES(?,?,?,?,?)");
                $insertStep->bindParam(1,$lat);
                $insertStep->bindParam(2,$lng);
                $insertStep->bindParam(3,$distance);
                $insertStep->bindParam(4,$heading);
                $insertStep->bindParam(5,$routeId);
                $insertStep->execute();
                
                if ($step_nbr > 1) {
                    // update $heading for previous step
                    $heading = headingTowardsDestination(
                        $prev_lat, $prev_lng, $lat, $lng
                    );
                    $updateHeading = $db->prepare("UPDATE step SET heading=? WHERE lat=? AND lng=?");
                    $updateHeading->bindParam(1,$heading);
                    $updateHeading->bindParam(2,$prev_lat);
                    $updateHeading->bindParam(3,$prev_lng);
                    $updateHeading->execute();
                }
                
                $step_nbr++;
                $prev_lat = $lat;
                $prev_lng = $lng;
            }

        }
    }
    
    $setRouteDistance = $db->prepare("UPDATE route SET length=? WHERE id=?");
    $setRouteDistance->bindParam(1,$distance);
    $setRouteDistance->bindParam(2,$routeId);
    $setRouteDistance->execute();
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

echo "Route added successfully!\n";

function haversineDistance(
    $latitudeFrom,
    $longitudeFrom,
    $latitudeTo,
    $longitudeTo)
{
    $earthRadius = 6371; // km
    $dLat = deg2rad($latitudeTo-$latitudeFrom);
    $dLon = deg2rad($longitudeTo-$longitudeFrom);
    $lat1 = deg2rad($latitudeFrom);
    $lat2 = deg2rad($latitudeTo);

    $a = sin($dLat/2) * sin($dLat/2) +
         sin($dLon/2) * sin($dLon/2) * cos($lat1) * cos($lat2); 
    $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
    $d = round($earthRadius * $c, 3);
    
    return $d;    
}

function headingTowardsDestination(
    $latitude,
    $longitude,
    $latitudeDest,
    $longitudeDest )
{
    $dLon = deg2rad($longitudeDest-$longitude);
    $lat1 = deg2rad($latitude);
    $lat2 = deg2rad($latitudeDest);
    
    $y = sin($dLon) * cos($lat2);
    $x = cos($lat1)*sin($lat2) - sin($lat1)*cos($lat2)*cos($dLon);
    $b = round(rad2deg(atan2($y,$x)));
    
    return $b;
}

function resetTable($table) {
    global $db;
    
    $resetTable = $db->prepare('DELETE FROM ' .$table);
    $resetTable->execute() or die("Failed to reset table: " . $table);
}

?>
