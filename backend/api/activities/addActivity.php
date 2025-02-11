<?php
require 'config.php';

function addActivity() {

    header('Access-Control-Allow-Origin: *');
    header("Content-Type: application/json");


    global $pdo;

    // Vérifie que la requête est bien une requête POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
        http_response_code(405);
        echo json_encode(["error" => "Method HTTP non autorisée"]);
        exit();
    }

    // Récupération des données envoyées
    $input = json_decode(file_get_contents('php://input'), true);



    // Vérification que tous les champs nécessaires sont présents
    if (!isset(
        $input['name'],
        $input['description'],
        $input['image'],
        $input['level_name'],
        $input['coach_name'],
        $input['schedule_day'],
        $input['schedule_time'],
        $input['location_name']
    )) {
        http_response_code(400);
        echo json_encode(["error" => "Champs manquants"]);
        exit();
    }

    try {
        $pdo->beginTransaction();

        // Vérifier si le niveau existe, sinon l'ajouter
        $stmt = $pdo->prepare("SELECT id FROM levels WHERE name = :level_name");
        $stmt->execute(['level_name' => $input['level_name']]);
        $level_id = $stmt->fetchColumn();

        if (!$level_id) {
            $stmt = $pdo->prepare("INSERT INTO levels (name) VALUES (:level_name)");
            $stmt->execute(['level_name' => $input['level_name']]);
            $level_id = $pdo->lastInsertId();
        }

        // Vérifier si le coach existe, sinon l'ajouter
        $stmt = $pdo->prepare("SELECT id FROM coaches WHERE name = :coach_name");
        $stmt->execute(['coach_name' => $input['coach_name']]);
        $coach_id = $stmt->fetchColumn();

        if (!$coach_id) {
            $stmt = $pdo->prepare("INSERT INTO coaches (name) VALUES (:coach_name)");
            $stmt->execute(['coach_name' => $input['coach_name']]);
            $coach_id = $pdo->lastInsertId();
        }

        // Vérifier si le lieu existe, sinon l'ajouter
        $stmt = $pdo->prepare("SELECT id FROM locations WHERE name = :location_name");
        $stmt->execute(['location_name' => $input['location_name']]);
        $location_id = $stmt->fetchColumn();

        if (!$location_id) {
            $stmt = $pdo->prepare("INSERT INTO locations (name) VALUES (:location_name)");
            $stmt->execute(['location_name' => $input['location_name']]);
            $location_id = $pdo->lastInsertId();
        }

        // Insérer la nouvelle activité
        $stmt = $pdo->prepare("
            INSERT INTO activities (name, description, image, level_id, coach_id, schedule_day, schedule_time, location_id) 
            VALUES (:name, :description, :image, :level_id, :coach_id, :schedule_day, :schedule_time, :location_id)
        ");

        $stmt->execute([
            'name' => $input['name'],
            'description' => $input['description'],
            'image' => $input['image'],
            'level_id' => $level_id,
            'coach_id' => $coach_id,
            'schedule_day' => $input['schedule_day'],
            'schedule_time' => $input['schedule_time'],
            'location_id' => $location_id
        ]);

        $pdo->commit();

        http_response_code(201);
        echo json_encode(["message" => "Activité ajoutée avec succès !"]);

    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(["error" => "Erreur SQL : " . $e->getMessage()]);
    }
}
?>
