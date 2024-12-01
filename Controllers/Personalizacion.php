<?php 

	class Personalizacion extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MPERSONALIZACION);
		}

		public function Personalizacion()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 11;
			$data['page_tag'] = "Personlizacion de home";
			$data['page_name'] = "personalizacion";
			$data['page_title'] = "Unimat<small> personalización</small>";
			$data['page_functions_js'] = "functions_personalizacion.js";
			$this->views->getView($this,"Personalizacion",$data);
		}

        // ======================================
        //  noticias
        // =======================================
        public function getNews(){
            if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectNews();

				for ($i=0; $i < count($arrData); $i++) {
					
					if($_SESSION['permisosMod']['u']){
						$btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewPost('.$arrData[$i]['id_post'].')" title="Permisos"><i class="bi bi-key"></i></button>';
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditPost('.$arrData[$i]['id_post'].')" title="Editar"><i class="bi bi-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelPost('.$arrData[$i]['id_post'].')" title="Eliminar"><i class="bi bi-trash3"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
        }


		// ======================================
        //  sliders
        // =======================================
        public function getSliders(){
            if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectSliders();

				for ($i=0; $i < count($arrData); $i++) {
					
					if($_SESSION['permisosMod']['u']){
						$btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewSlider('.$arrData[$i]['id_slider'].')" title="Permisos"><i class="bi bi-key"></i></button>';
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditSlider('.$arrData[$i]['id_slider'].')" title="Editar"><i class="bi bi-pencil"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelSlider('.$arrData[$i]['id_slider'].')" title="Eliminar"><i class="bi bi-trash3"></i></button>
					</div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
        }
    }
?>