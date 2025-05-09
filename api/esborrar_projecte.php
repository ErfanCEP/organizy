<?php

require_once("../bd.php");
session_start();

try {

    $id_projecte = intval($_POST['id_projecte']);

    // Abrir la conexión a la base de datos
    $conexion = openBd();

    // Iniciar una transacción para garantizar la integridad de los datos
    $conexion->beginTransaction();

    // Eliminar las tareas asociadas al proyecto
    $sqlTasques = "DELETE FROM tasques WHERE id_projecte = :id_projecte";
    $stmtTasques = $conexion->prepare($sqlTasques);
    $stmtTasques->bindParam(':id_projecte', $id_projecte, PDO::PARAM_INT);
    $stmtTasques->execute();

    // Eliminar las relaciones en la tabla "crear"
    $sqlCrear = "DELETE FROM crear WHERE id_projecte = :id_projecte";
    $stmtCrear = $conexion->prepare($sqlCrear);
    $stmtCrear->bindParam(':id_projecte', $id_projecte, PDO::PARAM_INT);
    $stmtCrear->execute();

    // Eliminar el proyecto
    $sqlProjecte = "DELETE FROM projectes WHERE id_projecte = :id_projecte";
    $stmtProjecte = $conexion->prepare($sqlProjecte);
    $stmtProjecte->bindParam(':id_projecte', $id_projecte, PDO::PARAM_INT);
    $stmtProjecte->execute();

    // Confirmar la transacción
    $conexion->commit();

    // Respuesta de éxito
    echo json_encode(["success" => true, "message" => "Projecte esborrat correctament."]);
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    if ($conexion->inTransaction()) {
        $conexion->rollBack();
    }

    // Respuesta de error
    http_response_code(400);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
