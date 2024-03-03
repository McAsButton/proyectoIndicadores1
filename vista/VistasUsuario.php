<?php
include '../control/ControlUsuario.php';
include '../modelo/Usuario.php';

$email = isset($_POST['email']) ? $_POST['email'] : '';
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

if(isset($_POST['action']) && $_POST['action'] == 'modify'){
    $objUsuario = new Usuario($_POST['email'], $_POST['contrasena']);
    $controlUsuario = new ControlUsuario($objUsuario);
    $controlUsuario->modificar($objUsuario->getContrasena());
}else {
    $objUsuario = new Usuario($_POST['email'], $_POST['contrasena']);
    $controlUsuario = new ControlUsuario($objUsuario);
    $controlUsuario->guardar();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
    <link rel="stylesheet" href="miStyle.css">
    <script src="https://kit.fontawesome.com/6bd681ef8c.js" crossorigin="anonymous"></script>
</head>
<body>
    <div>
        <div>
            <h1>Nuevo Usuario</h1>
        </div>
        <div>
            <form method="get" action="index.php" enctype="multipart/formdata">
                <table>
                    <tr>
                        <th>email</th>
                        <td><input type="email" name='email' value="<?= $email ?>" <?= isset($_POST['action']) && $_POST['action'] == 'modify' ? 'disabled' : '' ?>></td>
                    </tr>
                    <tr>
                        <th>Contraseña</th>
                        <td><input type="password" name='contrasena'></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <button type="submit" formmethod="post" name="guardar"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                            <button type="button" onclick="window.history.back();" name="cancelar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                        </td>
                    </tr>            
                </table>
            </form>
        </div>
    </div>
</body>
</html>