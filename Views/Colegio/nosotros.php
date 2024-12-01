<?php 
	headerColegio($data);
 ?>
<section class="section-us py-5">
    <div class="container">
        <h2 class="text-center fw-bold text-primary mb-4">Sobre Nosotros</h2>
        <p class="text-center text-muted fs-5 mb-5">
            En el Colegio UNIMAT, estamos comprometidos con la formación integral de nuestros estudiantes, fomentando valores, excelencia académica y una visión global para un futuro mejor.
        </p>

        <div class="row align-items-center mb-5">
            <div class="col-12 col-lg-6">
                <img src="<?=media()?>/colegio/images/nosotros-1.jpg" class="img-fluid rounded shadow" alt="Colegio UNIMAT">
            </div>
            <div class="col-12 col-lg-6">
                <h3 class="fw-semibold mb-3">¿Quiénes Somos?</h3>
                <p class="text-muted">
                    Desde nuestros inicios, nos hemos dedicado a brindar una educación de calidad que inspire a los estudiantes a alcanzar su máximo potencial. Nuestra metodología combina innovación, ética y compromiso social.
                </p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-primary me-2"></i> Excelencia educativa en cada nivel.
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-primary me-2"></i> Equipo docente altamente capacitado.
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-primary me-2"></i> Infraestructura moderna y segura.
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-primary me-2"></i> Compromiso con el desarrollo personal y profesional.
                    </li>
                </ul>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-12 col-md-4">
                <div class="us-card">
                    <i class="bi bi-people text-primary us-icon"></i>
                    <h4 class="us-card-title">Nuestra Misión</h4>
                    <p class="us-card-text">
                        Brindar una educación integral, formando estudiantes con valores, conocimientos y habilidades para enfrentar los retos del futuro.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="us-card">
                    <i class="bi bi-eye text-primary us-icon"></i>
                    <h4 class="us-card-title">Nuestra Visión</h4>
                    <p class="us-card-text">
                        Ser reconocidos como un colegio líder en educación, destacándonos por nuestra calidad, innovación y compromiso social.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="us-card">
                    <i class="bi bi-globe text-primary us-icon"></i>
                    <h4 class="us-card-title">Nuestros Valores</h4>
                    <p class="us-card-text">
                        Ética, responsabilidad, solidaridad y respeto son los pilares que guían nuestra comunidad educativa.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<?php 
	footerColegio($data);
 ?>