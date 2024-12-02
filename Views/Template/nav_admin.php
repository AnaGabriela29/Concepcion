 <!-- Sidebar -->
 <aside id="sidebar" class="bg-color-sky-blue">
     <div class="h-100 ">
         <div class="sidebar-logo d-flex justify-content-center bg-color-sky-blue">
             <a href="<?=base_url()?>"><img class="logotipo-img" src="<?=media()?>/images/logo_concepcion.webp" alt="logo unimat"></a>
         </div>

         <div class="d-flex justify-content-center align-items-center flex-column">
             <p class="app-sidebar__user-name m-0 gfs-didot-regular fw-bold color-gray"><?= $_SESSION['userData']['nombres']; ?></p>
             <p class="app-sidebar__user-designation m-0 gfs-didot-regular fw-bold color-gray"><?= $_SESSION['userData']['nombre'] == 'Alumno' ? $_SESSION['userData']['nombre'] : ""; ?></p>
         </div>

         <!-- Sidebar Navigation -->
         <ul class="sidebar-nav gfs-didot-regular bg-color-sky-blue">

             <li class="sidebar-item" ata-toggle="tooltip" title="Estamos trabajando en esta pagina">
                 
             </li>
             <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
                 <li class="sidebar-item">
                     <a href="<?= base_url() ?>/dashboard" class="sidebar-link color-gray">
                         <i class="bi bi-speedometer"></i>
                         Dashboard
                     </a>
                 </li>
             <?php } ?>
             <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
                 <li class="sidebar-item">
                     <a href="#" class="sidebar-link collapsed color-gray" data-bs-toggle="collapse" data-bs-target="#pages" aria-expanded="false" aria-controls="pages">
                         <i class="bi bi-people-fill"></i>
                         Usuarios
                     </a>
                     <ul id="pages" class="sidebar-dropdown list-unstyled collapse  " data-bs-parent="#sidebar">
                         <li class="sidebar-item color-gray">                             
                             <a href="<?= base_url() ?>/usuarios" class="sidebar-link color-gray"><i class="bi bi-person-fill ms-5"></i>Usuarios</a>
                         </li>
                         <li class="sidebar-item color-gray">                             
                             <a href="<?= base_url() ?>/roles" class="sidebar-link color-gray"><i class="bi bi-person-fill-lock ms-5 color-gray"></i> Roles</a>
                         </li>

                     </ul>
                 </li>
             <?php } ?>

             <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                            <li class="sidebar-item">
                                <a href="<?= base_url() ?>/alumnos" class="sidebar-link color-gray">
                                    <i class="bi bi-backpack2-fill"></i>
                                    Alumnas
                                </a>
                            </li>
            <?php } ?>
            <?php if (!empty($_SESSION['permisos'][6]['r']) || !empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][5]['r'])) { ?>    
                <li class="sidebar-item">
                     <a href="#" class="sidebar-link collapsed color-gray" data-bs-toggle="collapse" data-bs-target="#pagesCollegue" aria-expanded="false" aria-controls="pagesCollegue">
                         <i class="bi bi-people-fill"></i>
                         Colegio 
                     </a>
                     <ul id="pagesCollegue" class="sidebar-dropdown list-unstyled collapse  " data-bs-parent="#sidebar">
                        
                        <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
                            <li class="sidebar-item">
                                <a href="<?= base_url() ?>/cursos" class="sidebar-link color-gray">
                                    <i class="bi bi-journal-album"></i>
                                    Cursos
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
                            <li class="sidebar-item">
                                <a href="<?= base_url() ?>/grados" class="sidebar-link color-gray">
                                    <i class="bi bi-ladder"></i>
                                    Grados
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
                            <li class="sidebar-item">
                                <a href="<?= base_url() ?>/aulas" class="sidebar-link color-gray">
                                    <i class="bi bi-houses-fill"></i>
                                    Aulas
                                </a>
                            </li>
                        <?php } ?>

                     </ul>
                 </li>
            <?php } ?>    
            
             <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
                 <li class="sidebar-item">
                     <a href="<?= base_url() ?>/asignacion" class="sidebar-link color-gray">
                         <i class="bi bi-house-gear-fill"></i>
                         Asignación
                     </a>
                 </li>
             <?php } ?>

             <?php if (!empty($_SESSION['permisos'][8]['r'])) { ?>
                 <li class="sidebar-item">
                     <a href="<?= base_url() ?>/notas" class="sidebar-link color-gray">
                     <i class="bi bi-building-add"></i>
                         Notas
                     </a>
                 </li>
             <?php } ?>          
         </ul>
     </div>
 </aside>
 <!-- Main Component -->
 <div class="main">
     <header class="navbar navbar-expand px-3 border-bottom d-flex justify-content-between">
         <!-- Button for sidebar toggle -->
         <button class="btn" type="button" data-bs-theme="">
             <span class="navbar-toggler-icon "></span>
         </button>

         <div class="">
             <h2 class="fs-3 m-0">Colegio Concepcion</h2>
         </div>

         <!-- Default dropstart button -->
         <div class="btn-group dropstart">
            
             <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="bi bi-gear-fill"></i>
             </button>
             <ul class="dropdown-menu">
                 <!-- <li class="dropdown-item"><a href="<?= base_url() ?>/perfil">perfil</a></li> -->
                 <a class="dropdown-item" href="<?= base_url() ?>/logout"><i class="bi bi-backspace-fill mx-1 "></i>Salir</a>
<!--                  
                 <?php echo (RADMINISTRADOR == $_SESSION['userData']['id_rol']) ? '<li class="dropdown-item"><a href="' . base_url() . '/personalizacion">personalizacion</a></li>' : ''; ?> -->

             </ul>
         </div>


     </header>
     <main class="content px-3 py-2">
         <div class="container-fluid">
             <div class="mb-3">