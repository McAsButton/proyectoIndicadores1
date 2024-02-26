<?php
class FuentesPorIndicador{
    //atributos
    var $fkidfuente;
    var $fkidindicador;
    //constructor
    function __construct($fkidfuente,$fkidindicador){
        $this->fkidfuente=$fkidfuente;
        $this->fkidindicador=$fkidindicador;
    }
    function getFkidfuente(){
        return $this->fkidfuente;
    }
    function setFkidfuente($fkidfuente){
        $this->fkidfuente=$fkidfuente;
    }
    function getFkidindicador(){
        return $this->fkidindicador;
    }
    function setFkidindicador($fkidindicador){
        $this->fkidindicador=$fkidindicador;
    }
}
?>