<?php
include 'Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
class ControlUsuario{
    var $objUsuario; //Declara el atributo
    function __construct($objUsuario){
        $this->objUsuario = $objUsuario;
    }
    function consultar(){
        $conexionBD = new ConexionBD("mysql:host=localhost;dbname=bdindicadores1;","root","");
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("SELECT * FROM usuario");
        $comandoSql->execute();
        $conexionBD->desconectar();
        return $comandoSql->fetchAll(PDO::FETCH_ASSOC);
    }
    function guardar(){
        $email = $this->objUsuario->getEmail();
        $contrasena = $this->objUsuario->getContrasena();
        $conexionBD = new ConexionBD("mysql:host=localhost;dbname=bdindicadores1;","root","");
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("INSERT INTO usuario (email, contrasena) VALUES ('$email', '$contrasena')");
        $comandoSql->execute();
        $conexionBD->desconectar();
    }
    function modificar(){
        $email = $this->objUsuario->getEmail();
        $newContra = $this->objUsuario->getContrasena();
        $conexionBD = new ConexionBD("mysql:host=localhost;dbname=bdindicadores1;","root","");
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("UPDATE usuario SET contrasena = '$newContra' WHERE email = '$email'");
        $comandoSql->execute();
        $conexionBD->desconectar();
    }
    function borrar($email){
        $conexionBD = new ConexionBD("mysql:host=localhost;dbname=bdindicadores1;","root","");
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("DELETE FROM usuario WHERE email = '$email'");
        $comandoSql->execute();
        $conexionBD->desconectar();
    }
}
?>