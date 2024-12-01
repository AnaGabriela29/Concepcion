<?php 
    class AsistenciaModel extends Mysql
    {
        private $idUsuario;
        private $identificacion;
        private $fechaActual;
        private $strEstado;
        public function __construct()
        {
            parent::__construct();
        }
        // insertar por id_usuario
        public function insertarAsistencia(string $idUsuario, DateTime $fecha, string $estado){
            $this->idUsuario = $idUsuario;
            $this->fechaActual = $fecha;
            $this->strEstado=$estado;
            // Extrae solo la fecha para la comparación
            $fechaSolo = $this->fechaActual->format('Y-m-d');
        
            $sql = "SELECT id_asistencia FROM asistencia WHERE 
                    id_usuario = '{$this->idUsuario}' AND DATE(fecha_hora) = '{$fechaSolo}' ";
            $request = $this->select($sql);
            if(empty($request))
            {
                $query_insert  = "INSERT INTO asistencia(id_usuario, fecha_hora, estado_asistencia) 
                                  VALUES(?,?,?)";
                $arrData = array($this->idUsuario,
                                $this->fechaActual->format('Y-m-d H:i:s'),
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
        // insertar por dni
        public function insertarAsistenciaDni(string $dni, DateTime $fecha, string $estado) {
            $fechaSolo = $fecha->format('Y-m-d');
        
            // Primero, obtener el id_usuario a partir del dni en la tabla usuario
            $sqlUsuario = "SELECT id_usuario FROM usuario WHERE identificacion = '{$dni}'";
            $usuario = $this->select($sqlUsuario);
            if(empty($usuario)) {
                return ""; // El DNI no corresponde a un usuario existente
            }
        
            // Ahora, verifica si ya existe una entrada de asistencia para ese id_usuario y fecha
            $idUsuario = $usuario['id_usuario']; // Asumiendo que el resultado es un array asociativo
            $sqlAsistencia = "SELECT id_usuario FROM asistencia WHERE 
                              id_usuario = '{$idUsuario}' AND DATE(fecha_hora) = '{$fechaSolo}'";
            $asistenciaExistente = $this->select($sqlAsistencia);
            
            if(empty($asistenciaExistente)) {
                // Si no hay registro, insertar la nueva asistencia
                $query_insert = "INSERT INTO asistencia (id_usuario, fecha_hora, estado_asistencia) 
                                 VALUES (?, ?, ?)";
                $arrData = array(
                    $idUsuario,
                    $fecha->format('Y-m-d H:i:s'),
                    $estado
                );
                $request_insert = $this->insert($query_insert, $arrData);
                
                return !empty($request_insert) ? "ok" : "error"; // Verifica si la inserción fue exitosa
            } else {
                return "exist"; // La asistencia ya existe, no se inserta
            }
        }
        
        
    }
?>