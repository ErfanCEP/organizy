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

function registrarse($nom, $cognom, $correu, $contrasenya)
{

    $conexion = openBd();

    $ordenBD = "insert into usuaris ( nom, cognom, correu,  contrasenya) values (:nom, :cognom, :correu, :contrasenya)";
    $stmt = $conexion->prepare($ordenBD);
    $stmt->bindParam(':correu', $correu);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':cognom', $cognom);
    $stmt->bindParam(':contrasenya', $contrasenya);
    $stmt->execute();

    $conexion = closeBd();
}

function iniciar_sessio($correu, $contrasenya)
{

    try {

        $conexion = openBd();

        $ordenBD = "select id_usuari, nom, correu from usuaris where correu = :correu and contrasenya = :contrasenya";
        $stmt = $conexion->prepare($ordenBD);
        $stmt->bindParam(':correu', $correu);
        $stmt->bindParam(':contrasenya', $contrasenya);
        $stmt->execute();

        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['usuari'] = $resultat['id_usuari'];

        if ($resultat) {

            return $resultat['id_usuari'];
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
    if (!isset($_SESSION['usuari'])) {
        // Redirigir al usuario si no está autenticado
        header('Location: log_in.php');
        exit;
    }

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

    $id_usuari = $_SESSION['usuari'];

    $ordenBD3 = "insert into crear (id_usuari, id_projecte, id_rol) values (:id_usuari, :id_projecte, :id_rol)";
    $stmt = $conexion->prepare($ordenBD3);
    $stmt->bindParam(':id_usuari', $id_usuari, PDO::PARAM_INT);
    $stmt->bindParam(':id_projecte', $id_projecte_max, PDO::PARAM_INT);
    $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
    $id_rol = 1; // 1 = creador


    $stmt->execute();

    $conexion = closeBd();
}
