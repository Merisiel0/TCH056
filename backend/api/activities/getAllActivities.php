<?php
require 'config.php';

function getAllActivities() {


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
        // Requête SQL qui récupère chaque activité
        $query = "
        SELECT 
            a.id,
            a.name,
            a.description,
            a.image,
            a.schedule_day,
            a.schedule_time,
            l.name AS level,
            c.name AS coach,
            lo.name AS location
        FROM activities a
        LEFT JOIN levels l ON a.level_id = l.id
        LEFT JOIN coaches c ON a.coach_id = c.id
        LEFT JOIN locations lo ON a.location_id = lo.id;

    ";

        $stmt = $pdo->query($query);
        $results = $stmt->fetchAll();
        

        echo json_encode($results);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erreur SQL : " . $e->getMessage()]);
    }
}