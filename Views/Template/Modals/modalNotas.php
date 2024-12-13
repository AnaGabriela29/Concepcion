<!-- Modal -->
<div class="modal fade" id="modalFormNotas" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Notas Concepcion</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">
                <form id="formNotas" name="formNotas" class="form-horizontal row">
                    <input type="hidden" id="csrf" class="csrf" name="csrf" value="<?php echo $data['token']?>">
                    <input type="hidden" id="idNota" name="idNota" value="">     
                    <input type="hidden" id="idCurso" name="idCurso" value="<?=$data['Curso']['id_curso']?>">                         
                    <div class="box-competencias row">
                    <input type="hidden" id="competenciaSeleccionada" name="competenciaSeleccionada" value="">

                        <?php 
                        // Verificamos si hay competencias y las mostramos
                        if (!empty($data['competencias'])):
                            foreach ($data['competencias'] as $competencia): ?>
                                <div class="p-2 col-6 col-md-4">
                                <div class="competencia-item mb-3 rounded bg-color-white text-black" 
                                    data-id="<?php echo $competencia['id_competencia']; ?>" 
                                    onclick="selectCompetencia(this)">
                                    <h6 class="fw-bold"><?php echo htmlspecialchars($competencia['nombre_competencias']); ?></h6>
                                    <input type="hidden" name="competencias[<?php echo $competencia['id_competencia']; ?>]" value="<?php echo $competencia['id_competencia']; ?>">
                                </div>
                                </div>
                                
                            <?php endforeach;
                        endif; ?>
                    </div>

                    <div class="row">
                        <div class="box-nota-aux d-flex flex-column col-12 col-md-6 mb-3">
                            <label for="listaAlumnos">Nombre de la Alumna: <span id="selectNombreAlumno"> </span></label>
                            <select id="listaAlumnos" class="listaAlumnos" name="listaAlumnos">                       
                        </select>
                        </div>
                        <div class="box-nota-aux d-flex flex-column col-12 col-md-6 mb-3">
                            <label for="listaDocentes">Nombre del Docente: <span id="selectNombreDocente"> </span></label>
                            <select id="listaDocentes" class="listaDocentes" name="listaDocentes">                       
                        </select>
                        </div> 
                                        
                        <div class=" d-flex flex-column col-12 col-md-6 mb-3">
                            <label for="nota">Nota</label>
                            <input id="nota" type="number" min="0" max="20" class="nota" name="nota" value="">                       
                            </input>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="tema">Escriba el tema</label>
                            <input type="text" id="tema" name="tema" class="form-control" placeholder="escriba el tema" >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="selectbimestres fw-bold">Elija un bimestre</label>
                            <select class="form-select" name="bimestres" id="selectBimestres">
                                <option value="">--Seleccione un bimestre--</option>
                                <option value="primerbimestre" selected>primer bimestre</option>
                                <option value="segundobimestre">segundo bimestre</option>
                                <option value="tercerbimestre">tercer bimestre</option>
                                <option value="cuartobimestre">cuarto bimestre</option>                
                            </select>
                        </div>                                                  

                        <div class="form-group d-flex flex-column col-12 col-md-6 col-md-4 mb-3">
                            <label for="exampleSelect1">Estado</label>
                            <select class="form-control" id="listStatus" name="listStatus" required="">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    

                    <div class="tile-footer text-center">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewNota" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos de la nota del alumno</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nombre del alumno:</td>
                            <td id="celNombresAlumno"></td>
                        </tr>
                        <tr>
                            <td>Nombres del Docente:</td>
                            <td id="celNombresDocente"></td>
                        </tr>                        
                        <tr>
                            <td>Nota 1:</td>
                            <td id="celNota1"></td>
                        </tr>
                        <tr>
                            <td>Nota 2:</td>
                            <td id="celNota2"></td>
                        </tr>
                        <tr>
                            <td>Nota 3:</td>
                            <td id="celNota3"></td>
                        </tr>
                        <tr>
                            <td>Nota 4:</td>
                            <td id="celNota4"></td>
                        </tr>                        
                        <tr>
                            <td>Periodo:</td>
                            <td id="celPeriodo"></td>
                        </tr>
                        <tr>
                            <td>Fecha de creacion - Fecha de ultima Modificacion:</td>
                            <td id="celFecha"></td>
                        </tr>
                        <tr>
                            <td>Estado:</td>
                            <td id="celEstado"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>