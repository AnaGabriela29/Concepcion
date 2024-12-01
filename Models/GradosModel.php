<?php 

	class GradosModel extends Mysql
	{
		public $intIdGrado;
		public $strGrado;
		public $strDescripcion;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectGrados()
		{
			// $whereAdmin = "";
			// if($_SESSION['idUser'] != 1 ){
			// 	$whereAdmin = " and idgrado != 1 ";
			// }
			//EXTRAE ROLES
			$sql = "SELECT * FROM grado WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectGrado(int $idgrado)
		{
			//BUSCAR Grado
			$this->intIdGrado = $idgrado;
			$sql = "SELECT * FROM grado WHERE id_grado = $this->intIdGrado";
			$request = $this->select($sql);
			return $request;
		}

		public function insertGrado(string $grado, string $descripcion, int $status){

			$return = "";
			$this->strGrado = $grado;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM grado WHERE nombre = '{$this->strGrado}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO grado(nombre,descripcion,status) VALUES(?,?,?)";
	        	$arrData = array($this->strGrado, $this->strDescripcion, $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateGrado(int $idgrado, string $grado, string $descripcion, int $status){
			$this->intIdGrado = $idgrado;
			$this->strGrado = $grado;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM grado WHERE nombre = '$this->strGrado' AND id_grado != $this->intIdGrado";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE grado SET nombre = ?, descripcion = ?, status = ? WHERE id_grado = $this->intIdGrado ";
				$arrData = array($this->strGrado, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteGrado(int $idgrado)
		{
			$this->intIdGrado = $idgrado;
			// $sql = "SELECT * FROM persona WHERE gradoid = $this->intIdGrado";
			// $request = $this->select_all($sql);
			// if(empty($request))
			// {
				$sql = "UPDATE grado SET status = ? WHERE id_grado = $this->intIdGrado ";
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