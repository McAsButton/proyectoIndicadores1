<?php
class Articulo{
    //variables
    var $id ;
    var $nombre;
    var $descripcion;
    var $fkidseccion;
    var $fkidsubseccion;
    //constructor
        function __construct($id,$nombre,$descripcion,$fkidseccion,$fkidsubseccion){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->fkidseccion = $fkidseccion;
            $this->fkidsubseccion = $fkidsubseccion;
        }
        function getId(){
            return $this->id;
        }
        function setId($id){
            $this->id = $id;
        }
        function getNombre(){
            return $this->nombre;
        }
        function setNombre($nombre){
            $this->nombre = $nombre;
        }
        function getDescripcion(){
            return $this->descripcion;
        }
        function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }
        function getFkidseccion(){
            return $this->fkidseccion;
        }
        function setFkidseccion($fkidseccion){
            $this->fkidseccion = $fkidseccion;
        }
        function getFkidsubseccion(){
            return $this->fkidsubseccion;
        }
        function setFkidsubseccion($fkidsubseccion){
            $this->fkidsubseccion = $fkidsubseccion;
        }
}
?>