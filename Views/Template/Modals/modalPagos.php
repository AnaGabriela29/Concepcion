<!-- Modal -->
<div class="modal fade" id="search-pay-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Buscar los pagos registrados</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column">
        
            <label class="m-auto mb-2" for="searchPayDni">Ingrese numero de DNI del usuario:</label>
            <input type="number" id="searchPayDni" class="m-auto" name="searchPayDni">
        

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnSearchPayments">Buscar Registros</button>
      </div>
    </div>
  </div>
</div>