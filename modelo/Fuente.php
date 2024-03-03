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
    // function setId($id){
    //     $this->id=$id;
    // } No se usa por ser autoincremental
    function getNombre(){
        return $this->nombre;
    }
    
}
?>