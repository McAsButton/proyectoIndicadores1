<?php
include 'Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlUsuario{
    var $objUsuario; //Declara el atributo objUsuario
    function __construct($objUsuario){ //Constructor de la clase
        $this->objUsuario = $objUsuario;
    }
    function consultar(){ //Funcion para consultar los usuarios
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar(); //Conecta a la base de datos
        $comandoSql = $pdo->prepare("SELECT * FROM usuario"); //Prepara la consulta SQL
        $comandoSql->execute(); //Ejecuta la consulta SQL
        $conexionBD->desconectar(); //Desconecta de la base de datos
        return $comandoSql->fetchAll(PDO::FETCH_ASSOC); //Retorna los datos de la consulta
    }
    function guardar(){ //Funcion para guardar un usuario
        $email = $this->objUsuario->getEmail(); //Obtiene el email del objeto
        $contrasena = $this->objUsuario->getContrasena(); //Obtiene la contraseña del objeto
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar(); //Conecta a la base de datos
        $comandoSql = $pdo->prepare("INSERT INTO usuario (email, contrasena) VALUES ('$email', '$contrasena')"); //Prepara la consulta SQL
        $comandoSql->execute(); //Ejecuta la consulta SQL
        $conexionBD->desconectar(); //Desconecta de la base de datos
    }
    function modificar(){ //Funcion para modificar un usuario
        $email = $this->objUsuario->getEmail(); //Obtiene el email del objeto
        $newContra = $this->objUsuario->getContrasena(); //Obtiene la contraseña del objeto
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar(); //Conecta a la base de datos
        $comandoSql = $pdo->prepare("UPDATE usuario SET contrasena = '$newContra' WHERE email = '$email'"); //Prepara la consulta SQL
        $comandoSql->execute(); //Ejecuta la consulta SQL
        $conexionBD->desconectar(); //Desconecta de la base de datos
    }
    function borrar($email){ //Funcion para borrar un usuario
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar(); //Conecta a la base de datos
        $comandoSql = $pdo->prepare("DELETE FROM usuario WHERE email = '$email'"); //Prepara la consulta SQL
        $comandoSql->execute(); //Ejecuta la consulta SQL
        $conexionBD->desconectar(); //Desconecta de la base de datos
    }
}
?>