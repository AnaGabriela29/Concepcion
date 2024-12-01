<?php 

	class Asistencia extends Controllers{
		
		public function __construct()
		{
			parent::__construct();
			session_start();
			
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}			
			getPermisos(MASISTENCIA);
			// Solo regenera el ID de la sesión si la sesión ya está activa
			
		}

		public function Asistencia(){
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Asistencia";
			$data['page_title'] = "Asistencia <small>UNIMAT</small>";
			$data['page_name'] = "asistencia";
			$data['page_functions_js'] = "functions_asistencia.js";		
			$data['librarie']=media()."/js/plugins/html5-qrcode.min.js";	
			$this->views->getView($this,"Asistencia",$data);
		}

		public function setAsistencia(){		
				
				$horaActual= new DateTime();
				$fechaActual=$horaActual;				
				$horaInicioAsistencia = DateTime::createFromFormat('H:i:s', HORAINICIOASISTENCIA);
    			$horaFinalAsistencia = DateTime::createFromFormat('H:i:s', HORAFINALASISTENCIA);
				
				// if($_SESSION['permisosMod']['w'] && ($horaActual>=$horaInicioAsistencia && $horaActual<=$horaFinalAsistencia) && !empty($_POST['identificacion'])){		
					if($_SESSION['permisosMod']['w'] && !empty($_POST['idUsuario'])){									
					$intIdUsuario = intval($_POST['idUsuario']);
					$strEstado = strClean($_POST['estado']);
					if($strEstado!="Puntual" && $strEstado!="Tardanza"){
						die() ;
					}
					
					$requestInsert = $this->model->insertarAsistencia($intIdUsuario, $fechaActual, $strEstado);

					if($requestInsert == 'ok')					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha registrado la asistencia correctamente.');
					}else if($requestInsert == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'Ya esta registrado su asistencia.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al insertar la asistencia.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
				
			die();
		}

		public function setAsistenciaDni(){		
				
			$horaActual= new DateTime();
			$fechaActual=$horaActual;				
			$horaInicioAsistencia = DateTime::createFromFormat('H:i:s', HORAINICIOASISTENCIA);
			$horaFinalAsistencia = DateTime::createFromFormat('H:i:s', HORAFINALASISTENCIA);
			
			// if($_SESSION['permisosMod']['w'] && ($horaActual>=$horaInicioAsistencia && $horaActual<=$horaFinalAsistencia) && !empty($_POST['identificacion'])){		
				if($_SESSION['permisosMod']['w'] && !empty($_POST['identificacion'])){									
				$intIdIdentificacion = strClean($_POST['identificacion']);
				$strEstado = strClean($_POST['estado']);
				if($strEstado!="Puntual" && $strEstado!="Tardanza"){
					echo "sds";
					// die() ;
				}
				$requestInsert = $this->model->insertarAsistenciaDni($intIdIdentificacion, $fechaActual, $strEstado);
				
				if($requestInsert == 'ok')					{
					$arrResponse = array('status' => true, 'msg' => 'Se ha registrado la asistencia correctamente.');
				}else if($requestInsert == 'exist'){
					$arrResponse = array('status' => false, 'msg' => 'Ya esta registrado su asistencia.');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al insertar la asistencia.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		
		die();
	}
    }

?>