<?php 

	class QrcontrollerModel extends Mysql
	{
		private $id_usuario;

		public function __construct()
		{
			parent::__construct();
		}

        public function searchName(int $id){
            $this->id_usuario=$id;
            $sql="SELECT u.nombres as nombres, r.nombre as nombrerol FROM usuario u JOIN rol r ON u.id_rol=r.id_rol WHERE id_usuario='{$this->id_usuario}'";
            $request=$this->select($sql);
            return $request;
        }

        public function searchNames(array $roles){
            // Escapar y construir la lista de roles para la consulta SQL
            $rolesList = implode("','", array_map([$this, 'escapeString'], $roles));
            
            $sql = "SELECT u.id_usuario, u.nombres as nombres, r.nombre as nombrerol 
                    FROM usuario u 
                    JOIN rol r ON u.id_rol = r.id_rol 
                    WHERE r.id_rol IN ('{$rolesList}') AND u.status=1";
            
            $request = $this->select_all($sql);
            return $request;
        }
        
        // Función de escape para evitar inyección SQL
        private function escapeString($str) {
            return addslashes($str);
        }
        
    }

    ?>