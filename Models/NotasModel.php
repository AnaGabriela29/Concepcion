<?php 
class NotasModel extends Mysql{

    private $intIdUsuario;
    private $intIdRol;
    private $intIdCurso;
    private $intIdGrado;
    private $intIdAula;
    private $arrNotas;
    private $intIdDocente;
    private $intIdAlumno;
    private $intIdPeriodo;
    private $intIdNota;
    private $intNota1;
    private $intNota2;
    private $intNota3;
    private $intNota4;
    private $intStatus;
    private $intIdAsignacion;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsignaciones(int $idUser){
        $this->intIdUsuario=$idUser;       
        $request="";
        $sql="SELECT ul.id_aula, ul.nombre AS nombre_aula, c.id_curso, c.nombre AS nombre_curso, g.id_grado, g.nombre AS nombre_grado
        FROM asignacion a 
        JOIN aula ul ON a.id_aula = ul.id_aula             
        JOIN curso c ON a.id_curso = c.id_curso 
        JOIN grado g ON a.id_grado=g.id_grado
        WHERE a.id_usuario='{$this->intIdUsuario}' AND a.status != 0";
        $request=$this->select_all($sql);
        return $request;
       
    }

    public function selectAlumnos($docente, $aula, $curso, $grado){
        $this->intIdUsuario=$docente;   
        $this->intIdCurso=$curso;
        $this->intIdGrado=$grado;
        $this->intIdAula=$aula;
       
        $response="";
        $sql="SELECT a.id_usuario FROM usuario u JOIN asignacion a ON u.id_usuario=a.id_usuario WHERE a.id_aula='{$this->intIdAula}' AND a.id_grado='{$this->intIdGrado}' AND a.id_curso='{$this->intIdCurso}' AND a.status!=0 AND a.id_usuario='{$this->intIdUsuario}'";       
        $request=$this->select_all($sql);

        if(!empty($request)){
            $sql="SELECT a.id_asignacion, CONCAT(u.nombres, ' ', u.apellidos) as nombres FROM asignacion a JOIN usuario u ON a.id_usuario=u.id_usuario WHERE a.id_aula='{$this->intIdAula}' AND a.id_grado='{$this->intIdGrado}' AND a.id_curso='{$this->intIdCurso}' AND a.status!=0 AND u.id_usuario!='{$this->intIdUsuario}'";          
            $response=$this->select_all($sql);
            
        }else{
            $response="Error ";
        }
        
        return $response;
    }
    public function insertarNotas(array $notas, int $docente, int $periodo){
        $this->intIdDocente=$docente;
        $this->arrNotas=$notas;
        
        $this->intIdPeriodo=$periodo;
        $nombreNota="";        
        $sql="SELECT * FROM estado_notas where id_estado_notas=1";
        $response=$this->select($sql);
    
        if(!empty($response)){
            foreach($response as $nNota=>$valor){
                if($valor==1){
                    $nombreNota=$nNota;
                }
            }
          
            if($nombreNota){
                // todas las notas existentes 
                $sql="SELECT * FROM nota WHERE id_docente='{$this->intIdDocente}' AND id_periodo='{$this->intIdPeriodo}'";
                
                $notasExistentes=$this->select_all($sql);
    
                foreach($this->arrNotas as $nota){
                    $idAsignacion = $nota['id_asignacion'];
                    $valorNota = $nota['nota'];
    
                    // Busca en las notas existentes 
                    $existeNota = array_search($idAsignacion, array_column($notasExistentes, 'id_asignacion'));
    
                    if($existeNota === false){
                        // Si no existe, inserta la nueva nota
                        $sql="INSERT INTO nota (id_asignacion, id_docente, $nombreNota, id_periodo, fecha, date_modificated) VALUES (?,?,?,?,NOW(),NOW())";
                        $arrData=array($idAsignacion, $this->intIdDocente, $valorNota,  $this->intIdPeriodo);
                        $request=$this->insert($sql, $arrData);
                    }else{
                        // Si existe, actualiza la nota existente
                        $sql="UPDATE nota SET $nombreNota=?, date_modificated=NOW() WHERE id_asignacion=? ";      
                        $arrData=array($valorNota, $idAsignacion);
                        $request=$this->update($sql, $arrData);
                    }
                }
                $response=$request;   
    
            }else{
                throw new Exception("El ingreso de notas está inhabilitado");
            }
            
        }else{
            throw new Exception("Ha ocurrido un error al obtener el estado de las notas");
        }
        return $response;       
    
    }

    // ===============================
    // Functions para los administradores 
    // ===============================
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

    public function selectNotas(int $aula, int $grado, int $curso, int $periodo ){
        $this->intIdAula = $aula;
        $this->intIdGrado = $grado;
        $this->intIdCurso = $curso;
        $this->intIdPeriodo = $periodo;
        
        $sql = "SELECT n.id_nota,u.identificacion, u.nombres, u.apellidos, n.nota_1, n.nota_2, n.nota_3, n.nota_4, n.status 
                FROM nota n 
                JOIN asignacion a ON n.id_asignacion=a.id_asignacion
                JOIN usuario u ON a.id_usuario= u.id_usuario
                WHERE a.id_aula = '{$this->intIdAula}' AND a.id_curso = '{$this->intIdCurso}' AND a.id_grado = '{$this->intIdGrado}' AND n.status != 0";
                
        $request = $this->select_all($sql);
    
        return $request;
    }

