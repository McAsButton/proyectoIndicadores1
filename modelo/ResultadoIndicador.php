<?php
class ResultadoIndicador{
    //atributos
    var $id;
    var $resultado;
    var $fechacalculo;
    var $fkidindicador;
    //constructor
    function __construct($id,$resultado,$fechacalculo,$fkidindicador){
        $this->id=$id;
        $this->resultado=$resultado;
        $this->fechacalculo=$fechacalculo;
        $this->fkidindicador=$fkidindicador;
    }
    function getId(){
        return $this->id;
    }
    function setId($id){
        $this->id=$id;
    }
    function getResultado(){
        return $this->resultado;
    }
    function setResultado($resultado){
        $this->resultado=$resultado;
    }
    function getFechacalculo(){
        return $this->fechacalculo;
    }
    function setFechacalculo($fechacalculo){
        $this->fechacalculo=$fechacalculo;
    }
    function getFkidindicador(){
        return $this->fkidindicador;
    }
    function setFkidindicador($fkidindicador){
        $this->fkidindicador=$fkidindicador;
    }
}
?>