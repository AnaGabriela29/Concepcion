<?php 
class AlumnosModel extends Mysql
{
	private $intIdUsuario;
	private $strIdentificacion;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strEmail;
	private $strPassword;
	private $strToken;
	private $intTipoId;
	private $intStatus;
	private $strApoderado;
	private $strNumeroApoderado;
	private $intMatriculado;

	public function __construct()
	{
		parent::__construct();
	}	

	public function insertAlumno(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, string $apoderado, int $numeroApoderado, int $matriculado ){

		
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->strApoderado = $apoderado;
		$this->strNumeroApoderado=$numeroApoderado;
		$this->intMatriculado=$matriculado;		

		$return = 0;
		$sql = "SELECT * FROM usuario WHERE 
				email = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}' ";
		$request = $this->select_all($sql);
		
		if(empty($request))
		{
			$query_insert  = "INSERT INTO usuario(identificacion,nombres,apellidos,telefono,email,contrasena,id_rol) 
							  VALUES(?,?,?,?,?,?,?)";
        	$arrData = array($this->strIdentificacion,
    						$this->strNombre,
    						$this->strApellido,
    						$this->intTelefono,
    						$this->strEmail,
    						$this->strPassword,
    						$this->intTipoId
    						);
        	$request_insert = $this->insert($query_insert,$arrData);
			$request_insert_alum=0;
			if($request_insert>0){
			$idUsuarioTemp=	$request_insert;

			$query_insert_alum="INSERT INTO estudiante(id_usuario,nombre_apoderado, numero_whatsapp, matriculado) VALUES (?,?,?,?)";
			$arrData_alum=array($idUsuarioTemp, $this->strApoderado, $this->strNumeroApoderado, $this->intMatriculado);
			$request_insert_alum=$this->insert($query_insert_alum, $arrData_alum);
			}	
        	$return = $request_insert_alum;
		}else{
			$return = "exist";
		}
		
        return $return;
	}

	public function selectAlumnos()
	{
		$sql = "SELECT id_usuario,identificacion,nombres,apellidos,telefono,email,status 
				FROM usuario
				WHERE id_rol = ".RALUMNOS." and status != 0 "; 
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectAlumno(int $idpersona){
		$this->intIdUsuario = $idpersona;
		$sql = "SELECT u.id_usuario, u.identificacion, u.nombres, u.apellidos, u.telefono, u.email, u.status, DATE_FORMAT(u.date_created, '%d-%m-%Y') as fechaRegistro, 
				e.nombre_apoderado, e.numero_whatsapp, e.matriculado 
				FROM usuario u
				INNER JOIN estudiante e ON u.id_usuario = e.id_usuario
				WHERE u.id_usuario = $this->intIdUsuario and u.id_rol = ".RALUMNOS;
		$request = $this->select($sql);
		return $request;
	}	

	public function updateAlumno(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, string $apoderado, int $numeroApoderado, int $matriculado) {
		$this->intIdUsuario = $idUsuario;
		$this->strIdentificacion = $identificacion;
		$this->strNombre = $nombre;
		$this->strApellido = $apellido;
		$this->intTelefono = $telefono;
		$this->strEmail = $email;
		$this->strPassword = $password;
		$this->strApoderado = $apoderado;
		$this->strNumeroApoderado = $numeroApoderado;
		$this->intMatriculado = $matriculado;
	
		$sql = "SELECT * FROM usuario WHERE (email = '{$this->strEmail}' AND id_usuario != $this->intIdUsuario)
									  OR (identificacion = '{$this->strIdentificacion}' AND id_usuario != $this->intIdUsuario) ";
		$request = $this->select_all($sql);
	
		if(empty($request)) {
			if($this->strPassword != "") {
				$sql = "UPDATE usuario SET identificacion=?, nombres=?, apellidos=?, telefono=?, email=?, contrasena=?
						WHERE id_usuario = ?";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intIdUsuario);
			} else {
				$sql = "UPDATE usuario SET identificacion=?, nombres=?, apellidos=?, telefono=?, email=?
						WHERE id_usuario = ?";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->intIdUsuario);
			}
			$requestUsuario = $this->update($sql, $arrData);
	
			// Aquí se agregan las actualizaciones a la tabla estudiante
			$sql = "UPDATE estudiante SET nombre_apoderado=?, numero_whatsapp=?, matriculado=?
					WHERE id_usuario = ?";
			$arrDataEstudiante = array($this->strApoderado,
									   $this->strNumeroApoderado,
									   $this->intMatriculado,
									   $this->intIdUsuario);
			$requestEstudiante = $this->update($sql, $arrDataEstudiante);
	
			// Retornar ambos estados de actualización
			if ($requestUsuario && $requestEstudiante) {
				$request = true;
			} else {
				$request = false; // Manejar correctamente la respuesta en caso de fallo
			}
		} else {
			$request = "exist";
		}
	
		return $request;
	}
	

	public function deleteAlumno(int $intIdpersona)
{
    $this->intIdUsuario = $intIdpersona;
    $allUpdatesSuccessful = true;

    // Actualizar el status en la tabla usuario
    $sqlUsuario = "UPDATE usuario SET status = ? WHERE id_usuario = ?";
    $arrDataUsuario = array(0, $this->intIdUsuario);
    $requestUsuario = $this->update($sqlUsuario, $arrDataUsuario);
    if(!$requestUsuario) {
        $allUpdatesSuccessful = false;
    }

    // Actualizar el status en la tabla estudiante
    $sqlEstudiante = "UPDATE estudiante SET status = ? WHERE id_usuario = ?";
    $arrDataEstudiante = array(0, $this->intIdUsuario);
    $requestEstudiante = $this->update($sqlEstudiante, $arrDataEstudiante);
    if(!$requestEstudiante) {
        $allUpdatesSuccessful = false;
    }

    // Comprobar el éxito de todas las operaciones
    if ($allUpdatesSuccessful) {
        return true;
    } else {
        // Aquí podrías manejar un caso donde una actualización falló y la otra no.
        // Sin soporte de transacciones, no puedes revertir automáticamente.
        return false;
    }
}


}

 ?>