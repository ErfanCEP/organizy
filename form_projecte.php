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
            <a class="navbar-brand " href="index.php">
                <img src="./img/logo_mov.gif" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                <span class="text-primary">organIZY</span>
            </a>
        </div>
    </nav>

    <form action="controller.php" method="POST">

        <div class="col bg-secondary rounded-2">
            <h2 class=" benvingut fw-bold text-center py-5 ps-5 pe-5 lletra_blanca">CREAR PROJECTE</h2>
            <form action="controller.php" method="POST">
                <div class="mb-4">
                    <label for="nom" class="form-label lletra_blanca">Nom</label>
                    <input type="text" class="form-control sm-4" name="nom" required>
                </div>
                <div class="mb-4">
                    <label for="descripcio" class="form-label lletra_blanca">Descripció (opcional)</label>
                    <input type="text" class="form-control sm-4" name="descripcio">
                </div>
                <div class="">
                    <button type="submit" class="btn btn-info my-4" name="crear_projecte">Crear projecte</button>
                </div>
        </div>
    </form>

    <script src="bootstrap-5.3.3/dist/js/bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>