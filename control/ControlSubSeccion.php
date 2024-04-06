<?php
include '../Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlSubSeccion{
    var $objSubSeccion;

    function __construct($objSubSeccion){
        $this->objSubSeccion=$objSubSeccion;
    }
    
    function consultar(){
        $id=$this->objSubSeccion->getId();
        $nombre=$this->objSubSeccion->getNombre();
        $idSeccion=$this->objSubSeccion->getIdSeccion();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("SELECT * FROM subseccion WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function agregar(){
        $id=$this->objSubSeccion->getId();
        $nombre=$this->objSubSeccion->getNombre();
        $idSeccion=$this->objSubSeccion->getIdSeccion();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("INSERT INTO subseccion (nombre, idSeccion) VALUES (:id, :nombre, :idSeccion)"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':nombre', $nombre);
        $comandoSql->bindParam(':idSeccion', $idSeccion); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function modificar(){
        $id=$this->objSubSeccion->getId();
        $nombre=$this->objSubSeccion->getNombre();
        $idSeccion=$this->objSubSeccion->getIdSeccion();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("UPDATE subseccion SET nombre=:nombre, idSeccion=:idSeccion WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':nombre', $nombre);
        $comandoSql->bindParam(':idSeccion', $idSeccion); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function eliminar(){
        $id=$this->objSubSeccion->getId();
        $nombre=$this->objSubSeccion->getNombre();
        $idSeccion=$this->objSubSeccion->getIdSeccion();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("DELETE FROM subseccion WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

}
?>