<?php
require "conect.php";

$latitude = $_GET['lat'];
$longitude = $_GET['lng'];

$query = $pdo->prepare("
    SELECT nome, preco, latitude, longitude 
    FROM empresas 
    WHERE ST_Distance_Sphere(point(longitude, latitude), point(:longitude, :latitude)) < 50000
");
$query->bindParam(':latitude', $latitude);
$query->bindParam(':longitude', $longitude);
$query->execute();

$empresas = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode(['empresas' => $empresas]);
