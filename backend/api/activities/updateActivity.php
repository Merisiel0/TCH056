<?php
require 'config.php';

function updateActivity() {

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');


  global $pdo;

  function isBlank($value) {
    return !isset($value) || $value === "";
    }

  // Vérifier que la méthode est bien PUT
  if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
      http_response_code(405);
      echo json_encode(["error" => "Méthode HTTP non autorisée"]);
      exit();
  }

  // Lire les données envoyées en JSON
  $input = json_decode(file_get_contents("php://input"), true);
  if (!$input) {
      http_response_code(400);
      echo json_encode(["error" => "Input JSON invalide"]);
      exit();
  }

  // Vérifier si l'ID est valide dans l'URL
  preg_match('/\/api\/activities\/([0-9]+)/', $_SERVER['REQUEST_URI'], $matches);
  if (!isset($matches[1]) || !is_numeric($matches[1])) {
      http_response_code(400);
      echo json_encode(["error" => "ID d'activité invalide"]);
      exit();
  }

  $activityId = intval($matches[1]);

  // Vérifier que tous les champs nécessaires sont bien envoyés
  $requiredFields = ['name', 'description', 'image', 'level_name', 'coach_name', 'schedule_day', 'schedule_time', 'location_name'];
  foreach ($requiredFields as $field) {
      if (isBlank($input[$field])) {
          http_response_code(400);
          echo json_encode(["error" => "Champs manquants: $field"]);
          exit();
      }
  }

  // 🔍 Fonction pour récupérer l'ID à partir du nom, et insérer si non existant
  function getOrCreateId($table, $column, $value) {
      global $pdo;
      
      // Vérifier si l'élément existe déjà
      $stmt = $pdo->prepare("SELECT id FROM $table WHERE $column = :value LIMIT 1");
      $stmt->execute(['value' => $value]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($result) {
          return $result['id'];
      }
      
      // Insérer un nouvel élément s'il n'existe pas
      $insertStmt = $pdo->prepare("INSERT INTO $table ($column) VALUES (:value)");
      $insertStmt->execute(['value' => $value]);
      
      return $pdo->lastInsertId(); // Retourner le nouvel ID
  }

  // Récupérer ou créer les ID nécessaires
  $levelId = getOrCreateId('levels', 'name', $input['level_name']);
  $coachId = getOrCreateId('coaches', 'name', $input['coach_name']);
  $locationId = getOrCreateId('locations', 'name', $input['location_name']);

  // Mise à jour de l'activité
  $sql = "UPDATE activities SET 
      name = :name, 
      description = :description, 
      image = :image, 
      level_id = :level_id, 
      coach_id = :coach_id, 
      schedule_day = :schedule_day, 
      schedule_time = :schedule_time, 
      location_id = :location_id
  WHERE id = :id";

  $stmt = $pdo->prepare($sql);
  $success = $stmt->execute([
      ':name' => $input['name'],
      ':description' => $input['description'],
      ':image' => $input['image'],
      ':level_id' => $levelId,
      ':coach_id' => $coachId,
      ':schedule_day' => $input['schedule_day'],
      ':schedule_time' => $input['schedule_time'],
      ':location_id' => $locationId,
      ':id' => $activityId
  ]);

  if ($success) {
      echo json_encode(["success" => "Activité modifiée!"]);
  } else {
      http_response_code(500);
      echo json_encode(["error" => "Échec de modification de l'activité"]);
  }
}
?>
