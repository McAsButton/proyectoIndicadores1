<?php

class Fuente{
    //atributos
    var $id;
    var $nombre;
    //constructor
    function __construct($id,$nombre){
        $this->id=$id;
        $this->nombre=$nombre;
    }
    function getId(){
        return $this->id;
    }
    // function setId($id){
    //     $this->id=$id;
    // } No se usa por ser autoincremental
    function getNombre(){
        return $this->nombre;
    }
    function setNombre($nombre){
        $this->nombre=$nombre;
    }    
}
?>