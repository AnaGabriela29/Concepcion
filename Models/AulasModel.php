<?php 

	class AulasModel extends Mysql
	{
		public $intIdAula;
		public $strAula;
		public $strDescripcion;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectAulas()
		{
			// $whereAdmin = "";
			// if($_SESSION['idUser'] != 1 ){
			// 	$whereAdmin = " and idaula != 1 ";
			// }
			//EXTRAE ROLES
			$sql = "SELECT * FROM aula WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectAula(int $idaula)
		{
			//BUSCAR ROLE
			$this->intIdAula = $idaula;
			$sql = "SELECT * FROM aula WHERE id_aula = $this->intIdAula";
			$request = $this->select($sql);
			return $request;
		}

		public function insertAula(string $aula, string $descripcion, int $status){

			$return = "";
			$this->strAula = $aula;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM aula WHERE nombre = '{$this->strAula}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO aula(nombre,descripcion,status) VALUES(?,?,?)";
	        	$arrData = array($this->strAula, $this->strDescripcion, $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}	

		public function updateAula(int $idaula, string $aula, string $descripcion, int $status){
			$this->intIdAula = $idaula;
			$this->strAula = $aula;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM aula WHERE nombre = '$this->strAula' AND id_aula != $this->intIdAula";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE aula SET nombre = ?, descripcion = ?, status = ? WHERE id_aula = $this->intIdAula ";
				$arrData = array($this->strAula, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteAula(int $idaula)
		{
			$this->intIdAula = $idaula;
			// $sql = "SELECT * FROM persona WHERE aulaid = $this->intIdAula";
			// $request = $this->select_all($sql);
			// if(empty($request))
			// {
				$sql = "UPDATE aula SET status = ? WHERE id_aula = $this->intIdAula ";
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