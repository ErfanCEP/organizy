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
                <img src="./img/logo_mov.gif" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                <span class="text-primary">organIZY</span>
            </a>
            <button type="button" class="btn btn-success" onclick="window.location.href='form_projecte.php'">Crear Projecte</button>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Listado de Proyectos</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php

                require_once 'bd.php';


                $proyectos = mostrar_projectes('%', '%');

                // Verificamos si hay resultados
                if (!empty($proyectos)) {
                    foreach ($proyectos as $proyecto) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($proyecto['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($proyecto['descripcio']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='text-center'>No hay proyectos disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>







    <script src="bootstrap-5.3.3/dist/js/bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>