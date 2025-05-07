<?php

require_once("../bd.php");
session_start();

// Abrimos la conexión a la base de datos
$conexion = openBd();

// Consulta SQL con parámetros
$sql = "SELECT  id_usuari, nom FROM usuaris";

// Preparamos la consulta
$stmt = $conexion->prepare($sql);

$id_usuari = $_SESSION['usuari'];

// Ejecutamos la consulta
$stmt->execute();

// Obtenemos los resultados como un array asociativo
$colaboradors = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [
    "current_user_id" => $_SESSION['usuari'],
    "colaboradors" => $colaboradors
];

// // Cerramos la conexión
// closeBd($conexion);

echo json_encode($response);