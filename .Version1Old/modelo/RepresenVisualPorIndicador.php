<?php
class RepresenVisualPorIndicador{
    //atributos
    var $fkidindicador;
    var $fkidrepresenvisual;
    //constructor
    function __construct($fkidindicador,$fkidrepresenvisual){
        $this->fkidindicador=$fkidindicador;
        $this->fkidrepresenvisual=$fkidrepresenvisual;
    }
    function getFkidindicador(){
        return $this->fkidindicador;
    }
    function setFkidindicador($fkidindicador){
        $this->fkidindicador=$fkidindicador;
    }
    function getFkidrepresenvisual(){
        return $this->fkidrepresenvisual;
    }
    function setFkidrepresenvisual($fkidrepresenvisual){
        $this->fkidrepresenvisual=$fkidrepresenvisual;
    }
}
?>