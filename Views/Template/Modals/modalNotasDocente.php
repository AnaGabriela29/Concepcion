<!-- Modal -->
<div class="modal fade modalNotas" id="modalNotas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Agregar Notas</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="tile">
            <div class="tile-body">
              <form id="formNotas" name="formNotas">
                <input type="hidden" id="csrf" name="csrf" class="csrf" value="<?php echo $data['token']?>">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>N°</th>
                          <th>Nombre y apellidos</th>
                          <th>Nota</th>
                        </tr>
                      </thead>
                      <tBody class="tablaNotas" id="tablaNotas">


                      </tBody>
                    </table>

              


                <div class="tile-footer">
                  <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-bs-dismiss="modal" ><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

