<?php 
	// const BASE_URL = "http://localhost/unimat";
	
	require_once __DIR__ . '/../Libraries/vendor/autoload.php';
	date_default_timezone_set('America/Lima');
	
	try {
		$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../Config');
		$dotenv->load();
		
	} catch (Exception $e) {
		error_log("ERROR: " . $e->getMessage());  
	}
	
	$environment = isset($_ENV['APP_ENV']) ? $_ENV['APP_ENV'] : 'production';

	if ($environment === 'development') {
		// Configuración para desarrollo		
		define('DB_HOST', 'localhost');
		define('DB_USER', 'root');
		define('DB_PASSWORD', '');
		define('DB_NAME', 'unimatbd');
		define('BASE_URL', 'http://localhost/unimat');
	} else {
		// Configuración para producción		
		define('DB_HOST', $_ENV['DB_HOST']);
        define('DB_USER', $_ENV['DB_USER']);
        define('DB_PASSWORD', $_ENV['DB_PASS']);
        define('DB_NAME', $_ENV['DB_NAME']);
        define('BASE_URL', 'https://colegiounimat.com');
	}
	// Charset para la base de datos
	define('DB_CHARSET', 'utf8');
	
	//Para envío de correo
	const ENVIRONMENT = 1; // Local: 0, Produccón: 1;

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";



	//Datos envio de correo
	const NOMBRE_REMITENTE = "Colegio UNIMAT";
	const EMAIL_REMITENTE = "colegiounimat@colegiounimat.com";//tiene que cambiar cuando este en produccion
	const NOMBRE_EMPESA = "Colegio UNIMAT";
	const WEB_EMPRESA = "www.colegiounimat.com";

	const DESCRIPCION = "Colegios unimat, consorcio educativo";
	const SHAREDHASH = "CoelgioUNIMAT";

	//Datos Empresa
	const DIRECCION = "Av. 28 de julio N° 665";
	const TELEMPRESA = "+(056)215487";
	const WHATSAPP = "998589309";
	const EMAIL_EMPRESA = "colegiounimat@colegiounimat.com";
	const EMAIL_CONTACTO = "colegiounimat@colegiounimat.com";

	const CAT_SLIDER = "1,2,3";
	const CAT_BANNER = "4,5,6";
	const CAT_FOOTER = "1,2,3,4,5";

	//Datos para Encriptar / Desencriptar
	const KEY = 'unimat';
	const METHODENCRIPT = "AES-128-ECB";

	//Módulos
	const MDASHBOARD = 1;
	const MUSUARIOS = 2;
	const MALUMNOS = 3;
	const MCURSOS = 4;
	const MGRADOS = 5;
	const MAULAS = 6;
	const MCONFIGURACION = 7;
	const MNOTAS = 8;
	const MASISTENCIA=9;	
	const MCONTROLASISTENCIA=10;
	const MPAGOS=11;
	const MDPAGINAS = 10;

	//Periodo
	const PERIODO=1;

	//Páginas
	const PINICIO = 1;
	const PTIENDA = 2;
	const PCARRITO = 3;
	const PNOSOTROS = 4;
	const PCONTACTO = 5;
	const PPREGUNTAS = 6;
	const PTERMINOS = 7;
	const PSUCURSALES = 8;
	const PERROR = 9;

	//Roles
	const RADMINISTRADOR = 1;
	const RDOCENTE = 2;
	const RALUMNOS = 3;

	const STATUS = array('Completo','Aprobado','Cancelado','Reembolsado','Pendiente','Entregado');

	//Productos por página
	const CANTPORDHOME = 8;
	const PROPORPAGINA = 4;
	const PROCATEGORIA = 4;
	const PROBUSCAR = 4;

	//REDES SOCIALES
	const FACEBOOK = "https://www.facebook.com/I.E.P.UNIMAT";
	const INSTAGRAM = "https://www.facebook.com/I.E.P.UNIMAT";

	// CONFIGURACION DE ASISTENCIA
	define('HORAINICIOASISTENCIA', '02:00:00');
    define('HORAFINALASISTENCIA', '23:00:00');
	define('HORAINGRESO', '08:00:00');	

 ?>