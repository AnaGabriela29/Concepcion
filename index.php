<?php 
	ini_set('display_errors', 1);
	ini_set('log_errors', 1); // Habilitar el registro de errores
	ini_set('error_log', '/home/colegiou/logs/error.log'); // ruta del archivo de log
	error_reporting(E_ALL);
	
	require_once("Config/Config.php");
	require_once("Helpers/Helpers.php");
	$url = !empty($_GET['url']) ? $_GET['url'] : 'login';
	$arrUrl = explode("/", $url);
	$controller = $arrUrl[0];
	$method = $arrUrl[0];
	$params = "";

	if(!empty($arrUrl[1]))
	{
		if($arrUrl[1] != "")
		{
			$method = $arrUrl[1];	
		}
	}

	if(!empty($arrUrl[2]))
	{
		if($arrUrl[2] != "")
		{
			for ($i=2; $i < count($arrUrl); $i++) {
				$params .=  $arrUrl[$i].',';
				# code...
			}
			$params = trim($params,',');
		}
	}
	require_once("Libraries/Core/Autoload.php");
	require_once("Libraries/Core/Load.php");

 ?>