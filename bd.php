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

    $ordenBD = "insert into projectes ( nom, descripcio) values (:nom, :descripcio) ";
    $stmt = $conexion->prepare($ordenBD);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':descripcio', $descripcio);
    $stmt->execute();

    $conexion = closeBd();
}
