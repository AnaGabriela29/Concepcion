<?php
headerAdmin($data);
getModal("modalAsignacion", $data);
?>

<section>
        <div class="">
            <h3 class="""><i class=" fas fa-user-tag"></i> <?= $data['page_title'] ?>                
            </h3>
        </div>
    <div class="d-flex justify-content-between ">
        <div class="">
            <h3 class=""">
            <?php if ($_SESSION['permisosMod']['w']) { ?>
                    <button class="btn bg-color-sky-blue" type="button" onclick="openModal();"><i class="bi bi-plus-circle"></i>Nuevo</button>
                <?php } ?>
            </h3>
        </div>

        <div class="box-periodo ">
            <small>periodo </small>
            <span class="d-none" id="id_aula"><?= $data['Aula']['id_aula'] ?></span>
            <p class="fs-4"><?= $data['Periodo']['nombre'] ?></p>
        </div>

    </div>

    <div>
        <div>
            <p>Lugar de designación </p>
        </div>
        <div>
            <p>Aula: <span class="fs-5 dataAula" data-id="<?= $data['Aula']['id_aula']?>"><?= $data['Aula']['nombre'] ?></span></p>
        </div>
        <div>
            <p>Curso: <span class="fs-5 dataCurso" data-id="<?= $data['Curso']['id_curso']?>"><?= $data['Curso']['nombre'] ?></span></p>
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
                        <table class="table table-hover table-bordered" id="tableAsignaciones">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Identificacion</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Rol</th>                                                              
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

<?php footerAdmin($data) ?>