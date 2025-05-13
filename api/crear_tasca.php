<?php
require_once("../bd.php");

try {
    // Verificar si s'han proporcionat les dades necessàries
    if (!isset($_POST['id_projecte']) || !isset($_POST['id_usuari']) || !isset($_POST['nom_tasca']) || !isset($_POST['id_estat'])) {
        throw new Exception("Falten dades necessàries.");
    }

    // Assignar els valors dels camps obligatoris
    $id_projecte = intval($_POST['id_projecte']);
    $id_usuari = intval($_POST['id_usuari']);
    $nom_tasca = $_POST['nom_tasca'];
    $id_estat = intval($_POST['id_estat']);

    // Assignar els valors dels camps opcionals
    $descripcio = isset($_POST['descripcio']) ? $_POST['descripcio'] : null;
    $id_tipus = isset($_POST['id_tipus']) ? intval($_POST['id_tipus']) : null;
    $data_inici = isset($_POST['data_inici']) ? $_POST['data_inici'] : null;
    $data_fi = isset($_POST['data_fi']) ? $_POST['data_fi'] : null;

    // Obrir la connexió a la base de dades
    $conexion = openBd();

    // Inserir la tasca a la base de dades
    $sql = "INSERT INTO tasques (nom, descripcio, id_usuari, id_projecte, id_estat, id_tipus, data_inici, data_fi) 
            VALUES (:nom, :descripcio, :id_usuari, :id_projecte, :id_estat, :id_tipus, :data_inici, :data_fi)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nom', $nom_tasca, PDO::PARAM_STR);
    $stmt->bindParam(':descripcio', $descripcio, PDO::PARAM_STR);
    $stmt->bindParam(':id_usuari', $id_usuari, PDO::PARAM_INT);
    $stmt->bindParam(':id_projecte', $id_projecte, PDO::PARAM_INT);
    $stmt->bindParam(':id_estat', $id_estat, PDO::PARAM_INT);
    $stmt->bindParam(':id_tipus', $id_tipus, PDO::PARAM_INT);
    $stmt->bindParam(':data_inici', $data_inici, PDO::PARAM_STR);
    $stmt->bindParam(':data_fi', $data_fi, PDO::PARAM_STR);
    $stmt->execute();

    // Resposta d'èxit
    echo json_encode(["success" => true, "message" => "Tasca creada correctament."]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}