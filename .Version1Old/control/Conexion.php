<?php
class ConexionBD { //clase
    //atributos
    private $servidor;
    private $usuario;
    private $password;
    private $pdo;

    public function __construct($servidor, $usuario, $password){ //funcion que se ejecuta al crear un objeto de la clase
        $this->servidor = $servidor;
        $this->usuario = $usuario;
        $this->password = $password;
    }

    public function conectar(){ //funcion para conectar a la base de datos
        try{
            $this->pdo = new PDO($this->servidor, $this->usuario, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); //conexion a la base de datos con PDO
            //echo "Conectado...";
        } catch(PDOException $e){
            echo "Conexión Fallida: " . $e->getMessage(); //mensaje de error si no se puede conectar
        }
        return $this->pdo;
    }

    public function desconectar(){ //funcion para desconectar de la base de datos
        $this->pdo = null; //se cierra la conexion a la base de datos con null
    }
}
?>
