<?php
require 'config.php';

function getRandomActivities()
{
    header('Access-Control-Allow-Origin: *');
    header("Content-Type: application/json");

    global $pdo;

    // La seule méthode autorisée est GET
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode(["error" => "Methode HTTP non autorisée"]);
        exit();
        }

    try {
        $stmt = $pdo->query("SELECT * FROM activities ORDER BY RAND() LIMIT 4");
        echo json_encode($stmt->fetchAll());
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erreur SQL : " . $e->getMessage()]);
    }
}
