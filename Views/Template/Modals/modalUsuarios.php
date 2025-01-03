<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form id="formUsuario" name="formUsuario" class="form-horizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="">Todos los campos son obligatorios.</p>

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="txtIdentificacion">Identificación</label>
                  <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
                </div>
             
                <div class="form-group col-md-6">
                  <label for="txtNombre">Nombres</label>
                  <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                </div>

                <div class="form-group col-md-6">
                  <label for="txtApellido">Apellidos</label>
                  <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                </div>

                <div class="form-group col-md-6">
                  <label for="txtTelefono">Teléfono</label>
                  <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required=""">
                </div>

              </div>

              <div class="row">
               
                <div class="form-group col-md-6">
                  <label for="txtEmail">Email</label>
                  <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                </div>
             
                <div class="form-group col-md-6">
                    <label for="listRolid">Tipo usuario</label>
                    <select class="form-control" data-live-search="true" id="listRolid" name="listRolid" required >                    
                  </select>
                </div>               
             </div>

             <div class="row">            
                                  
                      <div class="form-group col">
                          <label for="txtPassword">Password</label>
                          <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                      </div>
                  
                      <div class="form-group col">
                          <label for="listStatus">Status</label>
                          <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                              <option value="1">Activo</option>
                              <option value="2">Inactivo</option>
                          </select>
                      </div>                                          
          </div>




              <div class="tile-footer d-flex justify-content-center mt-5">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody class="">
            <tr class="d-none">
              <td class="">Id:</td>
              <td id="celId">654654654</td>
            </tr>
            <tr class="">
              <td class="">Identificación:</td>
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
              <td>Tipo Usuario:</td>
              <td id="celTipoUsuario">Larry</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
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

<div class="modal fade modal-xl" id="print_Users" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Imprimir las card masivamente de todos los usuarios</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body row ">
        <div class="col-12 col-md-10 d-flex">
          <label for="states[]" class="mx-2">Seleccione los roles de usuarios a imprimir</label>
          <select class="select-lista-roles text-black" name="states[]" multiple="multiple">        
          </select>
        </div>  
        <div class="col-12 col-md-2">
          <button id="btn-extract-information" type="button" class="btn bg-color-white color-sky-blue border btn-excel-download mx-2 ">Extraer información</button>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary" id="upload-btn">Imprimir</button> -->
      </div>
    </div>
  </div>
</div>


