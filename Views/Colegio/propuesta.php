<?php 
	headerColegio($data);
 ?>
<section class="section-proposal py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4 text-primary">Nuestra Propuesta Educativa</h2>
        <p class="text-center text-muted mb-5 fs-5">
            En el Colegio UNIMAT, desarrollamos un enfoque integral para formar estudiantes líderes, preparados para afrontar los retos del mundo actual con valores, excelencia académica y un compromiso con la sociedad.
        </p>
        <div class="row align-items-center mb-5">
            <div class="col-12 col-lg-6">
                <img src="<?=media()?>/colegio/images/propuesta-educativa.jpg" class="img-fluid rounded shadow" alt="Propuesta Educativa UNIMAT">
            </div>
            <div class="col-12 col-lg-6">
                <h3 class="fw-semibold mb-3">Pilares de Nuestra Educación</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-primary me-2"></i> Educación de Alto Rendimiento
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-primary me-2"></i> Formación en Valores
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-primary me-2"></i> Desarrollo de Habilidades Tecnológicas
                    </li>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle text-primary me-2"></i> Actividades Culturales y Deportivas
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="proposal-card">
                    <i class="bi bi-lightbulb text-primary proposal-icon"></i>
                    <h4 class="proposal-title">Innovación Educativa</h4>
                    <p class="proposal-text">
                        Implementamos metodologías modernas para potenciar el aprendizaje significativo y la creatividad.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="proposal-card">
                    <i class="bi bi-person-check text-primary proposal-icon"></i>
                    <h4 class="proposal-title">Excelencia Académica</h4>
                    <p class="proposal-text">
                        Garantizamos un nivel educativo competitivo y con resultados sobresalientes.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="proposal-card">
                    <i class="bi bi-heart text-primary proposal-icon"></i>
                    <h4 class="proposal-title">Educación Integral</h4>
                    <p class="proposal-text">
                        Formamos a los estudiantes en aspectos académicos, éticos y emocionales.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
	footerColegio($data);
 ?>