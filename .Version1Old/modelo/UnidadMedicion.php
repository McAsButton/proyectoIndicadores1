<?php
class UnidadMedicion{
    //atributos
    var $id;
    var $descripcion;
    //constructor
    function __construct($id, $descripcion){
        $this->id = $id;
        $this->descripcion = $descripcion;
    }
    function getId(){
        return $this->id;
    }
    // function setId($id){
    //     $this->id = $id;
    // }  No se usa por ser autoincremental
    function getDescripcion(){
        return $this->descripcion;
    }
    function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
}
?>