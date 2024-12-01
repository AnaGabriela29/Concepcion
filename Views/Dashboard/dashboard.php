<?php headerAdmin($data); ?>


<div class="">
    <div class="app-title d-flex justify-content-between">
        <div>
            <h2 class="text-black"><i class="bi bi-speedometer"></i><?= $data['page_title'] ?></h2>
        </div>        
    </div>
    <section class="box-contain row">
        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
            <div class="col-6 col-md-4 col-lg-3 p-2">
                <a href="<?= base_url() ?>/usuarios" class="">
                    <div class="box-amount "><i class="bi bi-people-fill fs-1 icon-box-amount m-2"></i>
                        <div class="info d-flex justify-content-center align-items-center flex-column">
                            <h4>Usuarios</h4>
                            <p><b><?= $data['Usuarios'] ?></b></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
            <div class="col-6 col-md-4 col-lg-3 p-2 ">
                <a href="<?= base_url() ?>/alumnos" class="">
                    <div class="box-amount "><i class="bi bi-backpack2-fill fs-1 icon-box-amount m-2 "></i>
                        <div class="info d-flex justify-content-center align-items-center flex-column">
                            <h4>Alumnos</h4>
                            <p><b><?= $data['Alumnos'] ?></b></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
            <div class="col-6 col-md-4 col-lg-3 p-2">
                <a href="<?= base_url() ?>/cursos" class="">
                    <div class="box-amount "><i class="bi bi-journal-album fs-1 icon-box-amount m-2"></i>
                        <div class="info d-flex justify-content-center align-items-center flex-column">
                            <h4>Cursos</h4>
                            <p><b><?= $data['Cursos'] ?></b></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
            <div class="col-6 col-md-4 col-lg-3 p-2">
                <a href="<?= base_url() ?>/grados" class="">
                    <div class="box-amount "><i class="bi bi-ladder fs-1 icon-box-amount m-2"></i>
                        <div class="info d-flex justify-content-center align-items-center flex-column">
                            <h4>Grados</h4>
                            <p><b><?= $data['Grados'] ?></b></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
            <div class="col-6 col-md-4 col-lg-3 p-2">
                <a href="<?= base_url() ?>/aulas" class="">
                    <div class="box-amount "><i class="bi bi-houses-fill fs-1 icon-box-amount m-2"></i>
                        <div class="info d-flex justify-content-center align-items-center flex-column">
                            <h4>Aulas</h4>
                            <p><b><?= $data['Aulas'] ?></b></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>      
    </section>
    <section class="container">
    <div class="row justify-content-center ">
        <div class="col-12 col-md-6 chart-container">
            <canvas class="graf-day" id="dailyAttendanceChart"></canvas>
        </div>
        <div class="col-12 col-md-6 chart-container">
            <canvas class="graf-month" id="monthlyPaymentsChart"></canvas>
        </div>    
    </div>
    </section>


    <section class="">


    </section>
</div>

<?php footerAdmin($data); ?>