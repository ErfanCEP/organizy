<?php
require_once("../bd.php");

try {
    // Verificar si s'ha proporcionat l'ID de l'usuari
    if (!isset($_GET['id_usuari'])) {
        throw new Exception("Falta l'ID de l'usuari.");
    }

    $id_usuari = intval($_GET['id_usuari']);

    // Obrir la connexió a la base de dades
    $conexion = openBd();

    // Consulta per obtenir les tasques agrupades per col·laborador
        $sql = "SELECT t.id_usuari, t.id_tasca, t.nom AS nom_tasca, t.descripcio, t.data_inici, t.data_fi, 
               p.nom AS nom_projecte, e.nom AS estat, tp.nom AS tipus, u.nom as nom_usuari
                FROM tasques t
                INNER JOIN projectes p ON t.id_projecte = p.id_projecte
                INNER JOIN usuaris u ON t.id_usuari = u.id_usuari
                INNER JOIN estats e ON t.id_estat = e.id_estat
                LEFT JOIN tipus tp ON t.id_tipus = tp.id_tipus
                WHERE t.id_usuari = :id_usuari";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_usuari', $id_usuari, PDO::PARAM_INT);
      //  $stmt->bindParam(':id_projecte', $id_projecte, PDO::PARAM_INT);
        $stmt->execute();

    // Obtenir els resultats
    $tasques = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Agrupar les tasques per col·laborador
    $resultat = [];
    foreach ($tasques as $tasca) {
        $idUsuari = $tasca['id_usuari'];
        if (!isset($resultat[$idUsuari])) {
            $resultat[$idUsuari] = [
                'id_usuari' => $tasca['id_usuari'],
                'nom_usuari' => $tasca['nom_usuari'],
                'tasques' => []
            ];
        }
        $resultat[$idUsuari]['tasques'][] = [
            'id_tasca' => $tasca['id_tasca'],
            'nom_tasca' => $tasca['nom_tasca'],
            'descripcio' => $tasca['descripcio'],
            'data_inici' => $tasca['data_inici'],
            'data_fi' => $tasca['data_fi'],
            'nom_projecte' => $tasca['nom_projecte'],
            'estat' => $tasca['estat'],
            'tipus' => $tasca['tipus']
        ];
    }

    // Retornar les dades agrupades en format JSON
    echo json_encode(array_values($resultat));
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["error" => $e->getMessage()]);
}