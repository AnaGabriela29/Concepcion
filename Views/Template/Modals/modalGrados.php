<!-- Modal -->
<div class="modal fade" id="modalFormGrado" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Grado</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form id="formGrado" name="formGrado" class="form-horizontal">
              <input type="hidden" id="idGrado" name="idGrado" value="">
              <p class="">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="txtNombreGrado">Nombre del grado <span class="required">*</span></label>
                  <input type="text" class="form-control" id="txtNombreGrado" name="txtNombreGrado" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtDescripcionGrado">Descripción del grado </label>
                  <input type="text" class="form-control valid validText" id="txtDescripcionGrado" name="txtDescripcionGrado" required="">
                </div>               
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleSelect1">Estado</label>
                    <select class="form-control" id="listStatus" name="listStatus" required="">
                      <option value="1">Activo</option>
                      <option value="2">Inactivo</option>
                    </select>
                </div>
              </div>                     

                
              <div class="tile-footer d-flex justify-content-center m-2">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewGrado" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del grado</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Nombre del Grado:</td>
              <td id="celNombreGrado">654654654</td>
            </tr>
            <tr>
              <td>Descripción del grado:</td>
              <td id="celDescripcionGrado">Jacob</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstadoGrado">Jacob</td>
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

