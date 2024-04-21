<?php
class ResponsablePorIndicador{
    //atributos
    var $fkidresponsable;
    var $fkidindicador;
    var $fechaasignacion;
    //constructor
    function __construct($fkidresponsable,$fkidindicador,$fechaasignacion){
        $this->fkidresponsable=$fkidresponsable;
        $this->fkidindicador=$fkidindicador;
        $this->fechaasignacion=$fechaasignacion;
    }
    function getFkidresponsable(){
        return $this->fkidresponsable;
    }
    function setFkidresponsable($fkidresponsable){
        $this->fkidresponsable=$fkidresponsable;
    }
    function getFkidindicador(){
        return $this->fkidindicador;
    }
    function setFkidindicador($fkidindicador){
        $this->fkidindicador=$fkidindicador;
    }
    function getFechaasignacion(){
        return $this->fechaasignacion;
    }
    function setFechaasignacion($fechaasignacion){
        $this->fechaasignacion=$fechaasignacion;
    }
}
?>