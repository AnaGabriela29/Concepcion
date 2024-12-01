<?php 
	headerColegio($data);
 ?>

<section class="section_collaborators_header">
    <div class="header_collaborators">
        <h3 class="text-center my-4">Nuestro Equipo</h3>
        <p class="collaborators-description text-center">En el Colegio UNIMAT, nos enorgullece contar con un equipo de colaboradores dedicados y comprometidos que trabajan incansablemente para brindar una educación de calidad y un ambiente de aprendizaje enriquecedor para nuestros estudiantes. Con una combinación de experiencia, pasión y dedicación, nuestros colaboradores son la piedra angular de nuestra comunidad educativa.</p>
    </div>
</section>

<section class="section_collaborators_body">
    <div class="section_directory">
        <div class="container">
            <div class="text-center">
                <p class="my-3 section-title">Directivos</p>
            </div>
            <div class="row g-4">
                <!-- Card de Colaborador -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="team-card">
                        <img src="<?=media()?>/colegio/images/imagen_mobil.jpg" alt="Colaborador del colegio unimat" class="img-fluid rounded-top">
                        <div class="team-card-body">
                            <h5 class="team-card-title">Director General</h5>
                            <p class="team-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                    </div>
                </div>
                <!-- Repite las cards según sea necesario -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="team-card">
                        <img src="<?=media()?>/colegio/images/imagen_mobil.jpg" alt="Colaborador del colegio unimat" class="img-fluid rounded-top">
                        <div class="team-card-body">
                            <h5 class="team-card-title">Subdirector Académico</h5>
                            <p class="team-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php 
	footerColegio($data);
 ?>