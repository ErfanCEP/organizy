<?php

require_once("../bd.php");

header('Content-Type: application/json');

if (!isset($_POST['id_tasca']) || !isset($_POST['id_estat'])) {
    echo json_encode(['success' => false, 'message' => 'Falten paràmetres.']);
    exit;
}

$id_tasca = intval($_POST['id_tasca']);
$id_estat = intval($_POST['id_estat']);

try {
    $conn = openBd();
    $sql = "UPDATE tasques SET id_estat = :id_estat WHERE id_tasca = :id_tasca";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_estat', $id_estat, PDO::PARAM_INT);
    $stmt->bindParam(':id_tasca', $id_tasca, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Estat actualitzat correctament.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No s\'ha pogut actualitzar l\'estat.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

