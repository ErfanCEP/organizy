<?php

function openBd()
{

    $servername = "localhost";
    $username = "root";
    $password = "mysql";

    $conexion = new PDO("mysql:host=$servername;dbname=organizy", $username, $password);

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("set names utf8");

    return $conexion;

    echo "Connection failed:";
}

function closeBd()
{

    return null;
}

function registrarse($nom, $correu, $contrasenya)
{

    $conexion = openBd();

    $ordenBD = "insert into usuaris ( nom, correu,  contrasenya) values (:nom, :correu, :contrasenya)";
    $stmt = $conexion->prepare($ordenBD);
    $stmt->bindParam(':correu', $correu);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':contrasenya', $contrasenya);
    $stmt->execute();

    $conexion = closeBd();
}

function iniciar_sessio($correu, $contrasenya)
{

    try {

        $conexion = openBd();

        $ordenBD = "select nom, correu from usuaris where correu = :correu and contrasenya = :contrasenya";
        $stmt = $conexion->prepare($ordenBD);
        $stmt->bindParam(':correu', $correu);
        $stmt->bindParam(':contrasenya', $contrasenya);
        $stmt->execute();

        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

        $usuari = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['usuari'] = $usuari['id_usuari'];

        $conexion = closeBd();

        if ($resultat) {

            return $resultat['nom'];
        } else {

            return "noTrobat";
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
        return false;
    }
}

function crear_projecte($nom, $descripcio)
{

    $conexion = openBd();

    //Insert de projectes a la taula projectes

    $ordenBD = "insert into projectes ( nom, descripcio) values (:nom, :descripcio) ";
    $stmt = $conexion->prepare($ordenBD);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':descripcio', $descripcio);
    $stmt->execute();

    $ordenBD2 = "select max(id_projecte) from projectes";
    $stmt = $conexion->prepare($ordenBD2);
    $stmt->execute();
    $resultat = $stmt->fetch();
    $id_projecte_max = $resultat[0];


    //Insert de projecte a la taula ternaria de crear

    $usuari = $_SESSION['usuari'];
    $ordenBD3 = "insert into crear (id_usuari, id_projecte, id_rol) values (:id_usuari, :id_projecte, 1)";
    $stmt = $conexion->prepare($ordenBD3);
    $stmt->bindParam(':id_usuari', $usuari);
    $stmt->bindParam(':id_projecte', $id_projecte_max); // Usar el valor correcto para id_projecte

    $stmt->execute();

    $conexion = closeBd();
}

function mostrar_projectes()
{
    // Abrimos la conexión a la base de datos
    $conexion = openBd();

    // Consulta SQL con parámetros
    $sql = "SELECT 
                    p.id_projecte, 
                    p.nom AS nom_projecte, 
                    p.descripcio AS descripcio_projecte, 
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
}
