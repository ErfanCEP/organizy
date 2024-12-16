<?php

session_start();

require_once('bd.php');

if (isset($_POST['insert'])) {

    registrarse($_POST['nom'], $_POST['correu'], $_POST['contrasenya']);

    header('Location: log_in.php');

    exit();
}

if (isset($_POST['iniciar_sessio'])) {

    $username = iniciar_sessio($_POST['correu'], $_POST['contrasenya']);

    if ($username != "noTrobat") {
        $_SESSION['username'] = $username;
        header('Location: index.php');
    } else {
        header('Location: log_in.php');
    }

    exit();
}

if (isset($_POST['crear_projecte'])) {

    crear_projecte($_POST['nom'], $_POST['descripcio']);

    header('Location: index.php');

    exit();
}
