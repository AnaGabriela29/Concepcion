<?php 
	
	class Colegio extends Controllers{
		
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function home(){
			// $pageContent = getPageRout('inicio');
			$data['page_num']=1;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "colegio unimat";			
			$this->views->getView($this,"home",$data);
		}

        public function colaboradores()
		{
			// $pageContent = getPageRout('inicio');
			$data['page_num']=2;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "colegio unimat";
			
			$this->views->getView($this,"colaboradores",$data); 
		}

		public function noticias()
		{
			// $pageContent = getPageRout('inicio');
			$data['page_num']=3;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "colegio unimat";
			
			$this->views->getView($this,"noticias",$data); 
		}

        public function reglamento()
		{
			// $pageContent = getPageRout('inicio');
			$data['page_num']=3;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "colegio unimat";
			
			$this->views->getView($this,"reglamento",$data); 
		}
		public function propuesta()
		{
		
			// $pageContent = getPageRout('inicio');
			$data['page_num']=4;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "colegio unimat";

			$this->views->getView($this,"propuesta",$data); 
		}
		public function nosotros()
		{
			// $pageContent = getPageRout('inicio');
			$data['page_num']=5;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "colegio unimat";
			
			$this->views->getView($this,"nosotros",$data); 
		}
		public function contactanos()
		{
			// $pageContent = getPageRout('inicio');
			$data['page_num']=6;
			$data['page_tag'] = NOMBRE_EMPESA;
			$data['page_title'] = NOMBRE_EMPESA;
			$data['page_name'] = "colegio unimat";
			
			$this->views->getView($this,"contactanos",$data); 
		}
		
    }

?>