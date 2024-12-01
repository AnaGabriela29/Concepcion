<?php 
	
	class Home extends Controllers{
		
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function home()
		{
			// guardar informacion para saber si l dispositivo es mobil
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$data['page_num']=1;
			// $pageContent = getPageRout('inicio');
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "tienda_virtual";

			// Detectar si el dispositivo es móvil
			$data['is_mobile'] = $this->is_mobile($user_agent);
			// Servir la imagen correspondiente
			$data['image_path'] = $data['is_mobile'] ? "ruta/a/tu/imagen-movil.jpg" : "ruta/a/tu/imagen.jpg";
			
			$this->views->getView($this,"home",$data); 
		}	

		public function is_mobile($user_agent){
			return preg_match('/(iphone|ipod|ipad|android|blackberry|windows ce|palm|symbian)/i', $user_agent);
		}

	}
 ?>
