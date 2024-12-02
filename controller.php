<?php

require_once('bd.php');

if (isset($_POST['insert'])) {

    registrarse($_POST['nom'], $_POST['correu'], $_POST['contrasenya']);

    header('Location: index.php');

    exit();
}
