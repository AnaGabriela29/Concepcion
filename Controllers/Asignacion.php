<?php

class Asignacion extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();        
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MCONFIGURACION);
    }

    public function Asignacion()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 7;
        $data['page_tag'] = "Asignaciones - Colegio unimat";
        $data['page_title'] = "Asignaciones - Colegio Unimat";
        $data['page_name'] = "configuración";
        $data['page_functions_js'] = "functions_asignacion.js";
        $data['Periodo'] = $this->model->getPeriodo(PERIODO);
        $data['Aulas'] = $this->model->cantidadAulas();
        $data['Cursos'] = $this->model->cantidadCursos();
        $data['Grados'] = $this->model->cantidadGrados();


        $this->views->getView($this, "Asignacion", $data);
    }

    public function asignarUsuario($params)
    {

        if (empty($_SESSION['permisosMod']['r']) && empty($ids)) {
            header("Location:" . base_url() . '/dashboard');
            exit;
        }
        $arrParams = explode(",", $params);
        $id_aula = intval($arrParams[0]);
        $id_grado = intval($arrParams[1]);
        $id_curso = intval($arrParams[2]);
        $data['Aula'] = $this->model->getAula($id_aula);
        $data['Curso'] = $this->model->getCurso($id_curso);
        $data['Grado'] = $this->model->getGrado($id_grado);
        $data['page_id'] = 7;
        $data['page_tag'] = "Asignar - Colegio unimat";
        $data['page_title'] = "Asignar - Colegio Unimat";
        $data['page_name'] = "Asignación";
        $data['page_functions_js'] = "functions_asignacion.js";
        $data['Periodo'] = $this->model->getPeriodo(PERIODO);
        $this->views->getView($this, "asignacionUsuario", $data);
    }

    public function getAsignaciones($params)
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrParams = explode(",", $params);
            $intIdAula = intval(strClean($arrParams[0]));
            $intIdGrado = intval(strClean($arrParams[1]));
            $intIdCurso = intval(strClean($arrParams[2]));


            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $arrData = $this->model->selectAsignaciones($intIdAula, $intIdGrado, $intIdCurso, PERIODO);

            for ($i = 0; $i < count($arrData); $i++) {

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['u']) {
                    $btnView = '<button class="btn btn-secondary btn-sm " onClick="fntViewAsignacion(' . $arrData[$i]['id_asignacion'] . ')" title="Permisos"><i class="bi bi-eye-fill"></i></button>';
                    $btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditAsignacion(' . $arrData[$i]['id_asignacion'] . ')" title="Editar"><i class="bi bi-pencil"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelAsignacion(' . $arrData[$i]['id_asignacion'] . ')" title="Eliminar"><i class="bi bi-trash3"></i></button>
					</div>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getAsignacion(int $idAsignacion)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdAsignacion = intval(strClean($idAsignacion));
            if ($intIdAsignacion > 0) {
                $arrData = $this->model->selectAsignacion($intIdAsignacion);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function setAsignacion($params)
    {
        $intIdAsignacion = intval($_POST['idAsignacion']);
        $intIdPeriodo = PERIODO;
        $arrParams = explode(",", $params);
        $intIdAula = intval(strClean($arrParams[0]));
        $intIdGrado = intval(strClean($arrParams[1]));
        $intIdCurso = intval(strClean($arrParams[2]));
        $intIdUsuario = intval($_POST['listaUsuarios']);      
       
        $intStatus = intval($_POST['listStatus']);
        $request_curso = "";

        if ($intIdAsignacion == 0) {
            //Crear
            if ($_SESSION['permisosMod']['w']) {
                $request_asignacion = $this->model->insertAsignacion($intIdUsuario, $intIdCurso, $intIdGrado, $intIdAula, $intIdPeriodo, $intStatus);
                $option = 1;
            }
        } else {
            //Actualizar
            if ($_SESSION['permisosMod']['u']) {
                $request_asignacion = $this->model->updateAsignacion($intIdAsignacion, $intIdUsuario, $intIdCurso, $intIdGrado, $intIdAula, $intIdPeriodo, $intStatus);
                $option = 2;
            }
        }

        if (intval($request_asignacion) > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
            }
        } else if ($request_curso == 'exist') {

            $arrResponse = array('status' => false, 'msg' => '¡Atención! la asignacion ya existe ya existe.');
        } else {
            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function viewAsignacion(int $idAsignacion)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdAsignacion = intval(strClean($idAsignacion));
            if ($intIdAsignacion > 0) {
                $arrData = $this->model->viewAsignacion($intIdAsignacion);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delAsignacion()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdAsignacion = intval($_POST['idAsignacion']);
                $requestDelete = $this->model->deleteAsignacion($intIdAsignacion);
                if ($requestDelete == 'ok') {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la asignación');
                } else if ($requestDelete == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar la asignación.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la asignación.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getUsuarios(){
        if ($_SESSION['permisosMod']['r']) {
                $search = isset($_GET['q']) ? strClean($_GET['q']) : null;
                $arrData = $this->model->obtenerUsuarios(intval(RDOCENTE),intval(RALUMNOS), $search);
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
