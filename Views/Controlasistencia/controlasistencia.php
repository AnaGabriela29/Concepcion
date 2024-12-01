<?php 
    headerAdmin($data); 
    getModal('modalControlasistencia',$data);
?>
    <div id="contentAjax"></div> 
    <main class="app-content">
      <div class="app-title">
        <div>
            <h2><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
              <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn bg-color-sky-blue" type="button" onclick="openModal();" ><i class="bi bi-plus-circle"></i> Nuevo</button>
                <?php } ?> 
            </h2>
        </div>
       
      </div>

        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableControlasistencia">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>DNI</th>
                          <th>Fecha</th>
                          <th>Estado</th>
                          <th>Observaciones</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </main>
<?php footerAdmin($data); ?>
    