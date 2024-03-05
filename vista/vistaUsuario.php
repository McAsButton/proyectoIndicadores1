<?php
include '../control/ControlUsuario.php';
include '../modelo/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $action = $_POST["action"];

    if (!empty($email)) {
        if($action == 'modificar'){
            $objUsuario = new Usuario($email, $contrasena);
            $controlUsuario = new ControlUsuario($objUsuario);
            $controlUsuario->modificar($contrasena);
            header("Location: index.php");
            exit();
        }elseif($action == 'guardar'){
            $objUsuario = new Usuario($email, $contrasena);
            $controlUsuario = new ControlUsuario($objUsuario);
            $controlUsuario->guardar();
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Usuario</title>

    <!-- Agregar las siguientes lineas para incluir los archivos CSS y JS de Bootstrap: -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Honk&display=swap');
        body{
            background-color:#212529;
            color: #fff;
        }
        h1{
            font-family: 'Honk', system-ui;
        }
    </style>
</head> 
<body>
    <div class="container text-center">
        <br><br>
        <div class="row">
            <h1>Nuevo Usuario</h1>
        </div>
        <br><br>
        <div class="row">
            <div class="col"></div>
            <div class="col"></div>
            <div class="col">
                <form method="post" action="VistaUsuario.php" enctype="multipart/formdata">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="email" name='email' value="<?= $email ?>" <?= isset($_POST['action']) && $_POST['action'] == 'modify' ? 'disabled' : '' ?> class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">**</span>
                        <input type="password" name='contrasena' class="form-control" placeholder="Contraseña" aria-label="Contrasena" aria-describedby="basic-addon1">
                    </div>

                    <?php if(isset($_POST['action']) && $_POST['action'] == 'new'): ?>
                        <input type="hidden" name="action" value="guardar">
                        <button type="submit" class="btn btn-primary" formmethod="post" name="guardar"><i class="bi bi-floppy-fill"></i> Guardar</button>
                        <button type="button" class="btn btn-success" onclick="window.location.href='index.php';" name="cancelar"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                    <?php elseif(isset($_POST['action']) && $_POST['action'] == 'modify'): ?>
                        <input type="hidden" name="email" value="<?= $email ?>">
                        <input type="hidden" name="action" value="modificar">
                        <button type="submit" class="btn btn-warning" formmethod="post" name="modificar"><i class="bi bi-pencil-square"></i> Modificar</button>
                        <button type="button" class="btn btn-success" onclick="window.location.href='index.php';" name="cancelar"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col"></div>
            <div class="col"></div>
        </div>

    </div>
</body>
</html>