<?php 

	class ControlasistenciaModel extends Mysql
	{
		private $intIdAsistencia;
		private $strDNI;
		private $strObservaciones;
		private $strFechaHora;
		private $strEstado;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectAsistencias()
		{
			
			$sql = "SELECT a.id_asistencia, u.identificacion, a.fecha_hora, a.estado_asistencia, a.observaciones FROM asistencia a INNER JOIN usuario u ON a.id_usuario=u.id_usuario";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectAsistencia(int $idasistencia)
		{
			//BUSCAR 
			$this->intIdAsistencia = $idasistencia;
			$sql = "SELECT a.id_asistencia,u.identificacion,  a.fecha_hora, a.observaciones, CONCAT(u.nombres, ' ' , u.apellidos) AS nombre, a.estado_asistencia  FROM 	asistencia a
					INNER JOIN usuario u ON a.id_usuario=u.id_usuario
					WHERE id_asistencia = $this->intIdAsistencia";
			$request = $this->select($sql);
			return $request;
		}

		public function insertAsistencia(string $identificacion, DateTime $fecha, string $observaciones, string $estado){

			$return = "";
			$this->strDNI = $identificacion;
			$this->strFechaHora= $fecha;
			$this->strObservaciones = $observaciones;
			$this->strEstado=$estado;

			// Extrae solo la fecha para la comparación
            $fechaSolo = $this->strFechaHora->format('Y-m-d');

			$sql="SELECT  id_usuario FROM usuario WHERE identificacion='{$this->strDNI}'";
			$idUsuario=$this->select($sql);
			if(empty($idUsuario)){
				return "error";
			}
			$idUsuario=$idUsuario['id_usuario'];
        
            $sql = "SELECT id_asistencia FROM asistencia WHERE 
                    id_usuario = '{$idUsuario}' AND DATE(fecha_hora) = '{$fechaSolo}' ";
            $request = $this->select($sql);

			if(empty($request))
            {
                $query_insert  = "INSERT INTO asistencia(id_usuario, fecha_hora, observaciones, estado_asistencia) 
                                  VALUES(?,?,?,?)";
                $arrData = array($idUsuario,
                                $this->strFechaHora->format('Y-m-d H:i:s'),
                                $this->strObservaciones,
								$this->strEstado
                                );
                $request_insert = $this->insert($query_insert,$arrData);
                if(!empty($request_insert)){
                    $return = "ok";
                }else{
                    $return="error"; 
                }    
            }else{
                $return="exist";
            }
            return $return;
            
		}	

		public function updateAsistencia(int $idasistencia, string $dni, DateTime $fecha, string $observaciones, string $estado){
			$this->intIdAsistencia = $idasistencia;
			$this->strDNI = $dni;
			$this->strFechaHora = $fecha;
			$this->strObservaciones= $observaciones;
			$this->strEstado=$estado;

			// Extrae solo la fecha para la comparación
            $fechaSolo = $this->strFechaHora->format('Y-m-d');

			$sql="SELECT  id_usuario FROM usuario WHERE identificacion='{$this->strDNI}'";
			$idUsuario=$this->select($sql);
			if(empty($idUsuario)){
				return "error";
			}
			$idUsuario=$idUsuario['id_usuario'];        
            $sql = "SELECT id_asistencia FROM asistencia WHERE 
                    id_usuario = '{$idUsuario}' AND DATE(fecha_hora) = '{$fechaSolo}' AND id_asistencia!='{$this->intIdAsistencia}' ";
            $request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE asistencia SET id_usuario = ?, fecha_hora = ?, observaciones = ?, estado_asistencia= ? WHERE id_asistencia = $this->intIdAsistencia ";
				$arrData = array($idUsuario, $this->strFechaHora->format('Y-m-d H:i:s'), $this->strObservaciones, $this->strEstado);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteAsistencia(int $idasistencia)
		{
			$this->intIdAsistencia = $idasistencia;
			
				$sql = "DELETE FROM asistencia WHERE id_asistencia = $this->intIdAsistencia ";
				$arrData = array(0);
				$request = $this->delete($sql,$arrData);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			
			return $request;
		}
	}
 ?>