<!-- Modal -->

<div class="modal fade" id="modalformControlasistencia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva asistencia</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formControlasistencia" name="formControlasistencia" class="form-horizontal  ">
          <input type="hidden" id="idAsistencia" name="idAsistencia" value="">
          <p class="d-flex justify-content-center">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

          <div class="row">            
              <div class="col-12 col-md-6">
                <label for="txtNumerodni">Numero de DNI: *</label>
                <input type="number" class="form-control" id="txtNumerodni" name="txtNumerodni" required="">
              </div>
              <div class="col-12 col-md-6 ">
                <label for="txtFechaRegistro">Fecha de registro *</label>
                <input type="datetime-local" class="form-control valid validText" id="txtFechaRegistro" name="txtFechaRegistro" >
              </div>
    
                <div class="form-group mb-2 col-12 col-md-6  ">
                    <label for="txtEstadoAsistencia">Estado de asistencia *</label>
                    <select class="form-select" name="txtEstadoAsistencia" id="txtEstadoAsistencia">
                      <option value="Puntual">Puntual</option>
                      <option value="Tardanza">Tardanza</option>
                      <option value="Justificado">Justificado</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-6 d-flex flex-column">
                    <label for="txtObservacion">Observacion </label>
                    <textarea name="txtObservacion" class="rounded" id="txtObservacion" cols="30" rows="5"></textarea>
                </div>
            
          </div>
          <div class="tile-footer d-flex justify-content-center my-1">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewAsistencia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la Asistencia</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Numero de DNI:</td>
              <td id="celNombredni">654654654</td>
            </tr>
            <tr>
              <td>Nombre y Apellidos:</td>
              <td id="celNombreApellidos">654654654</td>
            </tr>
            <tr>
              <td>Fecha de registro:</td>
              <td id="celFechaRegistro">Jacob</td>
            </tr>
            <tr>
              <td>Estado de la asistencia:</td>
              <td id="celEstado">Jacob</td>
            </tr>
            <tr>
              <td>Observaciones:</td>
              <td id="celObservaciones">Jacob</td>
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