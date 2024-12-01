<?php headerAdmin($data); ?>
<style>
  #calendar {
    width: 100%;

}
</style>

<script src='<?=media()?>/js/plugins/index.global.min.js'></script>


<section>
  <div class="d-flex justify-content-between my-4">
    <h5>Bienvenido <?= $_SESSION['userData']['nombres']; ?>, vizualiza tu asistencia</h5>
    <button id="whatsapp-button" class="btn btn-success">Enviar mensaje por WhatsApp <i class="bi bi-whatsapp"></i></button>
  </div>
  <div class="row">
    <div class="col-12 col-xl-7">
      <div id='calendar' class="w-100"></div>
    </div>
    <div class="col-12 col-xl-5">
      
      <div class=" " >
        <table class="table d-none tablaNotaAlumno">
          <thead>
            <tr>
              <th scope="col">Curso</th>
              <th scope="col">Nota 1</th>
              <th scope="col">Nota 2</th>
              <th scope="col">Nota 3</th>
              <th scope="col">Nota 4</th>
              <th scope="col">Promedio</th>
            </tr>
          </thead>
          <tbody id="notas-body">
          </tbody>
        </table>
        <table class="table d-none tablaPagoAlumno bg-color-gray-light rounded">
          <thead>
            <tr>
              <th scope="col">Concepto de pago</th>
              <th scope="col">Fecha de pago</th>
              <th scope="col">Monto pagado</th>
              <th scope="col">Observaciones</th>
              <th scope="col">Mes</th>
            </tr>
          </thead>
          <tbody id="pagos-body">
          </tbody>
        </table>
      </div>

    </div>
  </div>
</section>
<section class="pays-students">

</section>



    
<script>
document.addEventListener('DOMContentLoaded', function() {
  const calendarEl = document.getElementById('calendar')
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    height: 'auto'
  })
  calendar.render()
  window.addEventListener('resize', function() {
    calendar.updateSize();  // Método de FullCalendar para actualizar el tamaño
});

document.querySelector(".btn").addEventListener('click', function() {    
    setTimeout(() => {
      if (document.getElementById('calendar')) {
            calendar.updateSize();
        }
    }, 300); // Ajusta el tiempo de acuerdo a la duración de cualquier animación del sidebar
});
})
</script>
<?php footerAdmin($data); ?>


    