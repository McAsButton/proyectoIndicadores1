<?php
include '../Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlIndicador{
    var $objIndicador;

    function __construct($objIndicador){
        $this->objIndicador=$objIndicador;
    }
    
    function consultar(){
        $id=$this->objIndicador->getId();
        $codigo=$this->objIndicador->getCodigo();
        $nombre=$this->objIndicador->getNombre();
        $objetivo=$this->objIndicador->getObjetivo();
        $alcance=$this->objIndicador->getAlcance();
        $formula=$this->objIndicador->getFormula();
        $fkidtipoindicador=$this->objIndicador->getFkidtipoindicador();
        $fkidunidadmedicion=$this->objIndicador->getFkidunidadmedicion();
        $meta=$this->objIndicador->getMeta();
        $fkidsentido=$this->objIndicador->getFkidsentido();
        $fkidfrecuencia=$this->objIndicador->getFkidfrecuencia();
        $fkidarticulo=$this->objIndicador->getFkidarticulo();
        $fkidliteral=$this->objIndicador->getFkidliteral();
        $fkidnumeral=$this->objIndicador->getFkidnumeral();
        $fkidparagrafo=$this->objIndicador->getFkidparagrafo();

        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("SELECT * FROM usuario");
        $comandoSql->execute();
        $conexionBD->desconectar();
        return $comandoSql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>