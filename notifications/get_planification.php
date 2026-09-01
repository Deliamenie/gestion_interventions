<?php

include("../config/db.php");

header("Content-Type: application/json");

$sql = "
    SELECT
        id,
        date_planification,
        heure_planification,
        client,
        technicien,
        description
    FROM planifications
    WHERE statut = 'Planifiée'
    ORDER BY date_planification ASC, heure_planification ASC
";

$result = mysqli_query($conn, $sql);

$planifications = [];

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {

        $planifications[] = $row;

    }

}

echo json_encode([
    "success" => true,
    "planifications" => $planifications
]);

?>