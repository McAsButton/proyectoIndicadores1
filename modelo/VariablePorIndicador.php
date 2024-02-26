<?php
class VariablePorIndicador{
    //atributos
    var $id;
    var $fkidvariable;
    var $fkidindicador;
    var $dato;
    var $fkemailusuario;
    var $fechadato;
    //constructor
    function __construct($id,$fkidvariable,$fkidindicador,$dato,$fkemailusuario,$fechadato){
        $this->id=$id;
        $this->fkidvariable=$fkidvariable;
        $this->fkidindicador=$fkidindicador;
        $this->dato=$dato;
        $this->fkemailusuario=$fkemailusuario;
        $this->fechadato=$fechadato;
    }
    function getId(){
        return $this->id;
    }
    function setId($id){
        $this->id=$id;
    }
    function getFkidvariable(){
        return $this->fkidvariable;
    }
    function setFkidvariable($fkidvariable){
        $this->fkidvariable=$fkidvariable;
    }
    function getFkidindicador(){
        return $this->fkidindicador;
    }
    function setFkidindicador($fkidindicador){
        $this->fkidindicador=$fkidindicador;
    }
    function getDato(){
        return $this->dato;
    }
    function setDato($dato){
        $this->dato=$dato;
    }
    function getFkemailusuario(){
        return $this->fkemailusuario;
    }
    function setFkemailusuario($fkemailusuario){
        $this->fkemailusuario=$fkemailusuario;
    }
    function getFechadato(){
        return $this->fechadato;
    }
    function setFechadato($fechadato){
        $this->fechadato=$fechadato;
    }
}
?>