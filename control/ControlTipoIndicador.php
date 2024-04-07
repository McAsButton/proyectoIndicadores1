<?php
include 'Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlTipoIndicador{
    var $objTipoIndicador;

    function __construct($objTipoIndicador){
        $this->objTipoIndicador=$objTipoIndicador;
    }

    function listar(){
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar(); //Conecta a la base de datos
        $comandoSql = $pdo->prepare("SELECT * FROM tipoindicador"); //Prepara la consulta SQL // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->execute(); //Ejecuta la consulta SQL
        $conexionBD->desconectar(); //Desconecta de la base de datos
        return $comandoSql->fetchAll(PDO::FETCH_ASSOC); //Retorna los datos de la consulta
    }
    
    function consultar(){
        $id=$this->objTipoIndicador->getId();
        $nombre=$this->objTipoIndicador->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("SELECT * FROM tipoindicador WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function agregar(){
        $id=$this->objTipoIndicador->getId();
        $nombre=$this->objTipoIndicador->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("INSERT INTO tipoindicador (id,nombre) VALUES (:id, :nombre)"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':nombre', $nombre);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function modificar(){
        $id=$this->objTipoIndicador->getId();
        $nombre=$this->objTipoIndicador->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("UPDATE tipoindicador SET nombre=:nombre WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->bindParam(':nombre', $nombre);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function eliminar(){
        $id=$this->objTipoIndicador->getId();
        $nombre=$this->objTipoIndicador->getNombre();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("DELETE FROM tipoindicador WHERE id=:id"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->bindParam(':id', $id);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

}
?>