<?php 
    headerAdmin($data); 
    getModal('modalRoles',$data);
    
?>
    <div id="contentAjax"></div> 
    <section class="app-content">
      <div class="app-title">
        <div>
            <h2><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
              <?php if($_SESSION['permisosMod']['w']){ ?> 
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="bi bi-plus-circle"></i> Nuevo</button>
               <?php } ?> 
            </h2>
        </div>
        
      </div>

        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableRoles">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Descripción</th>
                          <th>Status</th>
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
    </section>
<?php footerAdmin($data); ?>
    