<?php
require_once("../bd.php");

try {
  
    $id_projecte = intval($_GET['id_projecte']);

    // Abrir la conexión a la base de datos
    $conexion = openBd();

    // Consulta para obtener los usuarios del proyecto
    $sql = "SELECT u.id_usuari, u.nom 
            FROM usuaris u
            INNER JOIN crear c ON u.id_usuari = c.id_usuari
            WHERE c.id_projecte = :id_projecte";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_projecte', $id_projecte, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener los resultados
    $usuaris = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los usuarios en formato JSON
    echo json_encode($usuaris);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["error" => $e->getMessage()]);
}