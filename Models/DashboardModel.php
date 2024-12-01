<?php 
	class DashboardModel extends Mysql
	{
		private $id_usuario;
		public function __construct()
		{
			parent::__construct();
		}

		public function selectCantidadUsuarios(){
			$sql = "SELECT COUNT(*) as total FROM usuario WHERE status != 0 AND id_rol!=".RALUMNOS;
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}
		public function selectCantidadAlumnos(){
			$sql = "SELECT COUNT(*) as total FROM usuario WHERE status != 0 AND id_rol = ".RALUMNOS;
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}
		public function selectCantidadCursos(){
			$sql = "SELECT COUNT(*) as total FROM curso WHERE status != 0 ";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}
		public function selectCantidadGrados(){
			$sql = "SELECT COUNT(*) as total FROM grado WHERE status != 0 ";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}
		public function selectCantidadAulas(){
			$sql = "SELECT COUNT(*) as total FROM aula WHERE status != 0 ";
			$request = $this->select($sql);
			$total = $request['total']; 
			return $total;
		}

		public function selectAsistencias(int $idUsuario) :array{
			$result=[];
			$this->id_usuario=$idUsuario;			
			$sql = "SELECT DATE_FORMAT(fecha_hora, '%Y-%m-%dT%H:%i:%s') as fecha, estado_asistencia as estado, observaciones 
			FROM asistencia 
			WHERE id_usuario='{$this->id_usuario}' ";
			$request = $this->select_all($sql);		
			if(empty($request)){
				$result=[];
			}else{
				$result=$request;
			}
			return $result;
		}

		public function selectNotas(int $idUsuario){
			$result=[];
			$this->id_usuario=$idUsuario;			
			
			$sql = "SELECT c.nombre, n.nota_1, n.nota_2, n.nota_3, n.nota_4 
			FROM nota n
			INNER JOIN asignacion ag ON n.id_asignacion=ag.id_asignacion 
			INNER JOIN curso c ON ag.id_curso=c.id_curso
			WHERE ag.id_usuario='{$this->id_usuario}' ";
			$request = $this->select_all($sql);		
			if(empty($request)){
				$result=[];
			}else{
				$result=$request;
			}
			return $result;
		}
		public function selectPagos(int $idUsuario){
			$result=[];
			$this->id_usuario=$idUsuario;			
			
			$sql = "SELECT cp.nombre_concepto, p.fecha_pago, p.monto_pagado, p.observaciones, p.mes 
			FROM pago p
			INNER JOIN concepto_pago cp ON p.id_concepto_pago=p.id_concepto_pago			
			WHERE p.id_usuario='{$this->id_usuario}' ";
			$request = $this->select_all($sql);		
			if(empty($request)){
				$result=[];
			}else{
				$result=$request;
			}
			return $result;
		}

		public function selectAsistenciasDiarias(int $intDocente) : array {
			$result = [];
		
			// Consulta para obtener total de asistencias del día actual
			$sqlAsistencias = "SELECT COUNT(id_usuario) AS total_asistencias 
							   FROM asistencia							  
							   WHERE DATE(fecha_hora) = CURDATE()";
			
			$requestAsistencias = $this->select_all($sqlAsistencias);
			$totalAsistencias = !empty($requestAsistencias) ? intval($requestAsistencias[0]['total_asistencias']) : 0;
		
			// Consulta para obtener total de alumnos y docente que ya ponemos como sqlalumnos
			$sqlAlumnos = "SELECT 
								(SELECT COUNT(id_estudiante) FROM estudiante WHERE matriculado=1 AND status=1)
								+
								(SELECT COUNT(id_usuario) FROM usuario WHERE id_rol=$intDocente AND status=1) AS total_personas
							";
			$requestAlumnos = $this->select_all($sqlAlumnos);
			$totalAlumnos = !empty($requestAlumnos) ? intval($requestAlumnos[0]['total_estudiantes']): 0;
		
			// Calcular la ausencias
			$totalInasistencias = $totalAlumnos-$totalAsistencias;
			
		
			// Preparar el resultado
			$result = [
				'total_asistencias' => $totalAsistencias,
				'total_estudiantes' => $totalAlumnos,
				'total_inasistencias' => $totalInasistencias,				
			];
		
			return $result;
		}

		public function selectPagosMensual() : array {
			$result = [];

			// Consulta para obtener total de pagos del mes actual
			$sqlPagos = "SELECT COUNT(id_usuario) AS total_pagos 
			FROM pago
			INNER JOIN concepto_pago ON pago.id_concepto_pago=concepto_pago.id_concepto_pago 
			WHERE MONTH(fecha_pago) = MONTH(CURDATE())
			AND YEAR(fecha_pago) = YEAR(CURDATE())
			AND concepto_pago.tipo_concepto = 'Mensualidad'";

			$requestPagos = $this->select_all($sqlPagos);
			$totalPagos = !empty($requestPagos) ? intval($requestPagos[0]['total_pagos']) : 0;
			// Consulta para obtener total de alumnos
			$sqlAlumnos = "SELECT COUNT(id_estudiante) AS total_estudiantes FROM estudiante WHERE matriculado=1 AND status=1";
			$requestAlumnos = $this->select_all($sqlAlumnos);
			$totalAlumnos = !empty($requestAlumnos) ? intval($requestAlumnos[0]['total_estudiantes']) : 0;

			// Calcular los no pagos
			$ToalNoPagos =$totalAlumnos- $totalPagos; 
			
			// Preparar el resultado
			$result = [
				'total_pagos' => $totalPagos,
				'total_estudiantes' => $totalAlumnos,
				'total_no_pagos' => $ToalNoPagos,
				
			];
		
			return $result;
		}
		
	}
	
?>