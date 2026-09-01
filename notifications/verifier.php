<?php

include("../config/db.php");

date_default_timezone_set("Africa/Douala");

$date = date("Y-m-d");
$heure = date("H:i");

$sql = "SELECT * FROM planifications
        WHERE date_planification = '$date'
        AND TIME_FORMAT(heure_planification, '%H:%i') = '$heure'
        AND statut = 'Planifiée'";

$result = mysqli_query($conn, $sql);

$notifications = [];

if ($result) {

    while ($planification = mysqli_fetch_assoc($result)) {

        $notifications[] = [
            "id" => $planification["id"],
            "client" => $planification["client"],
            "technicien" => $planification["technicien"],
            "heure" => $planification["heure_planification"]
        ];

    }

}

header("Content-Type: application/json");

echo json_encode($notifications);

?>