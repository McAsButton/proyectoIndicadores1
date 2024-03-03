<?php
class ControlUsuario{
    var $objUsuario; //Declara el atributo
    function __construct($objUsuario){
        $this->objUsuario = $objUsuario;
    }
    function guardar(){
        $email = $this->objUsuario->getEmail();
        $contrasena = $this->objUsuario->getContrasena();
        $objControlConexion = new ControlConexion();
        $comandoSql = "INSERT INTO usuario (email, contrasena) VALUES ('$email', '$contrasena')";
        $objControlConexion->abrirBd('localhost', 'root', '', 'bdindicadores1', 3306);
        $objControlConexion->ejecutarComandoSql($comandoSql);
        $objControlConexion->cerrarBd();
    }
    function modificar($newContra){
        $email = $this->objUsuario->getEmail();
        $objControlConexion = new ControlConexion();
        $comandoSql = "UPDATE usuario SET 'contrasena'= '$newContra' WHERE 'email' = '$email'";
        $objControlConexion->abrirBd('localhost', 'root', '', 'bdindicadores1', 3306);
        $objControlConexion->ejecutarComandoSql($comandoSql);
        $objControlConexion->cerrarBd();
    }
    function borrar(){
        $email = $this->objUsuario->getEmail();
        $contrasena = $this->objUsuario->getContrasena();
        $objControlConexion = new ControlConexion();
        $comandoSql = "DELETE FROM usuario WHERE 'email' = '$email'";
        $objControlConexion->abrirBd('localhost', 'root', '', 'bdindicadores1', 3306);
        $objControlConexion->ejecutarComandoSql($comandoSql);
        $objControlConexion->cerrarBd();
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