<?php
class Numeral{
    //atributos
    var $id;
    var $descripcion;
    var $fkidliteral;
    //constructor
    function __construct($id, $descripcion, $fkidliteral){
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->fkidliteral = $fkidliteral;
    }
    function getId(){
        return $this->id;
    }
    function setId($id){
        $this->id = $id;
    }
    function getDescripcion(){
        return $this->descripcion;
    }
    function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    function getFkidliteral(){
        return $this->fkidliteral;
    }
    function setFkidliteral($fkidliteral){
        $this->fkidliteral = $fkidliteral;
    }
}
?>