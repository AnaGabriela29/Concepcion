<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Abel OSH">
    <meta name="theme-color" content="#009688">
   
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/plugins/bootstrap.min.css">
    <style>
      body {
        background: linear-gradient(135deg, rgb(5, 31, 92) 25%, rgba(5, 31, 92, 0.7) 25%, rgba(5, 31, 92, 0.7) 50%, rgb(249, 174, 59) 50%, rgb(249, 174, 59) 75%, rgba(249, 174, 59, 0.7) 75%);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }
      .login-content {
        width: 100%;
        max-width: 400px;
        padding: 20px;
        background: linear-gradient(135deg, rgb(5, 31, 92) 25%, rgba(5, 31, 92, 0.2) 25%, rgba(5, 31, 92, 0.2) 50%, rgb(249, 174, 59) 50%, rgb(249, 174, 59) 75%, rgba(249, 174, 59, 0.2) 75%);
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border: 2px solid #fff ;
      }
      .login-content h1 {
        text-align: center;
        margin-bottom: 20px;
      }
      .login-content .form-control {
        background-color: white;
        border: 1px solid #444;
        color: black;
      }
      .login-content .btn-primary {
        background-color: #e50914;
        border: none;
      }
      .login-content .btn-primary:hover {
        background-color: #f6121d;
      }
      #loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      #loading-content img {
        width: 100px; /* Ajusta esto según el tamaño de tu logo */
      }

    </style>
    <title><?= $data['page_tag']; ?></title>
  </head>
  <body>
  <div id="loading" style="display: none;">
      <div id="loading-content">
        <img src="<?=media()?>/images/ico_loader.gif" alt="Cargando..." />
      </div>
  </div>
    
    <div class="login-content">
      <div class="d-flex justify-content-center my-4">
        <h4>Colegio Unimat</h4>
      </div>
      <h6><?= $data['page_title']; ?></h6>
      <form id="formCambiarPass" name="formCambiarPass" action="">
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona']; ?>" required>
        <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required>
        <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required>
        <!-- <h3 class="text-center mb-3"><i class="fas fa-key"></i> Cambiar contraseña</h3> -->
        <div class="form-group mb-3">
          <label for="txtPassword">Nueva contraseña</label>
          <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva contraseña" >
        </div>
        <div class="form-group mb-3">
          <label for="txtPassword">Confirmar contraseña</label>
          <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar contraseña" >
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block w-100"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
        </div>
      </form>
    </div>
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    <!-- Essential javascripts for application to work--> 
    <script src="<?= media(); ?>/js/plugins/jquery-3.7.0.js"></script>   
    <script src="<?= media(); ?>/js/plugins/bootstrap.bundle.min.js"></script>   
    <script type="text/javascript" src="<?= media();?>/js/plugins/sweetalert2@11.js"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
  </body>
</html>
