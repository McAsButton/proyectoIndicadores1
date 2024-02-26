<?php
class Indicador{
    //atributos
    var $id;
    var $codigo;
    var $nombre;
    var $objetivo;
    var $alcance;
    var $formula;
    var $fkidtipoindicador;
    var $fkidunidadmedicion;
    var $meta;
    var $fkidsentido;
    var $fkidfrecuencia;
    var $fkidarticulo;
    var $fkidliteral;
    var $fkidnumeral;
    var $fkidparagrafo;
    //constructor
    function __construct($id,$codigo,$nombre,$objetivo,$alcance,$formula, 
                        $fkidtipoindicador,$fkidunidadmedicion,$meta,
                        $fkidsentido,$fkidfrecuencia,$fkidarticulo,
                        $fkidliteral,$fkidnumeral,$fkidparagrafo){                           
    }
    function getId(){
            return $this->id;
    }
    function setId($id){
        $this->id = $id;
    }
    function getCodigo(){
        return $this->codigo;
    }
    function setCodigo($codigo){
        $this->codigo = $codigo;  
    }
    function getNombre(){
        return $this->nombre;
    }
    function setNombre($nombre){
        $this->nombre = $nombre;
    }
    function getObjetivo(){
        return $this->objetivo;
    }
    function setObjetivo($objetivo){
        $this->objetivo = $objetivo;
    }
    function getAlcance(){
        return $this->alcance;
    }
    function setAlcance($alcance){
        $this->alcance = $alcance;
    }
    function getFormula(){
        return $this->formula;
    }
    function setFormula($formula){
        $this->formula = $formula;
    }
    function getFkidtipoindicador(){
        return $this->fkidtipoindicador;
    }
    function setFkidtipoindicador ($fkidtipoindicador) {
        $this->fkidtipoindicador = $fkidtipoindicador;
    }
    function getFkidunidadmedicion(){
        return $this->fkidunidadmedicion;
    }
    function setFkidunidadmedicion($fkidunidadmedicion){
        $this->fkidunidadmedicion = $fkidunidadmedicion;
    }
    function getMeta(){
        return $this->meta;
    }
    function setMeta($meta){
        $this->meta = $meta;
    }
    function getFkidsentido(){
        return  $this->fkidsentido;
    }
    function setFkidsentido($fkidsentido){
        $this->fkidsentido = $fkidsentido;
    }
    function getFkidfrecuencia(){
        return $this->fkidfrecuencia;
    }
    function setFkidfrecuencia($fkidfrecuencia){
        $this->fkidfrecuencia=$fkidfrecuencia;
    }
    function getFkidarticulo(){
        return $this->fkidarticulo;
    }
    function setFkidarticulo($fkidarticulo){
        $this->fkidarticulo = $fkidarticulo;
    }
    function getFkidliteral(){
        return $this->fkidliteral;
    }
    function setFkidliteral($fkidliteral){
       $this->fkidliteral = $fkidliteral;
    }
    function getFkidnumeral(){
        return $this->fkidnumeral;
    }
    function setFkidnumeral($fkidnumeral){
        $this->fkidnumeral= $fkidnumeral;
    }
    function getFkidparagrafo(){
        return $this->fkidparagrafo;
    }
    function setFkidparagrafo($fkidparagrafo){
        $this->fkidparagrafo= $fkidparagrafo;
    }
}
?>