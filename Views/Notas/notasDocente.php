<?php headerAdmin($data);
getModal("modalNotasDocente", $data);
?>

<section>
    <div class="app-title d-flex justify-content-between">
        <div>
            <h2><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
                
            </h2>
        </div>       
    </div>

    <div>
        <p>Asignaciones en UNIMAT: <small></small></p>
    </div>

    <div class="row">
    <?php 
    if (!empty($data['asignaciones'])) {
        foreach($data['asignaciones'] as $asignacion) {
    ?>
            <div class="col-6 col-md-4 col-lg-3 h-100 ">
                <div class="box-docente-asignacion bg-color-sky-blue shadow-box d-flex flex-column btn">
                <p>Aula: <span class="date-aula" data-id="<?php echo$asignacion['id_aula']?>"><?php echo $asignacion['nombre_aula']; ?></span></p>
                <p>Grado: <span class="date-grado" data-id="<?php echo$asignacion['id_grado']?>"><?php echo $asignacion['nombre_grado']; ?></span></p>
                <p>Curso: <span class="date-curso" data-id="<?php echo$asignacion['id_curso']?>"><?php echo $asignacion['nombre_curso']; ?></span></p>
                </div>            
            </div>
    <?php 
        }
    } else {
        echo "No hay asignaciones disponibles.";
    }
    ?>
</div>

</section>



<?php footerAdmin($data) ?>