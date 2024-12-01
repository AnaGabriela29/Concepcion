<?php
headerAdmin($data);
getModal("modalAsignacion", $data);
?>
<section>

    <div class="d-flex justify-content-between align-items-center">
        <div class="">
            <h3 class="""><i class=" fas fa-user-tag"></i> <?= $data['page_title'] ?>                
            </h3>
        </div>

        <div class="box-periodo ">
            <small>periodo </small>
            <p class="fs-4"><?= $data['Periodo']['nombre'] ?></p>
        </div>

    </div>

    <div class="d-flex">
        <p class="fs-3">Aulas Registradas en UNIMAT </p>
    </div>

    <div class="bg-color-gray-light row rounded">
        <?php foreach ($data['Aulas'] as $aula) { ?>
           
                <div class="col-6 col-lg-4 col-xl-2 ">
                    <div class="m-2 box-asignacion box-aula">
                        <i class="bi bi-house-up-fill box-asignacion-icon m-1" |></i>
                        <span class="fs-2" data-id="<?= $aula['id_aula']?>"><?= $aula['nombre'] ?></span>

                    </div>
                </div>
            

        <?php }; ?>
    </div>

    <div>
        <p class="fs-3">Cursos Registrados en UNIMAT</p>
    </div>

    <div class="bg-color-gray-light row rounded">
        <?php foreach ($data['Cursos'] as $curso) { ?>
           
                <div class=" col-6 col-lg-4 col-xl-2">
                    <div class="m-2 box-asignacion box-curso">
                        <i class="bi bi-journal-bookmark-fill box-asignacion-icon m-1"></i>
                        <span class="fs-5" data-id="<?= $curso['id_curso']?>"><?= $curso['nombre'] ?></span>
                    </div>                    
                </div>
           

        <?php }; ?>
    </div>

    <div>
        <p class="fs-3">Grados Registrados en UNIMAT</p>
    </div>

    <div class="bg-color-gray-light row rounded">
        <?php foreach ($data['Grados'] as $grado) { ?>
           
                <div class="col-6 col-lg-4 col-xl-2">
                    <div class="m-2 box-asignacion box-grado">

                        <i class="bi bi-bar-chart-steps box-asignacion-icon m-1"></i>
                            <span class="fs-5" data-id="<?= $grado['id_grado']?>"><?= $grado['nombre'] ?></span>
                    </div>
                </div>
           

        <?php }; ?>
    </div>

    <div class="d-flex justify-content-center">
        <button type="button" class="bg-color-sky-blue text-white rounded p-2 m-2 btnIrAsignar" >Ir Asignar</button>
    </div>
</section>
<?php footerAdmin($data) ?>