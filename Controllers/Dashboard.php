<?php

class Dashboard extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		// session_regenerate_id(true);
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MDASHBOARD);
	}

	public function dashboard()
	{
		$data['page_id'] = 2;
		$data['page_tag'] = "Dashboard - Colegio unimat";
		$data['page_title'] = "Dashboard - Colegio Unimat";
		$data['page_name'] = "dashboard";
		$data['page_functions_js'] = "functions_dashboard.js";
		if ($_SESSION['userData']['id_rol'] == RALUMNOS) {
			$this->views->getView($this, "dashboardAlumno", $data);
		}else if($_SESSION['userData']['id_rol'] == RDOCENTE){
			$this->views->getView($this, "dashboardDocente", $data);
		} else {
			$data['Usuarios'] = $this->cantidadUsuarios();
			$data['Alumnos'] = $this->cantidadAlumnos();
			$data['Cursos'] = $this->cantidadCursos();
			$data['Grados'] = $this->cantidadGrados();
			$data['Aulas'] = $this->cantidadAulas();

			$this->views->getView($this, "dashboard", $data);
		}
	}

	public function cantidadUsuarios()
	{
		$arrData = $this->model->selectCantidadUsuarios();
		return $arrData;
	}

	public function cantidadAlumnos()
	{
		$arrData = $this->model->selectCantidadAlumnos();
		return $arrData;
	}
	public function cantidadCursos()
	{
		$arrData = $this->model->selectCantidadCursos();
		return $arrData;
	}
	public function cantidadGrados()
	{
		$arrData = $this->model->selectCantidadGrados();
		return $arrData;
	}

	public function cantidadAulas()
	{
		$arrData = $this->model->selectCantidadAulas();
		return $arrData;
	}

	public function getAsistencias(){
		
		if($_SESSION['permisosMod']['r']){			
		$arrData=$this->model->selectAsistencias($_SESSION['idUser']);		
		if(!empty($arrData)){
			$arrResponse= array('status' => true, 'data' => $arrData);  				
		}else{
			$arrResponse= array('status' => false, 'msg' => 'Asistencias no encontradas');  
		}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function getNotas(){
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectNotas($_SESSION['idUser']);
			$html = "";
			if(!empty($arrData)){
				for ($i = 0; $i < count($arrData); $i++) {
					$promedio = ($arrData[$i]['nota_1'] + $arrData[$i]['nota_2'] + $arrData[$i]['nota_3'] + $arrData[$i]['nota_4']) / 4;
					$html .= '<tr>
								<th>' . $arrData[$i]['nombre'] . '</th>
								<td>' . $arrData[$i]['nota_1'] . '</td>
								<td>' . $arrData[$i]['nota_2'] . '</td>
								<td>' . $arrData[$i]['nota_3'] . '</td>
								<td>' . $arrData[$i]['nota_4'] . '</td>
								<td>' . $promedio . '</td>
							  </tr>';
				}
				$arrResponse = array('status' => true, 'html' => $html);  				
			} else {
				$arrResponse = array('status' => false, 'msg' => 'Notas no encontradas');  
			}			
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	public function getPagos(){
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectPagos($_SESSION['idUser']);
			$html = "";
			
			// Definir el arreglo de meses
			$months = [
				0 => '', 1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
				7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
			];
	
			if(!empty($arrData)){
				for ($i = 0; $i < count($arrData); $i++) {
					// Convertir el número del mes al nombre del mes
					$mes = $months[intval($arrData[$i]['mes'])];
					
					$html .= '<tr>
								<th>' . $arrData[$i]['nombre_concepto'] . '</th>
								<td>' . $arrData[$i]['fecha_pago'] . '</td>
								<td>' . $arrData[$i]['monto_pagado'] . '</td>
								<td>' . $arrData[$i]['observaciones'] . '</td>
								<td>' . $mes . '</td>                                
							  </tr>';
				}
				$arrResponse = array('status' => true, 'html' => $html);  				
			} else {
				$arrResponse = array('status' => false, 'msg' => 'Pagos no encontrados');  
			}			
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	
	
	public function asistenciaDiaria(){
		if($_SESSION['permisosMod']['r']){
		$arrData=$this->model->selectAsistenciasDiarias(RDOCENTE);
		
		if(!empty($arrData)){			
			$arrResponse= array('status' => true, 'data' => $arrData);  				
		}else{
			$arrResponse= array('status' => false, 'msg' => 'Asistencias no encontradas');  
			}			
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		
		die();
	}
	public function pagosMensual(){
		if($_SESSION['permisosMod']['r']){
		$arrData=$this->model->selectPagosMensual();
		
		if(!empty($arrData)){			
			$arrResponse= array('status' => true, 'data' => $arrData);  				
		}else{
			$arrResponse= array('status' => false, 'msg' => 'Pagos no encontrados');  
			}			
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		
		die();
	}
}
