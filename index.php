<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="bootstrap-5.3.3/dist/css/bootstrap.css"> -->
    <link rel="stylesheet" href="bootstrap-5.3.3/scss/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>

</head>

<body>

    <nav class="navbar bg-warning py-20">
        <div class="container-fluid ">
            <a class="navbar-brand " href="#">
                <img src="./img/logo_mov.gif" alt="Logo" width="30" height="24" class="d-inline-block align-text-top" />
                <span class="text-primary">organIZY</span>
            </a>
            <button type="button" class="btn btn-success" onclick="window.location.href='form_projecte.php'">Crear Projecte</button>
        </div>
    </nav>
    <div>


        <?php

        // require_once('api/seleccionar_projectes.php');

        ?>
    </div>



    <div id="card" class="d-flex justify-content-center align-items-center vh-80">
        <div class="card d-flex justify-content-center align-items-center text-center" style=" width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Test</h5>
                <p class="card-text">Test</p>
                <a href="#" class="btn btn-warning">Test</a>
            </div>
        </div>
    </div>

    <script src="crear_projecte.js"></script>
    <script src="bootstrap-5.3.3/dist/js/bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>