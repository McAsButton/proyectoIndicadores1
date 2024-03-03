<?php
include '../modelo/Usuario.php'; //Incluye el archivo Usuario.php
include '../control/ControlUsuario.php'; //Incluye el archivo ControlUsuario.php
include '../control/ControlConexion.php'; //Incluye el archivo ControlConexion.php
$objUsuario = new Usuario("masa@correo.com", "123"); //Instancia la clase Usuario
$controlUsuario = new ControlUsuario($objUsuario);
$controlUsuario->guardar();
?>