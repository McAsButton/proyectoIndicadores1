<?php
class Actor{
    //variables
   var $id ;
   var $nombre;
   var $fkidtipoactor;
   //constructor
    function __construct($id,$nombre,$fkidtipoactor){
         $this->id = $id;
         $this->nombre = $nombre;
         $this->fkidtipoactor = $fkidtipoactor;
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
    function getFkidtipoactor(){
        return $this->fkidtipoactor;
    }
    function setFkidtipoactor($fkidtipoactor){
        $this->fkidtipoactor = $fkidtipoactor;
    }
}
?>