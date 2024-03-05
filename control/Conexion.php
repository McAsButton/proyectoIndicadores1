<?php
class ConexionBD {
    private $servidor;
    private $usuario;
    private $password;
    private $pdo;

    public function __construct($servidor, $usuario, $password){
        $this->servidor = $servidor;
        $this->usuario = $usuario;
        $this->password = $password;
    }

    public function conectar(){
        try{
            $this->pdo = new PDO($this->servidor, $this->usuario, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            //echo "Conectado...";
        } catch(PDOException $e){
            echo "Conexión Fallida: " . $e->getMessage();
        }
        return $this->pdo;
    }

    public function desconectar(){
        $this->pdo = null;
    }
}
?>
