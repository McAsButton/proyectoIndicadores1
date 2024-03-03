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
            <table>
                <tr>
                    <th>email</th>
                    <th><input type="email" name='email'></th>
                </tr>
                <tr>
                    <td>Contraseña</td>
                    <td><input type="password" name='contrasena'></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><button type="submit"><i class="fa-solid fa-floppy-disk"></i></button></td>
                    <td style="text-align: center;"><button onclick="location.href='index.php'"><i class="fa-solid fa-xmark"></i></button></td>
                </tr>            
            </table>
        </div>
    </div>
</body>
</html>