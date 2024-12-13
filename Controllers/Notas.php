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
        $data['page_tag'] = "Notas Concepción";
        $data['page_name'] = "Notas_concepcion";
        $data['page_title'] = "Concepcion<small> Notas</small>";
        
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
            $data['page_tag'] = "Notas CONCEPCION";
            $data['page_name'] = "Notas_concepcion";
            $data['page_title'] = "Unimat<small> Notas</small>";   
            $data['Periodo'] = $this->model->getPeriodo(PERIODO);
            $data['Aula'] = $this->model->getAula($id_aula);
            $data['Curso'] = $this->model->getCurso($id_curso);
            $data['Grado'] = $this->model->getGrado($id_grado);
            $data['competencias']=$this->model->getCompetencias($id_curso);
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
            
            switch ($id_curso){
                case 1:
                    $tabla = TABLA_CURSO_1;
                    break;
                case 2:
                    $tabla = TABLA_CURSO_2;
                    break;
                case 3:
                    $tabla = TABLA_CURSO_3;
                    break;
                case 4:
                    $tabla = TABLA_CURSO_4;
                    break;
                case 5:
                    $tabla = TABLA_CURSO_5;
                    break;
                case 6:
                    $tabla = TABLA_CURSO_6;
                    break;
                case 7:
                    $tabla = TABLA_CURSO_7;
                    break;
                    case 8:
                        $tabla = TABLA_CURSO_8;
                        break;
                    case 9:
                        $tabla = TABLA_CURSO_9;
                        break;
                    case 10:
                        $tabla = TABLA_CURSO_10;
                        break;
                default:
                    $tabla = null;
                    break;
            }
            
            $arrData=$this->model->selectNotas($id_aula, $id_grado, $id_curso, $tabla, PERIODO);

            for ($i=0; $i < count($arrData); $i++) {               

                if($arrData[$i]['status'] == 1)
                {
                    $arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
                }

                if($_SESSION['permisosMod']['u']){
                    $btnView = '<button class="btn btn-secondary btn-sm " onClick="fntViewNota('.$arrData[$i]['id_nota'].')" title="Permisos"><i class="bi bi-eye-fill"></i></button>';
                    
                }                
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.'</div>';
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
        $nota= intval($_POST['nota']);        
        $intIdCompetencia= isset($_POST['competenciaSeleccionada']) ? intval($_POST['competenciaSeleccionada']) : 0;
        $intStatus = intval($_POST['listStatus']);
        $strTema= strClean($_POST['tema']);
        $strBimestre= strClean($_POST['bimestres']);
        $id_curso = intval($_POST['idCurso']);
        $request_nota = "";
        switch ($id_curso){
            case 1:
                $tabla = TABLA_CURSO_1;
                break;
            case 2:
                $tabla = TABLA_CURSO_2;
                break;
            case 3:
                $tabla = TABLA_CURSO_3;
                break;
            case 4:
                $tabla = TABLA_CURSO_4;
                break;
            case 5:
                $tabla = TABLA_CURSO_5;
                break;
            case 6:
                $tabla = TABLA_CURSO_6;
                break;
            case 7:
                $tabla = TABLA_CURSO_7;
                break;
                case 8:
                    $tabla = TABLA_CURSO_8;
                    break;
                case 9:
                    $tabla = TABLA_CURSO_9;
                    break;
                case 10:
                    $tabla = TABLA_CURSO_10;
                    break;
            default:
                $tabla = null;
                break;
        }
        
        if($intIdNota == 0)
        {
            //Crear
            if($_SESSION['permisosMod']['w']){
                $request_nota = $this->model->insertNota($tabla, $intIdAsignacion, $intIdDocente, $nota,$intIdCompetencia, $strTema, $strBimestre,$intStatus, PERIODO);
                $option = 1;
            }
        }else{
            //Actualizar
            if($_SESSION['permisosMod']['u']){
                $request_nota = $this->model->updateNota($intIdNota,$intStatus);
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
        }
       
        public function exportarExcel()
        {
            
            if ($_SESSION['permisosMod']['r']) {
                // Validar y obtener los datos enviados
                $bimestre = $_POST['bimestre'] ?? '';
                $id_curso = intval($_POST['id_curso'] ?? 0);
                $id_aula = intval($_POST['id_aula'] ?? 0);
                $id_grado = intval($_POST['id_grado'] ?? 0);
                
                // Validación básica
                if (empty($bimestre) || $id_curso === 0 || $id_aula === 0 || $id_grado === 0) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
                    echo(json_encode($arrResponse));                   
                    exit;
                }
            
                switch ($id_curso){
                    case 1:
                        $tabla = TABLA_CURSO_1;
                        break;
                    case 2:
                        $tabla = TABLA_CURSO_2;
                        break;
                    case 3:
                        $tabla = TABLA_CURSO_3;
                        break;
                    case 4:
                        $tabla = TABLA_CURSO_4;
                        break;
                    case 5:
                        $tabla = TABLA_CURSO_5;
                        break;
                    case 6:
                        $tabla = TABLA_CURSO_6;
                        break;
                    case 7:
                        $tabla = TABLA_CURSO_7;
                        break;
                    case 8:
                        $tabla = TABLA_CURSO_8;
                        break;
                    case 9:
                        $tabla = TABLA_CURSO_9;
                        break;
                    case 10:
                        $tabla = TABLA_CURSO_10;
                        break;
                    default:
                        $tabla = null;
                        break;
                }

                $resultados = $this->model->getNotasPromediadas($tabla, $bimestre, $id_curso, $id_aula, $id_grado, PERIODO);
                
                if (is_array($resultados)) {
                    $asignaciones = $resultados['asignaciones'];
                    $competencias = $resultados['competencias'];
                    $notas = $resultados['notas'];

                    // Reorganizar los datos en un formato adecuado para el Excel
                    $dataExcel = [];
                    foreach ($asignaciones as $asignacion) {
                        $row = [
                            'alumno' => $asignacion['nombres']
                        ];

                        foreach ($competencias as $competencia) {
                            // Busca la nota para esta asignación y competencia
                            $nota = array_filter($notas, function ($nota) use ($asignacion, $competencia) {
                                return $nota['id_asignacion'] === $asignacion['id_asignacion'] &&
                                    $nota['id_competencia'] === $competencia['id_competencia'];
                            });

                            // Si hay nota, agrégala; si no, deja en blanco
                            $row[$competencia['nombre_competencias']] = !empty($nota) ? array_values($nota)[0]['promedio'] : '';
                        }

                        $dataExcel[] = $row;
                    }
                    
                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    $sheet = $spreadsheet->getActiveSheet();

                    // Encabezados del archivo Excel
                    $sheet->setCellValue('A1', 'Alumno');
                    $col = 'B';
                    foreach ($competencias as $competencia) {
                        $sheet->setCellValue($col . '1', $competencia['nombre_competencias']);
                        $col++;
                    }

                    // Agregar datos al archivo Excel
                    $fila = 2; // Iniciar en la fila 2 (debajo de los encabezados)
                    foreach ($dataExcel as $dataRow) {
                        $col = 'A';
                        foreach ($dataRow as $key => $value) {
                            $sheet->setCellValue($col . $fila, $value);
                            $col++;
                        }
                        $fila++;
                    }

                    // Estilizar los encabezados
                    $sheet->getStyle('A1:' . $col . '1')->getFont()->setBold(true);               
            
                    $tempDir = __DIR__ . '/../Assets/temporal/';
                    if (!is_dir($tempDir)) {
                        mkdir($tempDir, 0777, true);
                    }
                    $auxPath='notas_agrupadas_' . uniqid() . '.xlsx';
                    $tempFilePath = $tempDir .$auxPath;
                    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                    $writer->save($tempFilePath);


                    // Enviar la ruta del archivo al cliente
                    $arrResponse = array('status' => true, 'file_path' => $tempFilePath, 'url_dowland'=>media().'/temporal/'.$auxPath);
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    exit;

                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se encontraron datos para exportar.');
                    echo(json_encode($arrResponse, JSON_UNESCAPED_UNICODE));
                    exit;
                }
        
        }

    }

    public function deleteTempFile()
{
    $input = json_decode(file_get_contents('php://input'), true);
    $filePath = $input['file_path'] ?? '';

    if (file_exists($filePath)) {
        unlink($filePath); // Eliminar el archivo
        echo json_encode(['status' => true, 'msg' => 'Archivo eliminado.']);
    } else {
        echo json_encode(['status' => false, 'msg' => 'Archivo no encontrado.']);
    }
}


}
