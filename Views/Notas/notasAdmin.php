<?php headerAdmin($data);
      getModal("modalNotas", $data);
?>

<section class="app-content">
      <div class="app-title d-flex justify-content-between">
        <div>
            <h2><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
              <?php if($_SESSION['permisosMod']['w']){ ?> 
                <button class="btn bg-color-sky-blue " type="button" onclick="openModal();" ><i class="bi bi-plus-circle"></i> Nuevo</button>
                <?php } ?> 
            </h2>
        </div>

        <div class="box-periodo ">
            <small>periodo </small>
            <span class="d-none" id="id_aula"><?= $data['Aula']['id_aula'] ?></span>
            <p class="fs-4"><?= $data['Periodo']['nombre'] ?></p>
        </div>        
      </div>

      <div>
        <div>
            <p>Detalles:  </p>
        </div>
        <div>
            <p>Aula: <span class="fs-5 dataAula" data-id="<?= $data['Aula']['id_aula']?>"><?= $data['Aula']['nombre'] ?></span></p>
        </div>
        <div class="d-flex justify-content-between">
            <p>Curso: <span class="fs-5 dataCurso" data-id="<?= $data['Curso']['id_curso']?>"><?= $data['Curso']['nombre'] ?></span></p>
            <div>
              <label for="selectbimestres fw-bold">Elija un bimestre</label>
              <select class="form-select" name="bimestres" id="selectBimestres">
                <option value="">--Seleccione un bimestre--</option>
                <option value="primerbimestre" selected>primer bimestre</option>
                <option value="segundobimestre">segundo bimestre</option>
                <option value="tercerbimestre">tercer bimestre</option>
                <option value="cuartobimestre">cuarto bimestre</option>                
              </select>
            </div>
        </div>
        <div>
            <p>Grado: <span class="fs-5 dataGrado" data-id="<?= $data['Grado']['id_grado']?>"><?= $data['Grado']['nombre'] ?></span></p>
        </div>

    </div>

        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableNotas">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Identificacion</th>
                          <th>Nombres</th>
                          <th>Apellidos</th>
                          <th>Estado</th>
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


<?php footerAdmin($data)?>