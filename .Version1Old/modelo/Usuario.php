<?php
class Usuario{ //clase
    //atributos
    var $email;
    var $contrasena;
    //constructor
    function __construct($email, $contrasena){ //funcion que se ejecuta al crear un objeto de la clase
        $this->email = $email;
        $this->contrasena = $contrasena;
    }
    function getEmail(){ //funcion para obtener el email
        return $this->email;
    }
    function setEmail($email){ //funcion para asignar el email
        $this->email = $email;
    }
    function getContrasena(){ //funcion para obtener la contraseña
        return $this->contrasena;
    }
    function setContrasena($contrasena){ //funcion para asignar la contraseña
        $this->contrasena = $contrasena;
    }
}
?>