<?php
require 'config.php';

function filterActivities() {
    header('Access-Control-Allow-Origin: *');
    header("Content-Type: application/json");

    global $pdo;

    // Vérifie que la requête est bien une requête GET
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        echo json_encode(["error" => "Méthode HTTP incorrecte"]);
        exit();
    }


    try {
        $filters = [];
        // Filtre de base (tous)
        $query = "SELECT activities.id, activities.name, activities.description, activities.image, 
                        levels.name AS level, coaches.name AS coach, locations.name AS location, 
                        activities.schedule_day
                FROM activities
                JOIN levels ON activities.level_id = levels.id
                JOIN locations ON activities.location_id = locations.id
                JOIN coaches ON activities.coach_id = coaches.id
                WHERE 1=1";

        // Ajoute des restrictions à la requête SQL en fonction des filtres choisis
        if (!empty($_GET['level']) && $_GET['level'] !== "Tous") {
            $query .= " AND levels.name = :level";
            $filters['level'] = $_GET['level'];
        }
        if (!empty($_GET['location']) && $_GET['location'] !== "Tous") {
            $query .= " AND locations.name = :location";
            $filters['location'] = $_GET['location'];
        }
        if (!empty($_GET['coach']) && $_GET['coach'] !== "Tous") {
            $query .= " AND coaches.name = :coach";
            $filters['coach'] = $_GET['coach'];
        }
        if (!empty($_GET['day']) && $_GET['day'] !== "Tous") {
            $query .= " AND activities.schedule_day = :day";
            $filters['day'] = $_GET['day'];
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($filters);
        $results = $stmt->fetchAll();

        echo json_encode($results);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erreur SQL : " . $e->getMessage()]);
    }
}
?>