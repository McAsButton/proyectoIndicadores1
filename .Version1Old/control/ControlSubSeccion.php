<?php
include 'Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlSubSeccion{
    var $objSubSeccion;

    function __construct($objSubSeccion){
        $this->objSubSeccion=$objSubSeccion;
    }
    
    function listar(){
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar(); //Conecta a la base de datos
        $comandoSql = $pdo->prepare("SELECT * FROM subseccion"); //Prepara la consulta SQL // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->execute(); //Ejecuta la consulta SQL
        $conexionBD->desconectar(); //Desconecta de la base de datos
        return $comandoSql; //Retorna los datos de la consulta
    }
}
?>