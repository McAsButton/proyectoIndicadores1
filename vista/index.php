<?php
include '../control/ControlUsuario.php';
include '../modelo/Usuario.php';

$objUsuario = new Usuario("", "");
$controlUsuario = new ControlUsuario($objUsuario);
$comandoSql = $controlUsuario->consultar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $action = $_POST["action"];

    if (!empty($email)) {
        if($action == 'delete'){
            // Mostrar un formulario de confirmación en el navegador
            echo '<form id="confirmationForm" method="post" action="index.php">';
            echo '  <input type="hidden" name="email" value="' . $email . '">';
            echo '  <input type="hidden" name="contrasena" value="' . $contrasena . '">';
            echo '  <input type="hidden" name="action" value="confirm_delete">';
            echo '</form>';
            echo '<script>';
            echo '  if(confirm("¿Realmente desea eliminar este usuario?")) {';
            echo '    document.getElementById("confirmationForm").submit();';
            echo '  } else {';
            echo '    window.location.href = "index.php";';
            echo '  }';
            echo '</script>';
            exit();
        } else if ($action == 'confirm_delete') {
            // Acción de eliminar usuario en la base de datos
            $objUsuario = new Usuario($email, $contrasena);
            $controlUsuario = new ControlUsuario($objUsuario);
            $controlUsuario->borrar($email);
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
    <title>Index</title>
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
            <h1>Usuarios</h1>
        </div>
        <br><br><br>
        <div class="row">
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col">
            <form method="post" action="VistaUsuario.php" enctype="multipart/formdata">
                <input type="hidden" name="email" value="">
                <input type="hidden" name="contrasena" value="">
                <input type="hidden" name="action" value="new">
                <button type="submit" class="btn btn-outline-light" name="nuevo"><i class="bi bi-person-add"></i> Nuevo</button> 
            </form>
        </div>
        <div class="col"></div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <table>
                    <tr>
                        <th>email</th>
                    </tr>
                    <?php 
                    foreach ($comandoSql as $dato) {
                    ?>
                    <tr>
                        <td><?= $dato['email'] ?></td>
                        <form method="post" action="VistaUsuario.php" enctype="multipart/formdata">
                            <td>
                                <input type="hidden" name="email" value="<?= $dato['email'] ?>">
                                <input type="hidden" name="contrasena" value="<?= $dato['contrasena'] ?>">
                                <input type="hidden" name="action" value="modify">
                                <button type="submit" class="btn btn-warning" name="modificar"><i class="bi bi-pencil-square"></i></button>
                            </td>
                        </form>
                        <form method="post" action="index.php" enctype="multipart/formdata">
                            <td>
                                <input type="hidden" name="email" value="<?= $dato['email'] ?>">
                                <input type="hidden" name="contrasena" value="<?= $dato['contrasena'] ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-danger" name="delete"><i class="bi bi-trash-fill"></i></buttont>
                            </td>
                        </form>
                    </tr>
                    <?php
                    }
                    ?>       
                </table>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>
</html>