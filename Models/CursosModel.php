<?php 

	class CursosModel extends Mysql
	{
		public $intIdCurso;
		public $strCurso;
		public $strDescripcion;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectCursos()
		{
			// $whereAdmin = "";
			// if($_SESSION['idUser'] != 1 ){
			// 	$whereAdmin = " and idCurso != 1 ";
			// }
			//EXTRAE cursoES
			$sql = "SELECT * FROM curso WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectCurso(int $idCurso)
		{
			//BUSCAR cursoE
			$this->intIdCurso = $idCurso;
			$sql = "SELECT * FROM curso WHERE id_curso = $this->intIdCurso";
			$request = $this->select($sql);
			return $request;
		}

		public function insertcurso(string $curso, string $descripcion, int $status){

			$return = "";
			$this->strCurso = $curso;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM curso WHERE nombre = '{$this->strCurso}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO curso(nombre,descripcion,status) VALUES(?,?,?)";
	        	$arrData = array($this->strCurso, $this->strDescripcion, $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updatecurso(int $idCurso, string $curso, string $descripcion, int $status){
			$this->intIdCurso = $idCurso;
			$this->strCurso = $curso;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM curso WHERE nombre = '$this->strCurso' AND id_curso != $this->intIdCurso";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE curso SET nombre = ?, descripcion = ?, status = ? WHERE id_curso = $this->intIdCurso ";
				$arrData = array($this->strCurso, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deletecurso(int $idCurso)
		{
			$this->intIdCurso = $idCurso;
			// $sql = "SELECT * FROM persona WHERE cursoid = $this->intIdCurso";
			// $request = $this->select_all($sql);
			// if(empty($request))
			// {
				$sql = "UPDATE curso SET status = ? WHERE id_curso = $this->intIdCurso ";
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
	}
 ?>