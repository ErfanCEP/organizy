<?php

session_start();
$id_projecte = $_GET['id_projecte'];

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
        <div id="usuaris-container" class="mt-4" >
            <h3>Usuaris del projecte</h3>
            <div id="usuaris-botons" data-projecte="<?php echo $id_projecte; ?>"></div>
        </div>

    </div>

    

    <script src="crear_projecte.js"></script>
    <script src="bootstrap-5.3.3/dist/js/bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="gestionar.js"></script>
    <script>
    const idUsuari = <?php echo json_encode($_SESSION['usuari']); ?>;
</script>
</body>

</html>