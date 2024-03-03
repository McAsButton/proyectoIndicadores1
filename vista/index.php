<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="miStyle.css">
    <script src="https://kit.fontawesome.com/6bd681ef8c.js" crossorigin="anonymous"></script>
</head>
<body>
    <div>
        <div>
            <h1>Usuarios</h1>
        </div>
        <div>
            <form method="post" action="VistasUsuario.php" enctype="multipart/formdata">
                    <button onclick="location.href='VistasUsuario.php'" name="Nuevo"><i class="fa-solid fa-user-plus"></i></button>
            </form>
        </div>
        <div>
            <table>
                <tr>
                    <th>email</th>
                </tr>
                <?php
                include '../control/Conexion.php';
                $conexionBD = new ConexionBD("mysql:dbname=bdindicadores1;host=127.0.0.1", "root", "");
                $pdo = $conexionBD->conectar();
                $comandoSql = $pdo->prepare("SELECT email from usuario");
                $comandoSql->execute();
                
                while($datos = $comandoSql->fetchAll(PDO::FETCH_ASSOC)){ 
                    foreach ($datos as $dato) {
                ?>
                <tr>
                    <td><?= $dato['email'] ?></td>
                    <td>
                        <form action="VistasUsuario.php" method="POST">
                            <input type="hidden" name="email" value="<?= $dato['email'] ?>">
                            <input type="hidden" name="action" value="modify">
                            <button type="submit" name="modificar"><i class="fa-solid fa-pen"></i></button>
                        </form>
                    </td>
                    <td><button onclick="" name="<?= $dato['email'] ?>" ><i class="fa-solid fa-trash"></i></buttont></td>
                </tr>            
                <?php
                    }
                $conexionBD->desconectar();
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>