<?php

require_once("../bd.php");
session_start();

try {
    // Verificar si los datos necesarios están presentes
    if (!isset($_POST['id_projecte']) || !isset($_POST['id_usuari']) || !isset($_POST['id_rol'])) {
        throw new Exception("Faltan datos necesarios.");
    }

    // Obtener los datos del POST
    $id_projecte = $_POST['id_projecte'];
    $id_usuari = $_POST['id_usuari'];
    $id_rol = $_POST['id_rol'];

    // Abrir la conexión a la base de datos
    $conexion = openBd();

    // Realizar el INSERT en la tabla "crear"
    $sql = "INSERT INTO crear (id_projecte, id_usuari, id_rol) VALUES (:id_projecte, :id_usuari, :id_rol)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_projecte', $id_projecte, PDO::PARAM_INT);
    $stmt->bindParam(':id_usuari', $id_usuari, PDO::PARAM_INT);
    $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
    $stmt->execute();

    // Respuesta de éxito
    echo json_encode(["success" => true, "message" => "Col·laborador afegit al projecte."]);
} catch (Exception $e) {
    // Manejo de errores
    http_response_code(400);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}