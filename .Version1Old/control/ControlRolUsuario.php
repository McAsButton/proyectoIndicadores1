<?php 
include_once 'Conexion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include 'configBd.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

class ControlRolUsuario{
    var $objRolUsuario;
    
    function __construct($objRolUsuario){
        $this->objRolUsuario=$objRolUsuario;
    }

    function listar(){
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar(); //Conecta a la base de datos
        $comandoSql = $pdo->prepare("SELECT * FROM rol_usuario"); //Prepara la consulta SQL // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        $comandoSql->execute(); //Ejecuta la consulta SQL
        $conexionBD->desconectar(); //Desconecta de la base de datos
        return $comandoSql; //Retorna los datos de la consulta
    }
    
    function consultar($email){
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']); //Crea un objeto de la clase ConexionBD
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("SELECT * FROM rol_usuario WHERE fkemail=:email");
        $comandoSql->bindParam(':email', $email);
        $comandoSql->execute();
        $conexionBD->desconectar();
        return $comandoSql;
    }

    function guardar(){
        $email = $this->objRolUsuario->getFkemail(); //Obtiene el email del objeto
        $rol = $this->objRolUsuario->getFkidrol();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']);
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("INSERT INTO rol_usuario(fkemail, fkidrol) VALUES (:email, :rol)");
        $comandoSql->bindParam(':email', $email);
        $comandoSql->bindParam(':rol', $rol);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }

    function modificar(){
        $email = $this->objRolUsuario->getFkemail();
        $roles = $this->objRolUsuario->getFkidrol();
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']);
        $pdo = $conexionBD->conectar();
        
        // Eliminar todos los roles existentes para el usuario
        $sqlDelete = "DELETE FROM rol_usuario WHERE fkemail = :email";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->bindParam(':email', $email);
        $stmtDelete->execute();
    
        // Insertar los nuevos roles seleccionados para el usuario
        $sqlInsert = "INSERT INTO rol_usuario (fkemail, fkidrol) VALUES (:email, :rol)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->bindParam(':email', $email);
        $stmtInsert->bindParam(':rol', $rol_id);
    
        foreach ($roles as $rol_id) {
            $stmtInsert->execute();
        }
        
        $conexionBD->desconectar();
    }

    function borrar($email){
        $conexionBD = new ConexionBD("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['db'], $GLOBALS['user'], $GLOBALS['password']);
        $pdo = $conexionBD->conectar();
        $comandoSql = $pdo->prepare("DELETE FROM rol_usuario WHERE fkemail=:email");
        $comandoSql->bindParam(':email', $email);
        $comandoSql->execute();
        $conexionBD->desconectar();
    }
}









?>