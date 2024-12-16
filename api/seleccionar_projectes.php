<?php

require_once("bd.php");

header('Content-Type: application/json');

// Abrimos la conexión a la base de datos
$conexion = openBd();

// Consulta SQL con parámetros
$sql = "SELECT 
                    p.id_projecte, 
                    p.nom, 
                    p.descripcio, 
                    u.nom AS nom_usuari, 
                    u.correu AS correu_usuari
                FROM 
                    projectes p
                INNER JOIN 
                    crear c ON p.id_projecte = c.id_projecte
                INNER JOIN 
                    usuaris u ON c.id_usuari = u.id_usuari
                WHERE 
                    u.id_usuari = :id_usuari";

// Preparamos la consulta
$stmt = $conexion->prepare($sql);

$id_usuari = $_SESSION['usuari'];

// Asignamos el parámetro
$stmt->bindParam(':id_usuari', $id_usuari, PDO::PARAM_INT);

// Ejecutamos la consulta
$stmt->execute();

// Obtenemos los resultados como un array asociativo
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cerramos la conexión
closeBd($conexion);

// Retornamos los resultados
return $resultados;

echo json_decode($resultados);
