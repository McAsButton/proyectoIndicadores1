<?php
include '../Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlUnidadMedicion{
    var $objUnidadMedicion;

    function __construct($objUnidadMedicion){
        $this->objUnidadMedicion=$objUnidadMedicion;
    }
    
    function consultar(){
        $id=$this->objUnidadMedicion->getId();
        $descripcion=$this->objUnidadMedicion->getDescripcion();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); 
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("SELECT * FROM unidadmedicion WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function agregar(){
        $id=$this->objUnidadMedicion->getId();
        $descripcion=$this->objUnidadMedicion->getDescripcion();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); 
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("INSERT INTO unidadmedicion (nombre, descripcion) VALUES (:id, :nombre, :descripcion)"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':descripcion', $descripcion); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function modificar(){
        $id=$this->objUnidadMedicion->getId();
        $descripcion=$this->objUnidadMedicion->getDescripcion();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']);
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("UPDATE unidadmedicion SET descripcion=:descripcion WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':descripcion', $descripcion); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function eliminar(){
        $id=$this->objUnidadMedicion->getId();
        $descripcion=$this->objUnidadMedicion->getDescripcion();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']);
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("DELETE FROM unidadmedicion WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

}
?>