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
    <div class="container bg-primary inici d-flex justify-content-center align-items-center vh-100 vw-100">
        <div class="row">
            <div class="col">
                <img src="./img/logo_mov.gif"></img>
            </div>
            <div class="col bg-warning rounded-2">
                <h2 class=" benvingut fw-bold text-center py-5 ps-5 pe-5 lletra_blanca">REGISTRA'T</h2>
                <form action="controller.php" method="POST">
                    <div class="mb-4">
                        <label for="nom" class="form-label lletra_blanca">Nom</label>
                        <input type="text" class="form-control" name="nom">
                    </div>
                    <div class="mb-4">
                        <label for="correu" class="form-label lletra_blanca">Correu</label>
                        <input type="email" class="form-control" name="correu">
                    </div>
                    <div class="mb-4">
                        <label for="contrasenya" class="form-label lletra_blanca">Contrasenya</label>
                        <input type="password" class="form-control" name="contrasenya">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-secondary" name="insert">Registrar-se</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="bootstrap-5.3.3/dist/js/bootstrap.bundle.js"></script>
</body>

</html>