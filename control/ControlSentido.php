<?php
include '../Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlSentido{
    var $objSentido;

    function __construct($objSentido){
        $this->objSentido=$objSentido;
    }
    
    function consultar(){
        $id=$this->objSentido->getId();
        $nombre=$this->objSentido->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); 
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("SELECT * FROM sentido WHERE id=:id"); 
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function agregar(){
        $id=$this->objSentido->getId();
        $nombre=$this->objSentido->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); 
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("INSERT INTO sentido (nombre) VALUES (:id, :nombre)"); 
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':nombre', $nombre);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function modificar(){
        $id=$this->objSentido->getId();
        $nombre=$this->objSentido->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); 
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("UPDATE sentido SET nombre=:nombre WHERE id=:id"); 
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':nombre', $nombre);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function eliminar(){
        $id=$this->objSentido->getId();
        $nombre=$this->objSentido->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']);
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("DELETE FROM sentido WHERE id=:id");
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

}
?>