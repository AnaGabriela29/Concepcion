<?php 

	class AsignacionModel extends Mysql
	{
		public $intIdAsignacion;
        public $intIdUsuario;
        public $intIdCurso;
        public $intIdGrado;
        public $intIdPeriodo;
        public $intIdAula;
        public $intStatus;
		public $intRolDocente;
		public $intRolAlumno;

		public function __construct()
		{
			parent::__construct();
		}

        public function cantidadAulas(){
            $sql = "SELECT id_aula, nombre FROM aula
            WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
        }
        public function cantidadCursos(){
            $sql = "SELECT id_curso, nombre FROM curso
            WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
        }
        public function cantidadGrados(){
            $sql = "SELECT id_grado, nombre FROM grado
            WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
        }

        public function getPeriodo(int $periodo){
            $this->intIdPeriodo=$periodo;
            $sql = "SELECT * FROM periodo
            WHERE id_periodo='{$this->intIdPeriodo}'";
			$request = $this->select($sql);
			return $request;
        }

        public function getAula(int $aula){
            $this->intIdAula=$aula;
            $sql = "SELECT id_aula,nombre FROM aula
            WHERE id_aula='{$this->intIdAula}'";
			$request = $this->select($sql);
			return $request;
        }

        public function getCurso(int $curso){
            $this->intIdCurso=$curso;
            $sql = "SELECT id_curso, nombre FROM curso
            WHERE id_curso='{$this->intIdCurso}'";
			$request = $this->select($sql);
			return $request;
        }

        public function getGrado(int $grado){
            $this->intIdGrado=$grado;
            $sql = "SELECT id_grado,nombre FROM grado
            WHERE id_grado='{$this->intIdGrado}'";
			$request = $this->select($sql);
			return $request;
        }

        public function selectAsignaciones($aula, $grado, $curso, $periodo)
		{
			$this->intIdAula=$aula;
            $this->intIdCurso=$curso;
            $this->intIdGrado=$grado;
            $this->intIdPeriodo=$periodo;
			//EXTRAE asignaciones
			$sql = "SELECT a.id_asignacion,r.nombre AS nombre_rol, u.nombres AS nombres_usuario, u.identificacion, u.apellidos AS apellidos_usuario, a.status
            FROM asignacion a 
            JOIN usuario u ON a.id_usuario = u.id_usuario             
            JOIN periodo p ON a.id_periodo = p.id_periodo 
            JOIN rol r ON u.id_rol=r.id_rol
            WHERE a.status != 0 AND a.id_periodo='{$this->intIdPeriodo}' AND a.id_aula='{$this->intIdAula}' AND a.id_grado='{$this->intIdGrado}' AND a.id_curso='{$this->intIdCurso}' ";
		
			$request = $this->select_all($sql);
			return $request;
		}

        public function selectAsignacion(int $asignacion)
		{
			$this->intIdAsignacion=$asignacion;
			$sql="SELECT a.id_asignacion,u.id_usuario, u.identificacion, u.nombres AS nombres_usuario, u.apellidos AS apellidos_usuario, a.id_curso,c.nombre AS nombre_curso, a.id_grado, g.nombre AS nombre_grado,  a.status
            FROM asignacion a 
            JOIN usuario u ON a.id_usuario = u.id_usuario 
            JOIN curso c ON a.id_curso = c.id_curso 
            JOIN grado g ON a.id_grado = g.id_grado             
            JOIN periodo p ON a.id_periodo = p.id_periodo 
            JOIN rol r ON u.id_rol=r.id_rol
            WHERE a.status != 0 AND id_asignacion=$this->intIdAsignacion";
			$request=$this->select($sql);
			return $request;
		}

        public function insertAsignacion(int $usuario,int $curso, int $grado, int $aula, int $periodo, int $status){

			$return = "";
			$this->intIdCurso = $curso;
			$this->intIdAula = $aula;
			$this->intIdGrado = $grado;
			$this->intIdUsuario = $usuario;
            $this->intIdPeriodo = $periodo;
			$this->intStatus = $status;

			$sql = "SELECT * FROM asignacion WHERE id_curso='{$this->intIdCurso}' AND id_aula='{$this->intIdAula}' AND id_grado='{$this->intIdGrado}' AND id_usuario='{$this->intIdUsuario}' AND id_periodo='{$this->intIdPeriodo}' ";
			$request = $this->select($sql);
			if(empty($request))
			{
				$query_insert  = "INSERT INTO asignacion(id_usuario,id_curso,id_grado, id_aula, id_periodo,status) VALUES(?,?,?,?,?, ?)";
	        	$arrData = array($this->intIdUsuario,$this->intIdCurso, $this->intIdGrado, $this->intIdAula,  $this->intIdPeriodo, $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

        public function updateAsignacion(int $asignacion, int $usuario,int $curso, int $grado, int $aula, int $periodo, int $status){
			$return = "";
			$this->intIdAsignacion = $asignacion;
			$this->intIdCurso = $curso;
			$this->intIdAula = $aula;
			$this->intIdGrado = $grado;
			$this->intIdUsuario = $usuario;
            $this->intIdPeriodo = $periodo;
			$this->intStatus = $status;
			// obtenemos la fecha actual
			$fechaActual = date('Y-m-d H:i:s');
			echo $fechaActual;

			$sql = "SELECT * FROM asignacion WHERE id_aula = '{$this->intIdAula}' AND id_curso='{$this->intIdCurso}' AND id_aula='{$this->intIdAula}' AND id_grado='{$this->intIdGrado}' AND id_usuario='{$this->intIdUsuario}' AND id_asignacion!='{$this->intIdAsignacion}' AND id_periodo='{$this->intIdPeriodo}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE asignacion SET id_usuario = ?, id_curso = ?, id_grado = ? , id_aula=?, date_modificated=?, status=? WHERE id_asignacion = $this->intIdAsignacion ";
				$arrData = array($this->intIdUsuario, $this->intIdCurso, $this->intIdGrado, $this->intIdAula, $fechaActual, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			
		    return $request;			
		}

        public function viewAsignacion(int $asignacion)
		{
			$this->intIdAsignacion=$asignacion;
			$sql="SELECT r.nombre AS nombre_rol, u.nombres AS nombres_usuario, u.apellidos AS apellidos_usuario, c.nombre AS nombre_curso, g.nombre AS nombre_grado, al.nombre AS nombre_aula, a.status, p.nombre AS nombre_periodo, DATE(a.date_created) AS date_created, DATE(a.date_modificated) AS date_modificated
            FROM asignacion a 
            JOIN usuario u ON a.id_usuario = u.id_usuario 
            JOIN curso c ON a.id_curso = c.id_curso 
            JOIN grado g ON a.id_grado = g.id_grado 
            JOIN aula al ON a.id_aula = al.id_aula 
            JOIN periodo p ON a.id_periodo = p.id_periodo 
            JOIN rol r ON u.id_rol=r.id_rol
            WHERE a.status != 0 AND id_asignacion=$this->intIdAsignacion";
			$request=$this->select($sql);
			return $request;
		}

        public function deleteAsignacion(int $asignacion)
		{
			$this->intIdAsignacion = $asignacion;
			// $sql = "SELECT * FROM persona WHERE cursoid = $this->intIdCurso";
			// $request = $this->select_all($sql);
			// if(empty($request))
			// {
				$sql = "UPDATE asignacion SET status = ? WHERE id_asignacion = $this->intIdAsignacion ";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			// }else{
				// $request = 'exist';
			// }
			return $request;
		}

		public function obtenerUsuarios(int $docentes, int $alumnos, string $search=null){
			$this->intRolAlumno=$alumnos;
			$this->intRolDocente=$docentes;
			$response="";
			$sql="SELECT id_usuario, CONCAT(identificacion, '   ', nombres, ' - ', apellidos) as nombres FROM usuario WHERE (id_rol='{$this->intRolDocente}' OR id_rol='{$this->intRolAlumno}')";
			if (!empty($search)) {
				$sql .= " AND (identificacion LIKE '%{$search}%' OR nombres LIKE '%{$search}%' OR apellidos LIKE '%{$search}%')";
			}			
			$response=$this->select_all($sql);		
			return $response;
		}
		
    
    }