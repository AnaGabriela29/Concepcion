<?php 

	class Login extends Controllers{
		public function __construct()
		{
			session_start();
			if(isset($_SESSION['login']))
			{
				header('Location: '.base_url().'/dashboard');
				die();
			}
			parent::__construct();
		}

		public function login()
		{
			$data['page_tag'] = "Login - Colegio UNIMAT";
			$data['page_title'] = "UNIMAT";
			$data['page_name'] = "login";
			$data['page_functions_js'] = "functions_login.js";
			$this->views->getView($this,"login",$data);
		}

		public function loginUser() {
			
			if ($_POST) {
				if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				} else {
					$strUsuario = strtolower(strClean($_POST['txtEmail']));
					$strPassword = $_POST['txtPassword'];
					$requestUser = $this->model->loginUser($strUsuario);
		
					if (isset($_SESSION['login_blocked']) && $_SESSION['login_blocked'] > time()) {
						$remainingTime = $_SESSION['login_blocked'] - time();
						$arrResponse = array('status' => false, 'msg' => "Cuenta bloqueada. Inténtalo de nuevo en $remainingTime segundos.");
					} else {
						if (empty($requestUser)) {
							$arrResponse = array('status' => false, 'msg' => 'El usuario no existe');
						} else {
							if (password_verify($strPassword, $requestUser['contrasena'])) {
								if ($requestUser['status'] == 1) {
									$_SESSION['idUser'] = $requestUser['id_usuario'];
									$_SESSION['login'] = true;
									$_SESSION['login_attempts'] = 0; // Reiniciar el contador de intentos de inicio de sesión
									unset($_SESSION['login_blocked']); // Eliminar el bloqueo
									$_SESSION['times_blocked'] = 0; // Reiniciar la cuenta de bloqueos
		
									$arrData = $this->model->sessionLogin($_SESSION['idUser']);
									sessionUser($_SESSION['idUser']);
									$arrResponse = array('status' => true, 'msg' => 'ok');
								} else {
									$arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
								}
							} else {
								$_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;
								if ($_SESSION['login_attempts'] >= 3) {
									$_SESSION['login_attempts'] = 0; // Reiniciar intentos
									$_SESSION['times_blocked'] = isset($_SESSION['times_blocked']) ? $_SESSION['times_blocked'] + 1 : 1;
									$blockTime = [1, 5, 10]; // Minutos para bloquear: 1, 5, y 10
									$minutesToBlock = $blockTime[$_SESSION['times_blocked'] - 1] ?? 10; // Si supera los índices, usar 10 minutos
									$_SESSION['login_blocked'] = time() + ($minutesToBlock * 60); // Bloquear cuenta
									$arrResponse = array('status' => false, 'msg' => "Demasiados intentos fallidos. Cuenta bloqueada temporalmente por $minutesToBlock minutos.");
								} else {
									$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.');
								}
							}
						}
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		

		public function resetPass(){
			if($_POST){
				error_reporting(0);

				if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					if(isset($_SESSION['reset_attempts']) && $_SESSION['reset_attempts'] >= 1){
						$arrResponse = array('status' => false, 'msg' => 'Ya se ha enviado una solicitud de cambio de contraseña.');
					} else {
						$strEmail  =  strtolower(strClean($_POST['txtEmailReset']));
						$arrData = $this->model->getUserEmail($strEmail);
					$token = token();
					$strEmail  =  strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);

					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Usuario no existente.' ); 
					}else{
						$_SESSION['reset_attempts'] = 1;  // Establecer el intento de reseteo de contraseña						
						$idpersona = $arrData['id_usuario'];
						$nombreUsuario = $arrData['nombres'].' '.$arrData['apellidos'];

						$url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;
						$requestUpdate = $this->model->setTokenUser($idpersona,$token);

						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'asunto' => 'Recuperar cuenta - '.NOMBRE_REMITENTE,
											 'url_recovery' => $url_recovery);
						if($requestUpdate){
							$sendEmail = sendEmail($dataUsuario,'email_cambioPassword');
							
							if($sendEmail){
								
								$arrResponse = array('status' => true, 
												 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');
							}else{
								
								$arrResponse = array('status' => false, 
												 'msg' => 'No es posible realizar el proceso, intenta más tarde.' );
							}
						}else{
							$arrResponse = array('status' => false, 
												 'msg' => 'No es posible realizar el proceso, intenta más tarde.' );
						}
					}
				 }
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function confirmUser(string $params){

			if(empty($params)){
				header('Location: '.base_url());
			}else{
				$arrParams = explode(',',$params);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
				$arrResponse = $this->model->getUsuario($strEmail,$strToken);
				if(empty($arrResponse)){
					header("Location: ".base_url());
				}else{
					$data['page_tag'] = "Cambiar contraseña";
					$data['page_name'] = "cambiar_contrasenia";
					$data['page_title'] = "Cambiar Contraseña";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['idpersona'] = $arrResponse['id_usuario'];
					$data['page_functions_js'] = "functions_login.js";
					$this->views->getView($this,"cambiar_password",$data);
				}
			}
			die();
		}

		public function setPassword(){

			if(empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])){

					$arrResponse = array('status' => false, 
										 'msg' => 'Error de datos' );
				}else{
					$intIdpersona = intval($_POST['idUsuario']);
					$strPassword = $_POST['txtPassword'];
					$strPasswordConfirm = $_POST['txtPasswordConfirm'];
					$strEmail = strClean($_POST['txtEmail']);
					$strToken = strClean($_POST['txtToken']);

					if($strPassword != $strPasswordConfirm){
						$arrResponse = array('status' => false, 
											 'msg' => 'Las contraseñas no son iguales.' );
					}else{
						$arrResponseUser = $this->model->getUsuario($strEmail,$strToken);
						if(empty($arrResponseUser)){
							$arrResponse = array('status' => false, 
											 'msg' => 'Erro de datos.' );
						}else{
							$strPassword = password_hash($strPassword, PASSWORD_DEFAULT);;
							
							$requestPass = $this->model->insertPassword($intIdpersona,$strPassword);

							if($requestPass){
								$arrResponse = array('status' => true, 
													 'msg' => 'Contraseña actualizada con éxito.');
							}else{
								$arrResponse = array('status' => false, 
													 'msg' => 'No es posible realizar el proceso, intente más tarde.');
							}
						}
					}
				}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

	}
 ?>