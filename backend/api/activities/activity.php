<?php
require 'config.php';

function activity() {
    header('Access-Control-Allow-Origin: *');
    header("Content-Type: application/json");

    global $pdo;

    // La seule méthode autorisée est GET
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Methode HTTP non autorisée"]);
    exit();
    }

    preg_match('/\/api\/activities\/([0-9]+)/', $_SERVER['REQUEST_URI'], $matches);
    if (!isset($matches[1])) {
        http_response_code(400);
        echo json_encode(["error" => "ID d'activité invalide"]);
        exit;
    }

    $activityId = $matches[1];

    // Récupère une activité de la DB.
    $sql = "SELECT A.*, L.name AS level_name, C.name AS coach_name, LO.name AS location_name 
    FROM activities A 
    INNER JOIN levels L ON A.level_id=L.id 
    INNER JOIN coaches C ON A.coach_id=C.id 
    INNER JOIN locations LO ON A.location_id=LO.id 
    WHERE A.id = :i";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":i", $activityId);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if ($result) {
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Activité non trouvée"]);
    }
}

?>
