<!-- Modal -->
<div class="modal fade" id="modalFormAlumno" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form id="formAlumno" name="formAlumno" class="form-horizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="txtIdentificacion">Identificación (*dni)<span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtNombre">Nombres <span class="required">*</span></label>
                  <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                </div>                
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="txtApellido">Apellidos <span class="required">*</span></label>
                  <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtTelefono">Teléfono <span class="required">*</span></label>
                  <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                </div>              
              </div>           
             
             <div class="row">
                <div class="form-group col-md-6">
                  <label for="txtEmail">Email <span class="required">*</span></label>
                  <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtPassword">Password </label>
                  <input type="password" class="form-control" id="txtPassword" name="txtPassword" >
                </div>
             </div>

             <div class="row">
                <div class="form-group col-md-6">
                  <label for="txtApoderado">Nombre Apoderado </label>
                  <input type="text" class="form-control" id="txtApoderado" name="txtApoderado" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtNumeroApoderado">Numero del Apoderado </label>
                  <input type="number" class="form-control" id="txtNumeroApoderado" name="txtNumeroApoderado" >
                </div>
             </div>

             <div class="row">
                <div class="form-group col-md-6">
                  <label for="listMatriculado">Matriculado</label>
                  <select class="form-control" id="listMatriculado" name="listMatriculado" required>
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>                
             </div>
              <div class="tile-footer d-flex justify-content-center mt-2">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewAlumno" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del alumno</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr class="d-none">
              <td>Id:</td>
              <td id="celId">654654654</td>
            </tr>
            <tr>
              <td>Identificación:</td>
              <td id="celIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="celEmail">Larry</td>
            </tr>
            
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
            </tr>
            <tr>
              <td>Nombre del apoderado:</td>
              <td id="celNombreApoderado">Larry</td>
            </tr>
            <tr>
              <td>Numero del apoderado:</td>
              <td id="celNumeroApoderado">Larry</td>
            </tr>
            <tr>
              <td>Matriculado:</td>
              <td id="celMatriculado">larry</td>
            </tr>
            <tr>
              <td>Codigo QR</td>
              <td> <!-- Columna para el código QR -->
              <div class="col-md-6">
                  <!-- Fila para el código QR -->
                  <div class="row display-qr">
                      <div class="col d-flex justify-content-center flex-column">
                          
                          <div class="img-qr">
                              <!-- <img src="" class="img-qr" alt="imagen qr de identificación"> -->
                          </div>
                          <div>
                           
                              <button id="print-button" type="button" class="rounded"><i class="bi bi-printer-fill me-1"></i>Imprimir</button>
                           
                          </div>
                      </div>
                  </div>
              </div>
            </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-xl" id="import_Alumn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Importar datos de alumnos masivamente con Excel</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
        <small>Descargue la plantilla y complete los datos </small>
        <a class="btn bg-color-white color-sky-blue border btn-excel-download mx-2" href="<?=media()?>/facturaTemp/Plantilla_de_regsitro_de_alumnos.xlsx"><i class="bi bi-cloud-arrow-down-fill mx-1"></i>Descargar Plantilla</a>
        <div class="drop-area m-2" id="drop-area">
          Arrastra y suelta tu archivo Excel aquí o haz clic para seleccionarlo.
          <form id="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" accept=".xlsx" id="file-input" hidden>
          </form>
        </div>
        <div id="table-container">
          <table id="uploaded-data-table"></table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="upload-btn">Guardar</button>
      </div>
    </div>
  </div>
</div>
