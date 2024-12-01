<?php 

	class Grados extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MGRADOS);
		}

		public function Grados()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Grados UNIMAT";
			$data['page_name'] = "grados_unimat";
			$data['page_title'] = "Unimat<small> Grados</small>";
			$data['page_functions_js'] = "functions_grados.js";
			$this->views->getView($this,"Grados",$data);
		}

		public function getGrados()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectGrados();

				for ($i=0; $i < count($arrData); $i++) {

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['u']){
						$btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewGrado('.$arrData[$i]['id_grado'].')" title="Permisos"><i class="bi bi-eye"></i></button>';
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditGrado('.$arrData[$i]['id_grado'].')" title="Editar"><i class="bi bi-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelGrado('.$arrData[$i]['id_grado'].')" title="Eliminar"><i class="bi bi-trash3"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectGrados()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectGrados();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_grado'].'">'.$arrData[$i]['nombre'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getGrado(int $idgrado)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdGrado = intval(strClean($idgrado));
				if($intIdGrado > 0)
				{
					$arrData = $this->model->selectGrado($intIdGrado);
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

		public function setGrado(){
				$intIdGrado = intval($_POST['idGrado']);
				$strGrado =  strClean($_POST['txtNombreGrado']);
				$strDescipcion = strClean($_POST['txtDescripcionGrado']);
				$intStatus = intval($_POST['listStatus']);
				$request_grado = "";
				if($intIdGrado == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_grado = $this->model->insertGrado($strGrado, $strDescipcion,$intStatus);
						$option = 1;
					}
				}else{
					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_grado = $this->model->updateGrado($intIdGrado, $strGrado, $strDescipcion, $intStatus);
						$option = 2;
					}
				}

				if($request_grado > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_grado == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Grado ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delGrado()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdGrado = intval($_POST['idgrado']);
					$requestDelete = $this->model->deleteGrado($intIdGrado);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Grado');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Grado asociado a usuarios.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Grado.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>