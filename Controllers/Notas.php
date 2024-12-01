<?php
class Notas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MNOTAS);
    }

    public function Notas(){
        if(empty($_SESSION['permisosMod']['r'])){
            header("Location:".base_url().'/dashboard');
        }
        $data['page_id'] = 8;
        $data['page_tag'] = "Notas UNIMAT";
        $data['page_name'] = "Notas_unimat";
        $data['page_title'] = "Unimat<small> Notas</small>";
        
        // Generar un token CSRF y almacenarlo en la sesión
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }        
        $data['token']=$_SESSION['token'];

        if( $_SESSION['userData']['id_rol'] == RDOCENTE ){
            $data['page_functions_js'] = "functions_notasDocente.js";
            $data['asignaciones']=$this->model->getAsignaciones(intval($_SESSION['userData']['id_usuario'])); 
           
            $this->views->getView($this,"NotasDocente",$data);
        }else if($_SESSION['userData']['id_rol'] == RADMINISTRADOR){
            $data['Periodo'] = $this->model->getPeriodo(PERIODO);
            $data['Aulas'] = $this->model->cantidadAulas();
            $data['Cursos'] = $this->model->cantidadCursos();
            $data['Grados'] = $this->model->cantidadGrados();
            $data['page_functions_js'] = "functions_notas.js";            
            $this->views->getView($this,"Notas",$data);
        }
    }
    // ===============================
    // Functions para los docentes 
    // ===============================

    public function getAlumnos($params){
        if(empty($_SESSION['permisosMod']['r'] )){
            header("Location:".base_url().'/dashboard');
        }
        $arrParams = explode(",", $params);
        $id_aula = intval(strclean($arrParams[0]));
        $id_grado = intval(strClean($arrParams[1]));
        $id_curso = intval(strClean($arrParams[2]));
        $id_docente= intval($_SESSION['userData']['id_usuario']);

        $arrData=$this->model->selectAlumnos($id_docente, $id_aula, $id_curso, $id_grado);
        if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}       
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    public function setNotas($params){
    
            if($_SESSION['permisosMod']['w']){
            $data = json_decode(file_get_contents('php://input'), true);
            //comparamos el token para verfiicar el hash y si tenemos respuesta
            if (!empty($data) && hash_equals($_SESSION['token'], $data['csrf'])) {                             
                
                foreach ($data['notasData'] as $nota) {
                    //filtramos los datos y limpiamos
                    $idAsignacion = strClean($nota['id_asignacion']);
                    $valorNota = strClean($nota['nota']);        
                    $idAsignacion = filter_var($idAsignacion, FILTER_VALIDATE_INT);
                    $valorNota = filter_var($valorNota, FILTER_VALIDATE_INT);
                    if($valorNota>20 && $valorNota<0){
                        $arrResponse= array('status' => false, 'msg' => 'Datos fuera del rango');
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                        die();
                    }       
                    $notasArray[] = array(
                        'id_asignacion' => $idAsignacion,
                        'nota' => $valorNota
                    );
                }
                $arrData=$this->model->insertarNotas($notasArray, intval($_SESSION['userData']['id_usuario']), intval(PERIODO));
                echo $arrData; 
                if(empty($arrData)){
                    $arrResponse= array('status' => false, 'msg' => 'No se puedo enviar los datos');                
                }else if($arrData==='error' || $arrData==='inhabilitado'){
                    $arrResponse= array('status' => false, 'msg' => 'No esta habilitado, cominiquese con soporte');     
                }else{
                    $arrResponse= array('status' => true, 'msg' => 'Notas Enviadas Correctamente');  
                }

            } else {
                $arrResponse= array('status' => false, 'msg' => 'Datos no encontrados.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
            }        
    }

    // ===============================
    // Functions para los administradores
    // ===============================

    public function notasAdmin($params){
        if($_SESSION['userData']['id_rol'] != RADMINISTRADOR && empty($_SESSION['permisosMod']['r'])){
            header("Location:" . base_url() . '/home');
            die();        
        }else{
            $arrParams = explode(",", $params);
            $id_aula = intval($arrParams[0]);
            $id_grado = intval($arrParams[1]);
            $id_curso = intval($arrParams[2]);
             // Generar un token CSRF y almacenarlo en la sesión
            if (empty($_SESSION['token'])) {
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }        
            $data['token']=$_SESSION['token'];
            $data['page_tag'] = "Notas UNIMAT";
            $data['page_name'] = "Notas_unimat";
            $data['page_title'] = "Unimat<small> Notas</small>";   
            $data['Periodo'] = $this->model->getPeriodo(PERIODO);
            $data['Aula'] = $this->model->getAula($id_aula);
            $data['Curso'] = $this->model->getCurso($id_curso);
            $data['Grado'] = $this->model->getGrado($id_grado);
            $data['page_functions_js'] = "functions_notas.js";            
            $this->views->getView($this,"notasAdmin",$data);            
        }
    }

    public function getNotas($params){
        
        if ($_SESSION['permisosMod']['r']) {
            $arrParams = explode(",", $params);
            $id_aula = intval($arrParams[0]);
            $id_grado = intval($arrParams[1]);
            $id_curso = intval($arrParams[2]);
            
            $arrData=$this->model->selectNotas($id_aula, $id_grado, $id_curso, PERIODO);

            for ($i=0; $i < count($arrData); $i++) {
                $arrData[$i]['nota_1'] = $arrData[$i]['nota_1'] ?? " ";
                $arrData[$i]['nota_2'] = $arrData[$i]['nota_2'] ?? " ";
                $arrData[$i]['nota_3'] = $arrData[$i]['nota_3'] ?? " ";
                $arrData[$i]['nota_4'] = $arrData[$i]['nota_4'] ?? " ";


                if($arrData[$i]['status'] == 1)
                {
                    $arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
                }

                if($_SESSION['permisosMod']['u']){
                    $btnView = '<button class="btn btn-secondary btn-sm " onClick="fntViewNota('.$arrData[$i]['id_nota'].')" title="Permisos"><i class="bi bi-eye-fill"></i></button>';
                    $btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditNota('.$arrData[$i]['id_nota'].')" title="Editar"><i class="bi bi-pencil"></i></button>';
                }
                if($_SESSION['permisosMod']['d']){
                    $btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelNota('.$arrData[$i]['id_nota'].')" title="Eliminar"><i class="bi bi-trash3"></i></button>
                </div>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setNota(){
        if($_SESSION['permisosMod']['w'] && hash_equals($_SESSION['token'], $_POST['csrf']))
        $intIdNota = intval($_POST['idNota']);
        $intIdAsignacion = isset($_POST['listaAlumnos']) ? intval($_POST['listaAlumnos']) : 0;
        $intIdDocente = isset($_POST['listaDocentes']) ? intval($_POST['listaDocentes']) : 0;
        $nota1= intval($_POST['nota1']);
        $nota2= intval($_POST['nota2']);
        $nota3= intval($_POST['nota3']);
        $nota4= intval($_POST['nota4']);
        $intStatus = intval($_POST['listStatus']);
        $request_nota = "";
        if($intIdNota == 0)
        {
            //Crear
            if($_SESSION['permisosMod']['w']){
                $request_nota = $this->model->insertNota($intIdAsignacion, $intIdDocente, $nota1, $nota2, $nota3, $nota4,$intStatus, PERIODO);
                $option = 1;
            }
        }else{
            //Actualizar
            if($_SESSION['permisosMod']['u']){
                $request_nota = $this->model->updateNota($intIdNota, $nota1, $nota2, $nota3, $nota4,$intStatus);
                $option = 2;
            }
        }

        if(intval($request_nota) > 0 )
        {
            if($option == 1)
            {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            }else{
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
            }
        }else if($request_nota == 'exist'){
            
            $arrResponse = array('status' => false, 'msg' => '¡Atención! La nota ya existe.');
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    die();
}

    public function delNota()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdNota = intval($_POST['idNota']);
					$requestDelete = $this->model->deleteNota($intIdNota);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la nota');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una nota asociada.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

        public function getnota($idNota){
            if ($_SESSION['permisosMod']['r']) {              
                
                $arrData = $this->model->obtenerNota($idNota);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);            
        }
        die();
        }

        public function getNotaAlumno($idNota){
            if ($_SESSION['permisosMod']['r']) {             
                
                $arrData = $this->model->obtenerNotaAlumno($idNota);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);            
        }
        die();
        }

        public function getDocentes($params){
            if ($_SESSION['permisosMod']['r']) {
                $search = isset($_GET['q']) ? strClean($_GET['q']) : null;
                $arrParams = explode(",", $params);
                $id_aula = intval($arrParams[0]);
                $id_grado = intval($arrParams[1]);
                $id_curso = intval($arrParams[2]);
                $arrData = $this->model->obtenerDocente($id_aula, $id_grado,$id_curso, $search, RDOCENTE);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);            
        }
        die();
        }

        public function getAlumnosModal($params){
            if ($_SESSION['permisosMod']['r']) {
                $search = isset($_GET['q']) ? strClean($_GET['q']) : null;
                $arrParams = explode(",", $params);
                $id_aula = intval($arrParams[0]);
                $id_grado = intval($arrParams[1]);
                $id_curso = intval($arrParams[2]);
                $arrData = $this->model->obtenerAlumnos($id_aula, $id_grado,$id_curso, $search, RALUMNOS);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);            
        }
        die();
        }


}
