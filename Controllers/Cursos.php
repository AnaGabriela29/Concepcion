<?php 

	class Cursos extends Controllers{
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
			getPermisos(MCURSOS);
		}

		public function Cursos()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Cursos UNIMAT";
			$data['page_name'] = "cursos_unimat";
			$data['page_title'] = "Unimat<small> Cursos</small>";
			$data['page_functions_js'] = "functions_cursos.js";
			$this->views->getView($this,"Cursos",$data);
		}

		public function getCursos()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectCursos();

				for ($i=0; $i < count($arrData); $i++) {

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['u']){
						$btnView = '<button class="btn btn-secondary btn-sm " onClick="fntViewCurso('.$arrData[$i]['id_curso'].')" title="Permisos"><i class="bi bi-key"></i></button>';
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditCurso('.$arrData[$i]['id_curso'].')" title="Editar"><i class="bi bi-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelCurso('.$arrData[$i]['id_curso'].')" title="Eliminar"><i class="bi bi-trash3"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectCursos()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectCursos();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_curso'].'">'.$arrData[$i]['nombre'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getCurso(int $idcurso)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdCurso = intval(strClean($idcurso));
				if($intIdCurso > 0)
				{
					$arrData = $this->model->selectCurso($intIdCurso);
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

		public function setCurso(){
				$intIdCurso = intval($_POST['idCurso']);
				$strCurso =  strClean($_POST['txtNombreCurso']);
				$strDescipcion = strClean($_POST['txtDescripcionCurso']);
				$intStatus = intval($_POST['listStatus']);
				$request_curso = "";
				if($intIdCurso == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_curso = $this->model->insertCurso($strCurso, $strDescipcion,$intStatus);
						$option = 1;
					}
				}else{
					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_curso = $this->model->updateCurso($intIdCurso, $strCurso, $strDescipcion, $intStatus);
						$option = 2;
					}
				}

				if(intval($request_curso) > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_curso == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Curso ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delCurso()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdCurso = intval($_POST['idcurso']);
					$requestDelete = $this->model->deleteCurso($intIdCurso);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Curso');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Curso asociado a otros datos.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Curso.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>