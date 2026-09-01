<?php

include("../config/db.php");

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Aucune donnée reçue"
    ]);
    exit;
}

$endpoint = $data["endpoint"] ?? "";
$p256dh   = $data["keys"]["p256dh"] ?? "";
$auth     = $data["keys"]["auth"] ?? "";

if ($endpoint === "" || $p256dh === "" || $auth === "") {
    echo json_encode([
        "success" => false,
        "message" => "Données incomplètes"
    ]);
    exit;
}

$sql = "INSERT INTO notifications_subscriptions
        (endpoint, p256dh, auth)
        VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur SQL"
    ]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $endpoint,
    $p256dh,
    $auth
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "success" => true,
        "message" => "Abonnement enregistré"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Erreur lors de l'enregistrement"
    ]);
}

mysqli_stmt_close($stmt);