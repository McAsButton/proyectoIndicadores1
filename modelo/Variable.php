<?php
class Variable{
    //atributos
    var $id;
    var $nombre;
    var $fechacreacion;
    var $fkemailusuario;
    //contructor
    function __construct($id,$nombre,$fechacreacion,$fkemailusuario){
        $this->id=$id;
        $this->nombre=$nombre;
        $this->fechacreacion=$fechacreacion;
        $this->fkemailusuario=$fkemailusuario;
    }
    function getId(){
        return $this->id;
    }
    function setId($id){
        $this->id=$id;
    }
    function getNombre(){
        return $this->nombre;
    }
    function setNombre($nombre){
        $this->nombre=$nombre;
    }
    function getFechacreacion(){
        return $this->fechacreacion;
    }
    function setFechacreacion($fechacreacion){
        $this->fechacreacion=$fechacreacion;
    }
    function getFkemailusuario(){
        return $this->fkemailusuario;
    }
    function setFkemailusuario($fkemailusuario){
        $this->fkemailusuario=$fkemailusuario;
    }
}
?>