    public function insertNota(int $asignacion, int $docente, int $nota1=null, int $nota2=null, int $nota3=null, int $nota4=null, int $status, int $periodo){
        $this->intIdDocente=$docente;
        $this->intIdAsignacion=$asignacion;
        $this->intNota1=$nota1;
        $this->intNota2=$nota2;
        $this->intNota3=$nota3;
        $this->intNota4=$nota4;
        $this->intStatus=$status;
        $this->intIdPeriodo=$periodo;
        //buscamos si existe un registro existente
        $sql = "SELECT n.id_nota FROM nota n WHERE n.id_docente = '{$this->intIdDocente}' AND n.id_asignacion = '{$this->intIdAsignacion}' AND n.status!=0 ";
        $request = $this->select_all($sql);

        if(empty($request))
        {   //registramos una nota modo administrador
            $query_insert  = "INSERT INTO nota(id_asignacion,id_docente, nota_1, nota_2, nota_3, nota_4, id_periodo, fecha, date_modificated,status) VALUES(?,?,?,?,?,?,?,NOW(),NOW(),?)";
            $arrData = array($this->intIdAsignacion, $this->intIdDocente, $this->intNota1, $this->intNota2, $this->intNota3, $this->intNota4, $this->intStatus, $this->intIdPeriodo);
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = "exist";
        }
        return $return;
    }

    public function obtenerNota(int $idNota){
        $this->intIdNota = $idNota;
        $sql = "SELECT n.id_nota, n.nota_1, n.nota_2, n.nota_3, n.nota_4, n.status FROM nota n WHERE n.id_nota='{$this->intIdNota}' ";
				$arrData = array(0);
				$request = $this->select($sql,$arrData);			
		return $request;
    }

    public function obtenerNotaAlumno(int $idNota){
        $this->intIdNota = $idNota;
        $sql = "SELECT 
                    n.id_nota, n.nota_1, n.nota_2, n.nota_3, n.nota_4, n.status,
                    CONCAT(n.fecha, ' - ', n.date_modificated) AS fecha, 
                    CONCAT(u.nombres, ' ', u.apellidos) AS nombres_docente, 
                    CONCAT(alumno.nombres, ' ', alumno.apellidos) AS nombres_alumno, 
                    periodo.nombre AS nombre_periodo
                FROM 
                    nota n
                    INNER JOIN usuario u ON n.id_docente = u.id_usuario
                    INNER JOIN asignacion a ON n.id_asignacion = a.id_asignacion
                    INNER JOIN usuario alumno ON a.id_usuario = alumno.id_usuario
                    INNER JOIN periodo ON n.id_periodo = periodo.id_periodo            
                WHERE n.id_nota ='{$this->intIdNota}'";
        $arrData = array(0);
        $request = $this->select($sql, $arrData);          
        return $request;
    }
    

    public function updateNota(int $idNota, int $nota1=null, int $nota2=null, int $nota3=null, int $nota4=null, int $status){
        $this->intIdNota = $idNota;
        $this->intNota1=$nota1;
        $this->intNota2=$nota2;
        $this->intNota3=$nota3;
        $this->intNota4=$nota4;
        $this->intStatus=$status;
        $sql = "UPDATE nota SET nota_1=?, nota_2=?, nota_3=?, nota_4=?, date_modificated=NOW() , status=?  WHERE id_nota='{$this->intIdNota}' ";
				$arrData = array($this->intNota1, $this->intNota2, $this->intNota3, $this->intNota4, $this->intStatus);
				$request = $this->update($sql,$arrData);			
		return $request;
        
    }

    public function deleteNota(int $idNota)
		{
			$this->intIdNota = $idNota;
		
				$sql = "UPDATE nota SET status = ? WHERE id_nota = $this->intIdNota ";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			
			return $request;
		}

        public function obtenerDocente(int $idAula, int $idGrado, int $idCurso, string $search=null, int $docente){
            
            $this->intIdCurso=$idCurso;
            $this->intIdGrado=$idGrado;
            $this->intIdAula=$idAula;
            $this->intIdDocente=$docente;

            $response="";
			$sql="SELECT u.id_usuario, CONCAT(u.nombres,' ', u.apellidos) as nombres FROM usuario u JOIN asignacion a ON u.id_usuario=a.id_usuario WHERE a.id_curso='{$this->intIdCurso}' AND a.id_grado='{$this->intIdGrado}' AND a.id_aula='{$this->intIdAula}' AND u.id_rol='{$this->intIdDocente}'";
			if (!empty($search)) {
				$sql .= " AND (u.nombres LIKE '%{$search}%' OR u.apellidos LIKE '%{$search}%')";
			}			
			$response=$this->select_all($sql);		
			return $response;
    }    

    public function obtenerAlumnos(int $idAula, int $idGrado, int $idCurso, string $search=null, int $alumno){
            
            $this->intIdCurso=$idCurso;
            $this->intIdGrado=$idGrado;
            $this->intIdAula=$idAula;
            $this->intIdAlumno=$alumno;

            $response="";
			$sql="SELECT a.id_asignacion, CONCAT(u.nombres,' ', u.apellidos) as nombres FROM usuario u JOIN asignacion a ON u.id_usuario=a.id_usuario WHERE a.id_curso='{$this->intIdCurso}' AND a.id_grado='{$this->intIdGrado}' AND a.id_aula='{$this->intIdAula}' AND u.id_rol='{$this->intIdAlumno}'";
			if (!empty($search)) {
				$sql .= " AND (u.nombres LIKE '%{$search}%' OR u.apellidos LIKE '%{$search}%')";
			}			
			$response=$this->select_all($sql);		
			return $response;
    }
    
    

}
?>