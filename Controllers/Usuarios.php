<?php 
	
	class Usuarios extends Controllers{
		
		public function __construct()
		{
			parent::__construct();
			session_start();			
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}			
			getPermisos(MUSUARIOS);
			
		}

		public function Usuarios()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "USUARIOS <small>UNIMAT</small>";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if($_POST){			
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));
					$request_user = "";
					if($idUsuario == 0)
					{
						$option = 1;
						$strPassword =  empty($_POST['txtPassword']) ? password_hash(passGenerator(), PASSWORD_DEFAULT) : password_hash($_POST['txtPassword'], PASSWORD_DEFAULT);						
						if($_SESSION['permisosMod']['w']){
							$request_user = $this->model->insertUsuario($strIdentificacion,
																				$strNombre, 
																				$strApellido, 
																				$intTelefono, 
																				$strEmail,
																				$strPassword, 
																				$intTipoId, 
																				$intStatus );
						}
					}else{
						$option = 2;
						$strPassword =  empty($_POST['txtPassword']) ? password_hash(passGenerator(), PASSWORD_DEFAULT) : password_hash($_POST['txtPassword'], PASSWORD_DEFAULT);
						if($_SESSION['permisosMod']['u']){
							$request_user = $this->model->updateUsuario($idUsuario,
																		$strIdentificacion, 
																		$strNombre,
																		$strApellido, 
																		$intTelefono, 
																		$strEmail,
																		$strPassword, 
																		$intTipoId, 
																		$intStatus);
						}

					}
					if(intval($request_user) > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
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

		private function canEditUser($row)
		{
			// Si el usuario logueado es administrador
			if ($_SESSION['userData']['id_rol'] == RADMINISTRADOR) {
				// No puede editar a otros administradores, excepto a sí mismo
				if ($row['id_rol'] == RADMINISTRADOR) {
					return $_SESSION['userData']['id_usuario'] == $row['id_usuario'];
				}
				// Puede editar a todos los demás roles
				return true;
			}
			// Para roles distintos a administrador, no puede editar
			return false;
		}

		public function getUsuarios()
		{
			if (!$_SESSION['permisosMod']['r']) {
				echo json_encode(['error' => 'Acceso no autorizado']);
				die();
			}

			try {
				header('Content-Type: application/json; charset=utf-8');
				
				$arrData = $this->model->selectUsuarios(RALUMNOS);
				if ($arrData === false) {
					throw new Exception("Error al obtener los usuarios");
				}

				// Procesar datos y generar botones
				foreach ($arrData as &$row) {
					// Formatear el estado
					$row['status'] = $row['status'] == 1 
						? '<span class="badge bg-success">Activo</span>' 
						: '<span class="badge bg-danger">Inactivo</span>';

					// Lógica para botones
					$btnView = $btnEdit = $btnDelete = '';

					// Botón Ver
					if ($_SESSION['permisosMod']['r']) {
						$btnView = sprintf(
							'<button class="btn btn-info btn-sm btnViewUsuario text-white" onClick="fntViewUsuario(%d)" title="Ver usuario"><i class="bi bi-eye-fill"></i></button>',
							$row['id_usuario']
						);
					}

					// Botón Editar
					if ($_SESSION['permisosMod']['u']) {
						if ($_SESSION['userData']['id_rol'] == RADMINISTRADOR) {
							// Administrador solo puede editar a sí mismo o usuarios no administradores
							if ($row['id_rol'] == RADMINISTRADOR) {
								if ($_SESSION['userData']['id_usuario'] == $row['id_usuario']) {
									$btnEdit = sprintf(
										'<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario(this,%d)" title="Editar usuario"><i class="bi bi-pencil"></i></button>',
										$row['id_usuario']
									);
								} else {
									$btnEdit = '<button class="btn btn-secondary btn-sm" disabled><i class="bi bi-pencil"></i></button>';
								}
							} else {
								$btnEdit = sprintf(
									'<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario(this,%d)" title="Editar usuario"><i class="bi bi-pencil"></i></button>',
									$row['id_usuario']
								);
							}
						} else {
							// Otros roles no pueden editar
							$btnEdit = '<button class="btn btn-secondary btn-sm" disabled><i class="bi bi-pencil"></i></button>';
						}
					}

					// Botón Eliminar
					if ($_SESSION['permisosMod']['d']) {
						if ($_SESSION['userData']['id_rol'] == RADMINISTRADOR) {
							// Administrador no puede eliminar a otros administradores
							if ($row['id_rol'] == RADMINISTRADOR) {
								$btnDelete = '<button class="btn btn-secondary btn-sm" disabled><i class="bi bi-trash"></i></button>';
							} else {
								$btnDelete = sprintf(
									'<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario(%d)" title="Eliminar usuario"><i class="bi bi-trash"></i></button>',
									$row['id_usuario']
								);
							}
						} else {
							// Otros roles no pueden eliminar
							$btnDelete = '<button class="btn btn-secondary btn-sm" disabled><i class="bi bi-trash"></i></button>';
						}
					}

					// Combinar los botones en una columna
					$row['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
				}

				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			} catch (Exception $e) {
				error_log('Error en getUsuarios: ' . $e->getMessage());
				echo json_encode(['error' => 'Ocurrió un error al procesar la solicitud']);
			}
			die();
		}


		public function getUsuario($idpersona){			
			if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idpersona);
				if($idusuario > 0)
				{
					$arrData = $this->model->selectUsuario($idusuario);
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

		public function delUsuario()
		{
			
				if($_SESSION['permisosMod']['d']){
					$postData = json_decode(file_get_contents('php://input'), true);					
					$intIdpersona = intval($postData['idUsuario']);
					
					$requestDelete = $this->model->deleteUsuario($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			
			die();
		}

		public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil de usuario";
			$data['page_name'] = "perfil";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"perfil",$data);
		}

		public function putPerfil(){
			if($_POST){
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = strClean($_POST['txtNombre']);
					$strApellido = strClean($_POST['txtApellido']);
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strPassword = "";
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
					$request_user = $this->model->updatePerfil($idUsuario,
																$strIdentificacion, 
																$strNombre,
																$strApellido, 
																$intTelefono, 
																$strPassword);
					if($request_user)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}			
	}
 ?>