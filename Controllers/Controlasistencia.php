<?php 

	class Controlasistencia extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			// session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MCONTROLASISTENCIA);
		}

		public function Controlasistencia()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 9;
			$data['page_tag'] = "Asistencia UNIMAT";
			$data['page_name'] = "Asistencia";
			$data['page_title'] = "Unimat<small> Asistencia</small>";
			$data['page_functions_js'] = "functions_controlAsistencia.js";
			$this->views->getView($this,"Controlasistencia",$data);
		}

		public function getAsistencias()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectAsistencias();

				for ($i=0; $i < count($arrData); $i++) {

					if($_SESSION['permisosMod']['u']){
						$btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewAsistencia('.$arrData[$i]['id_asistencia'].')" title="Permisos"><i class="bi bi-eye-fill"></i></button>';
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditAsistencia('.$arrData[$i]['id_asistencia'].')" title="Editar"><i class="bi bi-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelAsistencia('.$arrData[$i]['id_asistencia'].')" title="Eliminar"><i class="bi bi-trash3"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}		

		public function getAsistencia(int $idasistencia)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdAsistencia = intval(strClean($idasistencia));
				if($intIdAsistencia > 0)
				{
					$arrData = $this->model->selectAsistencia($intIdAsistencia);
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

		public function setAsistencia(){
				$intIdAsistencia = intval($_POST['idAsistencia']);
				$strDNI=  strClean($_POST['txtNumerodni']);
				$strFechaRegistro = strClean($_POST['txtFechaRegistro']);
                $observaciones = ($_POST['txtObservacion'] == '') ? '' : strClean($_POST['txtObservacion']);
				$strEstado= strClean($_POST['txtEstadoAsistencia']);          
				$strFechaRegistro= new DateTime($strFechaRegistro);
				$request_aula = "";
				if($strEstado!="Tardanza" && $strEstado!="Puntual" && $strEstado!="Justificado"){
					die();
				}				
				if($intIdAsistencia == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_asistencia = $this->model->insertAsistencia($strDNI, $strFechaRegistro,$observaciones, $strEstado);
						$option = 1;
					}
				}else{
					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_asistencia = $this->model->updateAsistencia($intIdAsistencia, $strDNI, $strFechaRegistro, $observaciones, $strEstado);
						$option = 2;
					}
				}

				if($request_asistencia > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_asistencia == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! La asistencia ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delAsistencia()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdAsistencia = intval($_POST['idasistencia']);
					$requestDelete = $this->model->deleteAsistencia($intIdAsistencia);
					
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la asistencia');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar la asistencia asociado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Asistencia.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>