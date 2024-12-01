<?php 
	headerColegio($data);
    require_once 'Views/Colegio/chatbot.php';
 ?>
<section class="section-contact py-5">
    <div class="container">
        <div class="row mb-5">
            <!-- Información de contacto -->
            <div class="info-contacto col-12 col-md-6 d-flex justify-content-center align-items-start flex-column text-start">
                <h4 class="text-primary fw-bold mb-4">Información de Contacto</h4>
                <p class="mb-3"><i class="bi bi-telephone-fill mx-2 text-success"></i><strong>WhatsApp:</strong> <?=WHATSAPP?></p>
                <p class="mb-3"><i class="bi bi-envelope-at-fill mx-2 text-warning"></i><strong>Correo Electrónico:</strong> <?=EMAIL_EMPRESA?></p>
                <p class="mb-3"><i class="bi bi-geo-alt-fill mx-2 text-danger"></i><strong>Dirección:</strong> <?=DIRECCION?></p>
            </div>

            <!-- Formulario de contacto -->
            <div class="col-12 col-md-6">
                <form id="frmContacto" class="border rounded p-4 bg-light shadow-sm">
                    <h4 class="text-center text-primary fw-bold mb-4">Enviar un Mensaje</h4>

                    <div class="mb-3">
                        <label for="nombreContacto" class="form-label"><i class="bi bi-person-arms-up mx-1"></i>Nombre:</label>
                        <input class="form-control" type="text" id="nombreContacto" name="nombreContacto" placeholder="Escribe tu nombre completo" required>
                    </div>

                    <div class="mb-3">
                        <label for="whatsappContacto" class="form-label"><i class="bi bi-whatsapp mx-1 text-success"></i>WhatsApp:</label>
                        <input class="form-control" type="number" id="whatsappContacto" name="whatsappContacto" placeholder="Tu número de WhatsApp" required>
                    </div>

                    <div class="mb-4">
                        <label for="mensaje" class="form-label"><i class="bi bi-envelope-check-fill mx-1"></i>Mensaje:</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje o consulta" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Enviar Mensaje</button>
                </form>
            </div>
        </div>

        <!-- Mapa -->
        <div class="text-center">
            <h4 class="fw-bold mb-4">Estamos Ubicados en:</h4>
            <div class="map-container rounded overflow-hidden shadow">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d971.5531830628703!2d-76.38839612613074!3d-13.08570006355721!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910ff9354f2fd5f1%3A0x50e0a621f52ae432!2sUnimat%20Colegio!5e0!3m2!1ses-419!2spe!4v1710131564110!5m2!1ses-419!2spe" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

<?php 
	footerColegio($data);
 ?>