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
}
?>