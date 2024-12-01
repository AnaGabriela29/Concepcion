<?php 

class Alumnos extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();		
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MALUMNOS);
	}

	public function Alumnos()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Alumnos";
		$data['page_title'] = "Alumnos <small>Colegio - UNIMAT</small>";
		$data['page_name'] = "Alumnos";
		$data['page_functions_js'] = "functions_alumnos.js";
		$this->views->getView($this,"Alumnos",$data);
	}

	public function setAlumno(){
		error_reporting(0);
		if($_POST){
			if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtApoderado']) || empty($_POST['txtNumeroApoderado']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos o incompletos.');
			}else{ 
				$idUsuario = intval($_POST['idUsuario']);
				$strIdentificacion = strClean($_POST['txtIdentificacion']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strApellido = ucwords(strClean($_POST['txtApellido']));
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strEmail = strtolower(strClean($_POST['txtEmail']));
				$strApoderado=ucwords(strClean($_POST['txtApoderado']));
				$strNumeroApoderado=intval($_POST['txtNumeroApoderado']);
				$matriculado=intval($_POST['listMatriculado']);
				$intTipoId = 1;
				$request_user = "";				
				if($idUsuario == 0)
				{	
				
					$option = 1;
					$strPassword =  empty($_POST['txtPassword']) ? password_hash(passGenerator(), PASSWORD_DEFAULT) : password_hash($_POST['txtPassword'], PASSWORD_DEFAULT);
					if($_SESSION['permisosMod']['w']){
						$request_user = $this->model->insertAlumno($strIdentificacion,
																			$strNombre, 
																			$strApellido, 
																			$intTelefono, 
																			$strEmail,
																			$strPassword,
																			$intTipoId,
																			$strApoderado,
																			$strNumeroApoderado,
																			$matriculado
																		 );
					}
					
				}else{
					$option = 2;
					$strPassword =  empty($_POST['txtPassword']) ? password_hash(passGenerator(), PASSWORD_DEFAULT) : password_hash($_POST['txtPassword'], PASSWORD_DEFAULT);
					if($_SESSION['permisosMod']['u']){
						
						$request_user = $this->model->updateAlumno($idUsuario,
																	$strIdentificacion, 
																	$strNombre,
																	$strApellido, 
																	$intTelefono, 
																	$strEmail,
																	$strPassword,
																	$strApoderado,
																	$strNumeroApoderado,
																	$matriculado 
																	);
					}
				}

				if(intval($request_user)> 0 )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						$nombreUsuario = $strNombre.' '.$strApellido;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'password' => $strPassword,
											 'asunto' => 'Bienvenido a al Colegio Unimat');
						// sendEmail($dataUsuario,'email_bienvenida');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_user == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getAlumnos()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectAlumnos();
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['id_usuario'].')" title="Ver cliente"><i class="bi bi-eye-fill"></i></button>';
				}
				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['id_usuario'].')" title="Editar cliente"><i class="bi bi-pencil"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){	
					$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['id_usuario'].')" title="Eliminar cliente"><i class="bi bi-trash"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getAlumno($idpersona){
		if($_SESSION['permisosMod']['r']){
			$idusuario = intval($idpersona);
			if($idusuario > 0)
			{
				$arrData = $this->model->selectAlumno($idusuario);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function delAlumno()
	{
		if($_POST){
			if($_SESSION['permisosMod']['d']){
				$intIdpersona = intval($_POST['idUsuario']);
				$requestDelete = $this->model->deleteAlumno($intIdpersona);
				if($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado al alumno');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al alumno.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
	public function importAlumnos(){
    
		if(!$_SESSION['permisosMod']['w']){
			$arrResponse = array("status" => false, "msg" => 'No tienes permiso para realizar esta operación.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	
		$data = json_decode(file_get_contents("php://input"), true);
		array_shift($data); // Elimina el encabezado
	
		$totalRecords = count($data);
		$recordsProcessed = 0; // Contador de registros procesados con éxito
		$msgExist="";
		foreach ($data as $index => $alumno) {
			if(empty($alumno[0]) || empty($alumno[1]) || empty($alumno[2]) || empty($alumno[3]) || empty($alumno[4]) || empty($alumno[6]) || empty($alumno[7])) {
				continue; // Saltar este alumno si falta alguna información crítica
			}
			
			$strIdentificacion = strClean($alumno[0]);
			$strNombre = ucwords(strClean($alumno[1]));
			$strApellido = ucwords(strClean($alumno[2]));
			$intTelefono = intval(strClean($alumno[3]));
			$strEmail = strtolower(strClean($alumno[4]));
			$strApoderado = ucwords(strClean($alumno[6]));
			$strNumeroApoderado = intval($alumno[7]);
			$intTipoId = RALUMNOS; 
			$matriculado = intval(strtolower($alumno[8])=="si"?1:0);
	
			$strPassword = empty($alumno[5]) ? password_hash(passGenerator(), PASSWORD_DEFAULT) : password_hash($alumno[5], PASSWORD_DEFAULT);
	
			$request_user = $this->model->insertAlumno($strIdentificacion,
													   $strNombre,
													   $strApellido,
													   $intTelefono,
													   $strEmail,
													   $strPassword,
													   $intTipoId,
													   $strApoderado,
													   $strNumeroApoderado,
													   $matriculado);
			
			if(intval($request_user) > 0) {
				$recordsProcessed++; // Incrementar contador de éxito
			} else {
				$msgExist="Ya existe un usuario con estas credenciales";
				break;
			}
		}
	
		if ($recordsProcessed == $totalRecords) {
			$arrResponse = array("status" => true, "msg" => "Todos los datos han sido guardados correctamente. Total: $recordsProcessed");
		} else {
			$remainingRecords = $totalRecords - $recordsProcessed;
			$arrResponse = array("status" => false, "msg" => "Se han guardado $recordsProcessed registros de $totalRecords. Faltan $remainingRecords registros por procesar. $msgExist");
		}
	
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}
	
	
	
	
 }
?>