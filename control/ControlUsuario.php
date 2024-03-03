<?php
include 'Conexion.php';
class ControlUsuario{
    var $objUsuario; //Declara el atributo
    function __construct($objUsuario){
        $this->objUsuario = $objUsuario;
    }
    function guardar(){
        $email = $this->objUsuario->getEmail();
        $contrasena = $this->objUsuario->getContrasena();
        $conexionBD = new ConexionBD("mysql:dbname=bdindicadores1;host=127.0.0.1", "root", "");
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("INSERT INTO usuario (email, contrasena) VALUES ('$email', '$contrasena')");
        $comandoSql->execute();
        $conexionBD->desconectar();
    }
    function modificar($newContra){
        $email = $this->objUsuario->getEmail();
        $conexionBD = new ConexionBD("mysql:dbname=bdindicadores1;host=127.0.0.1", "root", "");
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("UPDATE usuario SET contrasena = '$newContra' WHERE email = '$email'");
        $comandoSql->execute();
        $conexionBD->desconectar();
    }
    function borrar(){
        $email = $this->objUsuario->getEmail();
        $conexionBD = new ConexionBD("mysql:dbname=bdindicadores1;host=127.0.0.1", "root", "");
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("DELETE FROM usuario WHERE 'email' = '$email'");
        $comandoSql->execute();
        $conexionBD->desconectar();
    }
    function consultar(){
        //$email = $this->objUsuario->getEmail();
        $objControlConexion = new ControlConexion();
        $comandoSql = "SELECT email from 'usuario'";
        $objControlConexion->abrirBd('localhost', 'root', '', 'bdindicadores1', 3306);
        $result = $objControlConexion->ejecutarComandoSql($comandoSql);
        $objControlConexion->cerrarBd();
        return $result;
    }
}
?>