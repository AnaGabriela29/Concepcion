<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Tienda Virtual Abel OSH">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= media() ?>/colegio/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= media() ?>/colegio/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= media() ?>/colegio/images//favicon-16x16.png">
    <link rel="manifest" href="<?= media() ?>/colegio/images//site.webmanifest">
    <title><?= $data['page_tag'] ?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/plugins/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/js/plugins/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/plugins/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/plugins/select2.min.css">

    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/plugins/style.css">    
    <link rel="stylesheet" type="text/css" href=" <?= media(); ?>/css/mystyle.css">
    <?php if (isset($data['page_id']) && $data['page_id'] == 2): ?>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>

  </head>

  <body>
    <!-- Contenedor de carga -->
    <div id="loading" style="display: none;">
      <div id="loading-content">
        <img src="<?=media()?>/images/ico_loader.gif" alt="Cargando..." />
      </div>
    </div>

    <div class="wrapper">
      
    <?php require_once("nav_admin.php"); ?> 