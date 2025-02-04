<?php

session_start();

$host = "db";
$db = "mydatabase";
$dsn = "mysql:host=db;dbname=mydatabase";

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$user = "user";
$passwd = "password";

try{
  $conn = new PDO($dsn, $user, $passwd, $options);
}catch(PDOException $e){
  die("Database connection erorr: ".$e->getMessage());
}

function getCoaches(){
  global $conn;
  $result = $conn->query("SELECT * FROM coaches");

  $arr = $result->fetchAll();
  for($i = 0; $i < count($arr); $i++){
    $arr[$i]['name'] = htmlspecialchars($arr[$i]['name']);
  }

  return $arr;
}

function getNiveaux(){
  global $conn;
  $result = $conn->query("SELECT * FROM levels");

  $arr = $result->fetchAll();
  for($i = 0; $i < count($arr); $i++){
    $arr[$i]['name'] = htmlspecialchars($arr[$i]['name']);
  }

  return $arr;
}

function getLieux(){
  global $conn;
  $result = $conn->query("SELECT * FROM locations");

  $arr = $result->fetchAll();
  for($i = 0; $i < count($arr); $i++){
    $arr[$i]['name'] = htmlspecialchars($arr[$i]['name']);
  }

  return $arr;
}

function getActivities() {
  global $conn;

  $query = "
    SELECT 
      a.id, a.name, a.description, a.image, 
      l.name AS level, c.name AS coach, 
      a.schedule_day, a.schedule_time, loc.name AS location
    FROM activities a
    JOIN levels l ON a.level_id = l.id
    JOIN coaches c ON a.coach_id = c.id
    JOIN locations loc ON a.location_id = loc.id
    ORDER BY a.name ASC
  ";

  $stmt = $conn->prepare($query);
  $stmt->execute();
  $arr = $stmt->fetchAll();

  // Sécurisation des données avant affichage
  for ($i = 0; $i < count($arr); $i++) {
    $arr[$i]['name'] = htmlspecialchars($arr[$i]['name']);
    $arr[$i]['description'] = htmlspecialchars($arr[$i]['description']);
    $arr[$i]['image'] = htmlspecialchars($arr[$i]['image']);
    $arr[$i]['level'] = htmlspecialchars($arr[$i]['level']);
    $arr[$i]['coach'] = htmlspecialchars($arr[$i]['coach']);
    $arr[$i]['schedule_day'] = htmlspecialchars($arr[$i]['schedule_day']);
    $arr[$i]['schedule_time'] = htmlspecialchars($arr[$i]['schedule_time']);
    $arr[$i]['location'] = htmlspecialchars($arr[$i]['location']);
  }

  return $arr;
}



function getUsers(){
  global $conn;
  $result = $conn->query("SELECT * FROM users");

  $arr = $result->fetchAll();
  // for($i = 0; $i < count($arr); $i++){
  //   $arr[$i]['first_name'] = htmlspecialchars($arr[$i]['first_name']);
  //   $arr[$i]['last_name'] = htmlspecialchars($arr[$i]['last_name']);
  //   $arr[$i]['username'] = htmlspecialchars($arr[$i]['username']);
  //   $arr[$i]['password'] = htmlspecialchars($arr[$i]['password']);
  // }

  return $arr;
}