<?php 

	class Aulas extends Controllers{
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
			getPermisos(MAULAS);
		}

		public function Aulas()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Aulas UNIMAT";
			$data['page_name'] = "Aulas_unimat";
			$data['page_title'] = "Unimat<small> Aulas</small>";
			$data['page_functions_js'] = "functions_aulas.js";
			$this->views->getView($this,"Aulas",$data);
		}

		public function getAulas()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectAulas();

				for ($i=0; $i < count($arrData); $i++) {

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['u']){
						$btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewAula('.$arrData[$i]['id_aula'].')" title="Permisos"><i class="bi bi-eye"></i></button>';
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditAula('.$arrData[$i]['id_aula'].')" title="Editar"><i class="bi bi-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelAula('.$arrData[$i]['id_aula'].')" title="Eliminar"><i class="bi bi-trash3"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectAulas()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectAulas();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_aula'].'">'.$arrData[$i]['nombre'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getAula(int $idaula)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdAula = intval(strClean($idaula));
				if($intIdAula > 0)
				{
					$arrData = $this->model->selectAula($intIdAula);
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

		public function setAula(){
				$intIdAula = intval($_POST['idAula']);
				$strAula =  strClean($_POST['txtNombreAula']);
				$strDescipcion = strClean($_POST['txtDescripcionAula']);
				$intStatus = intval($_POST['listStatus']);
				$request_aula = "";
				if($intIdAula == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_aula = $this->model->insertAula($strAula, $strDescipcion,$intStatus);
						$option = 1;
					}
				}else{
					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_aula = $this->model->updateAula($intIdAula, $strAula, $strDescipcion, $intStatus);
						$option = 2;
					}
				}

				if($request_aula > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_aula == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Aula ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delAula()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdAula = intval($_POST['idaula']);
					$requestDelete = $this->model->deleteAula($intIdAula);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Aula');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Aula asociado a usuarios.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Aula.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>