<?php 
	headerColegio($data);
 ?>

<section class="section-news">
    <div>
        <h3 class="text-center my-4 text-primary fw-bold">Noticias y eventos UNIMAT</h3>
    </div>
    <div class="container">
        <div class="row g-4">
            <!-- Tarjetas de noticias -->
            <div class="contain-new col-12 col-md-6 col-lg-4">
                <div class="news-card border rounded shadow-lg position-relative">
                    <img src="<?=media()?>/colegio/images/imagen_mobil.jpg" class="img-fluid rounded-top" alt="noticias del colegio unimat">
                    <div class="news-content p-3">
                        <h4 class="text-center fw-semibold">Lorem ipsum dolor sit amet consectetur</h4>
                        <p class="text-muted">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eos voluptatibus maxime blanditiis tempore ab inventore ipsa voluptatem rerum facere.
                        </p>
                        <small class="text-muted d-block text-end">21/12/2024</small>
                    </div>
                </div>
            </div>

            <!-- Repite los bloques de noticias -->
            <div class="contain-new col-12 col-md-6 col-lg-4">
                <div class="news-card border rounded shadow-lg position-relative">
                    <img src="<?=media()?>/colegio/images/imagen_mobil.jpg" class="img-fluid rounded-top" alt="noticias del colegio unimat">
                    <div class="news-content p-3">
                        <h4 class="text-center fw-semibold">Lorem ipsum dolor sit amet consectetur</h4>
                        <p class="text-muted">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eos voluptatibus maxime blanditiis tempore ab inventore ipsa voluptatem rerum facere.
                        </p>
                        <small class="text-muted d-block text-end">21/12/2024</small>
                    </div>
                </div>
            </div>

            <!-- Agrega más noticias según sea necesario -->
        </div>
    </div>
</section>


<?php 
	footerColegio($data);
 ?>