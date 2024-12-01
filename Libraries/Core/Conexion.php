<?php
class Conexion{
	private $conect;

	public function __construct(){
		$connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
		try{
		
			$this->conect = new PDO($connectionString, DB_USER, DB_PASSWORD);
			$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    // echo "conexión exitosa";
		}catch(PDOException $e){
			$this->conect = 'Error de conexión';
            error_log("ERROR: " . $e->getMessage());  // Registrar el error
            if ($environment === 'development') {
                echo "ERROR: " . $e->getMessage();  // Solo mostrar en desarrollo
            } else {
                echo "Error de conexión. Por favor, intente más tarde.";  // Mensaje genérico para producción
            }
		}
	}

	public function conect(){
		return $this->conect;
	}
}

?>