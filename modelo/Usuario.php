<?php
class Usuario{
    //atributos
    var $email;
    var $contrasena;
    //constructor
    function __construct($email, $contrasena){
        $this->email = $email;
        $this->contrasena = $contrasena;
    }
    function getEmail(){
        return $this->email;
    }
    function setEmail($email){
        $this->email = $email;
    }
    function getContrasena(){
        return $this->contrasena;
    }
    function setContrasena($contrasena){
        $this->contrasena = $contrasena;
    }
}
?>