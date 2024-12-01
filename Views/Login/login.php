<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Abel OSH">
  <meta name="theme-color" content="#009688">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= media() ?>/colegio/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= media() ?>/colegio/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= media() ?>/colegio/images//favicon-16x16.png">
    <link rel="manifest" href="<?= media() ?>/colegio/images//site.webmanifest">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/plugins/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/js/plugins/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/loginStyle.css">

  <title><?= $data['page_tag']; ?></title>
</head>

<body>
  <div id="loading" style="display: none;">
      <div id="loading-content">
        <img src="<?=media()?>/images/ico_loader.gif" alt="Cargando..." />
      </div>
  </div>
  <section class="material-half-bg ">
    <div class="cover"></div>
  </section>
  <section class="form-container bg-login  d-flex justify-content-center align-items-center flex-column">
    <div class="logo">
      <h1><?= $data['page_title']; ?></h1>
    </div>
    <div class="flip-container border ">
      <div id="divLoading">
        <!-- <div>
            <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
          </div> -->
      </div>
      <form class="login-form front p-4 bg-white " name="formLogin" id="formLogin" action="">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user text-light"></i>INICIAR SESIÓN</h3>
        <div class="form-group">
          <label class="control-label">USUARIO</label>
          <input id="txtEmail" name="txtEmail" class="form-control" type="email" placeholder="Email" autofocus>
        </div>


        <div class="imput-group">
          <label class="control-label">CONTRASEÑA</label>
          
          <div class="input-group mb-3">
          <input type="password" id="txtPassword" name="txtPassword" class="form-control" placeholder="contraseña" aria-label="contraseña" aria-describedby="basic2">
          <span class="input-group-text " id="basic2"><i class="bi bi-eye-fill"></i></span>
        </div>
        </div>

        <div class="form-group ">
          <div class="utility">
            <p class="semibold-text mb-2 flip "><a href="#" data-toggle="flip">¿Olvidaste tu contraseña?</a></p>
          </div>
        </div>
        <div id="alertLogin" class="text-center"></div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> INICIAR SESIÓN</button>
        </div>
      </form>

      <form id="formRecetPass" name="formRecetPass" class="forget-form back p-4 bg-white" action="">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidaste tu contraseña?</h3>
        <div class="form-group">
          <label for="txtEmailReset" class="control-label">EMAIL</label>
          <input id="txtEmailReset" name="txtEmailReset" class="form-control" type="email" placeholder="Email">
        </div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block mt-3"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
        </div>
        <div class="form-group mt-3 ">
          <p class="semibold-text mb-0 flip"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Iniciar sesión</a></p>
        </div>
      </form>
    </div>
  </section>

  <script>
    const base_url = "<?= base_url(); ?>";
  </script>
  <!-- Essential javascripts for application to work-->

  <script src="<?= media(); ?>/js/plugins/jquery-3.7.0.js"></script>
  <script src="<?= media(); ?>/js/plugins/bootstrap.bundle.min.js"></script>

  <!-- sweetalert2@11 plugins-->
  <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert2@11.js"></script>
  <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
</body>

</html>