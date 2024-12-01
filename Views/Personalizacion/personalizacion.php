<?php 
    headerAdmin($data); 
    // getModal('modalRoles',$data);    
?>
<section class="section-news">
    <div>
        <h6>Gestionar información de la pagina de noticias de la pagina home</h6>
    </div>

    <article class="app-content">
      <div class="app-title">
        <div>
            <h2><i class="fas fa-user-tag"></i>
              <?php if($_SESSION['permisosMod']['w']){ ?> 
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="bi bi-plus-circle"></i> Nuevo</button>
               <?php } ?> 
            </h2>
        </div>       
      </div>

        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableNews">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Titulo</th>
                          <th>Descripción</th>
                          <th>Fecha</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </article>
    


</section>
<section class="section-sliders">
    <div>
        <h6>Gestionar imagenes del sliders de la pagina home</h6>
    </div>

    <article class="app-content">
      <div class="app-title">
        <div>
            <h2><i class="fas fa-user-tag"></i>
              <?php if($_SESSION['permisosMod']['w']){ ?> 
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="bi bi-plus-circle"></i> Nuevo</button>
               <?php } ?> 
            </h2>
        </div>       
      </div>

        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableSliders">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>imagen</th>                          
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </article>

</section>

<?php 
    footerAdmin($data);     
?>