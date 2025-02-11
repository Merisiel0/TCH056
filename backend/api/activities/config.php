<?php
$host = "db";
$db = "mydatabase";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$user = "user";
$passwd = "password";

try {
    $pdo = new PDO($dsn, $user, $passwd, $options);
    error_log("Connexion réussie à la base de données");
} catch (PDOException $e) {
    error_log("Erreur de connexion: " . $e->getMessage());
    die(json_encode(["error" => "Erreur de connexion à base de données: " . $e->getMessage()]));
}
?>
