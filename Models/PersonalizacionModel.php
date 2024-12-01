<?php 

	class PersonalizacionModel extends Mysql
	{

		public function __construct()
		{
			parent::__construct();
		}

        public function selectNews(){
            $sql="SELECT * FROM post ";
            $request=$this->select_all($sql);
            return $request;
        }

        public function selectSliders(){
            $sql="SELECT * FROM slider ";
            $request=$this->select_all($sql);
            echo $request;
            return $request;
        }
    }

?>