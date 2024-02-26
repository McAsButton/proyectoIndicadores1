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
    function setId($id){
        $this->id=$id;
    }
    function getNombre(){
        return $this->nombre;
    }
    
}
?>