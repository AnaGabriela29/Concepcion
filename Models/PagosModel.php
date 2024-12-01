<?php 
class PagosModel extends Mysql{

    private $intDni;
    private $intIdUsuario;
    private $intIdConcepto;
    private $floatMonto;
    private $strTipoPago;
    private $strEstadoPago;
    private $strObservaciones;
    private $idPeriodo;
    private $intMesPago;    

    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerConceptoPagos(){
           
        $request="";
        $sql="SELECT id_concepto_pago, CONCAT(nombre_concepto, ' - ','s/', monto ) AS nombre FROM concepto_pago WHERE status!=0 ";
        $request=$this->select_all($sql);
        return $request;       
    }
    public function obtenerPeriodos(){
        $request="";
        $sql="SELECT id_periodo, nombre FROM periodo ";
        $request=$this->select_all($sql);
        return $request;  
    }
    public function obtenerNombreCompleto(int $dni) : array {
        $request=[];
        $this->intDni=$dni;
        $sql="SELECT id_usuario, nombres, apellidos FROM usuario where identificacion='{$this->intDni}'";
        $result=$this->select($sql); 
        if($result){
            $request = $result;
        }
        return $request;
    }

    public function ultimosPagos() : array{
        $request=[];        
        $sql="SELECT CONCAT(u.nombres, ' ', u.apellidos) AS nombres, cp.nombre_concepto, p.fecha_pago, p.monto_pagado FROM pago p INNER JOIN usuario u ON p.id_usuario=u.id_usuario INNER JOIN concepto_pago cp ON p.id_concepto_pago=cp.id_concepto_pago ORDER BY id_pago DESC LIMIT 10";
        $result=$this->select_all($sql); 
        if($result){
            $request = $result;
        }
        return $request;
    }

