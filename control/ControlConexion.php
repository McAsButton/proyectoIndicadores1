<?php
class ControlConexion{
	
	var $conn;
	function __construct(){
		$this->conn=null;
	}
    function abrirBd($servidor, $usuario, $password,$db,$port){
    	try	{
			$this->conn = new mysqli($servidor, $usuario, $password, $db, $port);
			if ($this->conn->connect_errno) {
			printf("Connect failed: %s\n", $this->conn->connect_error);
			exit();
			}
      	}
      	catch (Exception $e){
          	echo "ERROR AL CONECTARSE AL SERVIDOR ".$e->getMessage()."\n";
      	}

    }

    function cerrarBd() {
		try{
       $this->conn->close();
		}
      	catch (Exception $e){
          	echo "ERROR AL CONECTARSE AL SERVIDOR ".$e->getMessage()."\n";
      	}		
    }

    function ejecutarComandoSql(string $sql) {
		//insert into, update, delete
    	try	{
			$this->conn->query($sql);
			}
		catch (Exception $e) {
				echo " NO SE AFECTARON LOS REGISTROS: ". $e->getMessage()."\n";
		  }	
		}

	function ejecutarSelect(string $sql) {
			try	{
				$recordSet=$this->conn->query($sql);
				}
	
			catch (Exception $e) {
					echo " ERROR: ". $e->getMessage()."\n";
			  }	
		return $recordSet;
			}   
}
?>

//
/*
class ControlConexion{
	
	var $conn; // Variable privada para almacenar la conexión

	public function __construct(){
		$this->conn = null; // Inicializa la variable de conexión como nula al crear una instancia
	}

	public function getConn() {
		return $this->conn; // Método para obtener la conexión
	}

	public function setConn($conn) {
		$this->conn = $conn; // Método para establecer la conexión
	}

    public function abrirBd($servidor, $usuario, $password, $db, $port){
    	try	{
			$this->conn = new PDO("mysql:host=$servidor;dbname=$db;port=$port", $usuario, $password); // Crea una nueva conexión PDO
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establece el modo de error de PDO a excepción
      	}
      	catch (PDOException $e){ // Captura las excepciones de PDO
          	echo "ERROR AL CONECTARSE AL SERVIDOR " . $e->getMessage() . "\n"; // Muestra un mensaje de error si la conexión falla
      	}

    }

    public function cerrarBd() {
		try{
       		if ($this->conn !== null) { // Verifica si la conexión no es nula
       			$this->conn = null; // Establece la conexión como nula para cerrarla
       		}
		}
      	catch (PDOException $e){
          	echo "ERROR AL CONECTARSE AL SERVIDOR " . $e->getMessage() . "\n"; // Muestra un mensaje de error si falla al cerrar la conexión
      	}		
    }

    public function ejecutarComandoSql(string $sql) {
		try {
			if ($this->conn === null) { // Verifica si hay una conexión establecida
				throw new Exception("No hay conexión a la base de datos."); // Lanza una excepción si no hay conexión
			}
			$this->conn->exec($sql); // Ejecuta el comando SQL
		} catch (Exception $e) {
			echo " NO SE AFECTARON LOS REGISTROS: " . $e->getMessage() . "\n"; // Muestra un mensaje de error si falla la ejecución
		}
	}

	public function ejecutarSelect(string $sql) {
		try {
			if ($this->conn === null) { // Verifica si hay una conexión establecida
				throw new Exception("No hay conexión a la base de datos."); // Lanza una excepción si no hay conexión
			}
			$recordSet = $this->conn->query($sql); // Ejecuta la consulta SQL
		} catch (Exception $e) {
			echo " ERROR: " . $e->getMessage() . "\n"; // Muestra un mensaje de error si falla la ejecución
		}
		return $recordSet; // Devuelve el conjunto de registros
	}
}
*/
