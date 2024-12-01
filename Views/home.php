<?php
headerColegio($data);
require_once 'Views/Colegio/chatbot.php';
?>
<section class="section-slide">
	<div id="carouselExampleIndicators" class="carousel slide">
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
		</div>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="<?= media() ?>/colegio/images/imagenref_large.jpg" class="d-block w-100 img-fluid object-fit-cover carrusel" alt="Imagen del colegio">
			</div>
			<div class="carousel-item">
				<img src="<?= media() ?>/colegio/images/imagen_mobil.jpg" class="d-block w-100 img-fluid object-fit-cover" alt="Imagen del colegio">
			</div>
			<div class="carousel-item">
				<img src="<?= media() ?>/colegio/images/imagen_mobil.jpg" class="d-block w-100 img-fluid object-fit-cover" alt="Imagen del colegio">
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
</section>

<section class="section-proposal my-4 py-4 bg-light">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12 col-md-6 text-center text-md-start">
				<p class="fs-5">
					En colegio <strong>UNIMAT</strong> potenciamos las competencias de los estudiantes, formando líderes con valores y visión de futuro preparados para enfrentar un mundo en constante cambio.
					<br><br>
					Nuestro innovador sistema propone un enfoque educativo cíclico y gradual, mediante técnicas y procesos de mejora continua, sobre la base de una educación integral de alto rendimiento.
				</p>
			</div>
			<div class="col-12 col-md-6">
				<img src="<?= media() ?>/colegio/images/imagen_mobil.jpg" class="img-fluid rounded shadow" alt="Propuesta educativa">
			</div>
		</div>
	</div>
</section>

<section class="section-news-recent py-4">
	<div class="container">
		<h3 class="text-center mb-4">Últimas noticias</h3>
		<div class="row">
			<div class="col-12 col-md-6 mx-auto">
				<div class="border rounded bg-light p-3 shadow">
					<h4 class="text-center">Lorem ipsum dolor sit amet consectetur</h4>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto eos voluptatibus maxime blanditiis tempore ab inventore ipsa voluptatem rerum facere? Quaerat ad saepe et praesentium ex facere in soluta dicta.</p>
					<img src="<?= media() ?>/colegio/images/imagen_mobil.jpg" class="img-fluid rounded mb-2" alt="Noticias del colegio UNIMAT">
					<small class="text-muted d-block text-end">21/12/2024</small>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section-ubication my-4 py-4 bg-primary text-white">
	<div class="container">
		<div class="text-center">
			<h3>Ubícanos en la siguiente dirección</h3>
			<p class="mb-4">Av. 28 de Julio 665, San Vicente de Cañete 15701</p>
			<a href="<?= base_url() ?>/colegio/contactanos" class="btn btn-light btn-lg">Ver dirección</a>
		</div>
	</div>
</section>

<?php
footerColegio($data);
?>