    public function insertPay($intIdUsuario, $intIdConcepto,$floatMonto, $strTipoPago, $strEstadoPago, $strObservaciones, $idPeriodo, $intMesPago):int {

        $this->intIdUsuario=$intIdUsuario;
        $this->intIdConcepto=$intIdConcepto;
        $this->floatMonto=$floatMonto;
        $this->strTipoPago=$strTipoPago;
        $this->strEstadoPago=$strEstadoPago;
        $this->strObservaciones=$strObservaciones;
        $this->idPeriodo=$idPeriodo;
        $this->intMesPago=$intMesPago;
        $sql="INSERT INTO  pago(id_usuario, id_concepto_pago, monto_pagado, tipo_pago, estado_pago, observaciones, id_periodo, mes) VALUES (?,?,?,?,?,?,?,?)";
        $arrdata=array($this->intIdUsuario, $this->intIdConcepto, $this->floatMonto, $this->strTipoPago, $this->strEstadoPago, $this->strObservaciones, $this->idPeriodo, $this->intMesPago);
        $result=$this->insert($sql, $arrdata);         
        return $result;
    }
    public function obtenerPagos(int $identificacion) :array {
        $result=[];
        $this->intDni=$identificacion;
        $sql="SELECT id_usuario FROM usuario WHERE identificacion='{$this->intDni}'";
        $request=$this->select($sql);
        if($request>0){
            $intDNI=$request['id_usuario'];
            $sql="SELECT p.id_pago, CONCAT(u.nombres, ' ', u.apellidos) AS nombres, cp.nombre_concepto, p.fecha_pago, cp.monto, p.monto_pagado, p.tipo_pago, p.estado_pago, p.observaciones, pe.nombre, p.mes FROM pago p INNER JOIN usuario u ON p.id_usuario=u.id_usuario INNER JOIN concepto_pago cp ON p.id_concepto_pago=cp.id_concepto_pago INNER JOIN periodo pe ON p.id_periodo=p.id_periodo WHERE p.id_usuario='{$intDNI}' LIMIT 100";
            $result=$this->select_all($sql);
            if($result){
                $request = $result;
            }
        }else{
            $request=[];
        }        
        return $request;
    }
    public function obtenerEstudiantesSinPago(int $mes, int $periodo, string $estado, int $concepto) :array{
        $request=[];
        $this->strEstadoPago=$estado;
        $this->idPeriodo=$periodo;
        $this->intMesPago=$mes;
        $this->intIdConcepto=$concepto;

        if($this->strEstadoPago=="Parcial"){
             // Lógica para pagos parciales
             $sql = "SELECT 
                        u.id_usuario, 
                        u.identificacion, 
                        CONCAT(u.nombres, ' ', u.apellidos) AS nombres, 
                        e.nombre_apoderado, 
                        e.numero_whatsapp, 
                        SUM(p.monto_pagado) AS total_pagado, 
                        cp.monto AS monto_completo, 
                        pe.nombre AS periodo, 
                        p.mes
                    FROM 
                        usuario u
                    INNER JOIN 
                        estudiante e ON u.id_usuario = e.id_usuario
                    INNER JOIN 
                        pago p ON u.id_usuario = p.id_usuario
                    INNER JOIN 
                        concepto_pago cp ON p.id_concepto_pago = cp.id_concepto_pago
                    INNER JOIN 
                        periodo pe ON p.id_periodo = pe.id_periodo
                    WHERE 
                        e.matriculado = 1
                        AND p.mes = '{$this->intMesPago}' 
                        AND p.id_periodo = '{$this->idPeriodo}'
                        AND p.id_concepto_pago='{$this->intIdConcepto}'
                        GROUP BY 
                        u.id_usuario, cp.monto, pe.nombre, p.mes
                    HAVING 
                        total_pagado < monto_completo;
                    ;";
            $result = $this->select_all($sql);            
            if($result){
                $request = $result;
            }
        }else if($this->strEstadoPago=="Deuda"){
                        // Lógica para estudiantes con deuda
                        $sql = "SELECT 
                        u.id_usuario,
                        u.identificacion,
                        CONCAT(u.nombres, ' ', u.apellidos) AS nombres,
                        e.nombre_apoderado,
                        e.numero_whatsapp,
                        cp.nombre_concepto AS concepto,
                        pe.nombre AS periodo,
                        '{$this->intMesPago}' AS mes
                        FROM 
                            usuario u
                        INNER JOIN 
                            estudiante e ON u.id_usuario = e.id_usuario
                        INNER JOIN 
                            concepto_pago cp ON cp.id_concepto_pago = '{$this->intIdConcepto}'
                        JOIN 
                            periodo pe ON pe.id_periodo = '{$this->idPeriodo}'
                        WHERE 
                            e.matriculado = 1
                            AND u.id_usuario NOT IN (
                                SELECT DISTINCT p.id_usuario
                                FROM pago p
                                WHERE p.mes = '{$this->intMesPago}' AND p.id_periodo = '{$this->idPeriodo}' AND p.id_concepto_pago='{$this->intIdConcepto}'
                            );                    
        
                    ";
            $result=$this->select_all($sql);   
            if($result){
                $request = $result;
            }    

        }else{
            $request=[];
        }

        return $request;
    }

    public function obtenerPago(int $id_pago) :array {
        $request=[];
        $sql="SELECT CONCAT(u.nombres, ' ', u.apellidos) AS nombres, u.telefono, cp.nombre_concepto, cp.monto, p.fecha_pago, p.monto_pagado, p.tipo_pago,p.id_pago, p.estado_pago, p.observaciones, pe.nombre as periodo, p.mes FROM pago p INNER JOIN usuario u ON p.id_usuario=u.id_usuario INNER JOIN concepto_pago cp ON p.id_concepto_pago=cp.id_concepto_pago INNER JOIN periodo pe ON p.id_periodo=pe.id_periodo WHERE id_pago='{$id_pago}' ";
        $result=$this->select($sql);
        if($result){
            $request = $result;
        }         
        return $request;
    }
    public function getUserData(int $id_usuario){
        $request=[];
        $sql="SELECT CONCAT(nombres, ' ', apellidos) AS nombreUsuario, email FROM usuario WHERE id_usuario='{$id_usuario}'";
        $result=$this->select($sql);
        if($result){
            $request = $result;
        }         
        return $request;
    }
    
}

?>