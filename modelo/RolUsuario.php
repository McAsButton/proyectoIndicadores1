<?php
class RolUsuario{
    //atributos
    var $fkemail;
    var $fkidrol;
    //constructor
    function __construct($fkemail,$fkidrol){
        $this->fkemail=$fkemail;
        $this->fkidrol=$fkidrol;
    }
    function getFkemail(){
        return $this->fkemail;
    }
    function setFkemail($fkemail){
        $this->fkemail=$fkemail;
    }
    function getFkidrol(){
        return $this->fkidrol;
    }
    function setFkidrol($fkidrol){
        $this->fkidrol=$fkidrol;
    }
}
?>