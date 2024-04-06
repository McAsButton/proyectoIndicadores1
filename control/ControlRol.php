<?php
include 'Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlRol{
    var $objRol;

    function __construct($objRol){
        $this->objRol=$objRol;
    }
    
    function consultar(){
        $id=$this->objRol->getId();
        $nombre=$this->objRol->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("SELECT * FROM rol WHERE id=:id");
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function agregar(){
        $id=$this->objRol->getId();
        $nombre=$this->objRol->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("INSERT INTO rol (nombre) VALUES (:id, :nombre)");
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':nombre', $nombre);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function modificar(){
        $id=$this->objRol->getId();
        $nombre=$this->objRol->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("UPDATE rol SET nombre=:nombre WHERE id=:id");
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':nombre', $nombre);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function eliminar(){
        $id=$this->objRol->getId();
        $nombre=$this->objRol->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("DELETE FROM rol WHERE id=:id");
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

}
?>