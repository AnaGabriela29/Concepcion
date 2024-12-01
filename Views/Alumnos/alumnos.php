<?php 
    headerAdmin($data); 
    getModal('modalAlumnos',$data);
?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

  <main class="app-content">    
      <div class="app-title d-flex justify-content-between">
        <div>
            <h2><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
                <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn bg-color-sky-blue" type="button" onclick="openModal();" ><i class="bi bi-plus-circle-fill"></i> Nuevo</button>
              <?php } ?>
            </h2>
        </div>
        <div>
        <?php if($_SESSION['permisosMod']['w']){ ?>
        <button type="button" class="btn bg-color-sky-blue my-2"" data-bs-toggle="modal" data-bs-target="#import_Alumn">
        <i class="bi bi-cloud-arrow-up-fill"></i> Importar Alumnos 
        </button>
        <?php } ?>
        </div>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableAlumnos">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Identificación</th>
                          <th>Nombres</th>
                          <th>Apellidos</th>
                          <th>Email</th>
                          <th>Teléfono</th>
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
    