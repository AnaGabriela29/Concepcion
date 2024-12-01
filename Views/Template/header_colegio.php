<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= $data['page_tag']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<?php 
		$nombreSitio = NOMBRE_EMPESA;
		$descripcion = DESCRIPCION;
		$urlWeb = base_url();		
		
	?>
	<meta property="og:locale" 		content='es_ES'/>
	<meta property="og:type"        content="website" />
	<meta property="og:site_name"	content="<?= $nombreSitio; ?>"/>
	<meta property="og:description" content="<?= $descripcion; ?>" />
	<meta property="og:url"         content="<?= $urlWeb; ?>" />

<!--===============================================================================================-->	
  <link rel="apple-touch-icon" sizes="180x180" href="<?= media() ?>/colegio/images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= media() ?>/colegio/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= media() ?>/colegio/images//favicon-16x16.png">
  <link rel="manifest" href="<?= media() ?>/colegio/images//site.webmanifest">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/colegio/css/plugins/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/colegio/plugins/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
<!--===============================================================================================-->

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/colegio/css/style.css">
<!--===============================================================================================-->
</head>
<body class="">
<div class="d-lg-flex justify-content-between align-items-center d-none bg-first-alpha-color">
    <div class="main-phrase overflow-hidden">
        <!-- Frase animada -->
        <div class="animated-text">
            "Potenciamos las competencias de los estudiantes, formando líderes con valores y visión de futuro preparados para un mundo en constante cambio."
        </div>
    </div>
    <div class="d-flex p-1">
        <a class="text-decoration-none text-white" href="<?=base_url()?>/login"><i class="bi bi-person-circle"></i> Iniciar sesión </a>
        <p class="text-white m-0"> | contacto al número: <?=TELEMPRESA?></p>
    </div>
</div>

	
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container bg-dark">
          <a class="navbar-brand d-flex align-items-center justify-content-center" href="<?=base_url()?>/home">
            <img src="<?=media()?>/colegio/images/logo_unimat.webp" class="img-fluid me-1" alt="Studio Bad Dog">
			<p class="m-0">Colegio UNIMAT</p>
          </a>
          <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-lg-auto">
              <li class="nav-item">
                <a class="nav-link page_active" aria-current="page" href="<?=base_url()?>/home">Inicio</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  UNIMAT
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="<?=base_url()?>/Colegio/noticias">Noticias</a></li>
                  <li><a class="dropdown-item" href="<?=base_url()?>/Colegio/colaboradores">Nuestro Equipo</a></li>
                  <li><a class="dropdown-item" href="<?=base_url()?>/Colegio/reglamento">Reglamento interno</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>/Colegio/propuesta">Propuesta Educativa</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>/Colegio/nosotros">Nosotros</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?=base_url()?>/Colegio/contactanos">Contáctanos</a>
              </li>
              <li class="nav-item d-block d-lg-none">                
                <a class="nav-link" href="<?=base_url()?>/login"><i class="bi bi-person-circle"></i>Iniciar sessión </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

