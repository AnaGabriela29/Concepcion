<!-- Modal -->
<div class="modal fade" id="modalFormAsignacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Asignacion del Aula</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">
                <form id="formAsignacion" name="formAsignacion" class="form-horizontal row">
                    <input type="hidden" id="idAsignacion" name="idAsignacion" value="">
                               
                    <p class=" col-12">Asignar al aula: <?=$data['Aula']['nombre']?>, curso: <?=$data['Curso']['nombre']?>, grado: <?=$data['Grado']['nombre']?>, </p>
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="listaUsuarios">Nombre del Usuario: <span id="selectNombreUsuario"> </span></label>
                                <select id="listaUsuarios" class="form-control" name="listaUsuarios">
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="listStatus">Estado</label>
                                <select class="form-control" id="listStatus" name="listStatus" required="">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>                   

                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewAsignacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos de la asignación</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nombre del Usuario:</td>
                            <td id="celNombreUsuario"></td>
                        </tr>
                        <tr>
                            <td>Apellidos del Usuario:</td>
                            <td id="celApellidoUsuario"></td>
                        </tr>
                        <tr>
                            <td>Nombre del rol:</td>
                            <td id="celNombreRol"></td>
                        </tr>
                        <tr>
                            <td>Nombre del Aula:</td>
                            <td id="celNombreAula"></td>
                        </tr>
                        
                        <tr>
                            <td>Nombre del curso:</td>
                            <td id="celNombreCurso"></td>
                        </tr>
                        <tr>
                            <td>Nombre del grado:</td>
                            <td id="celNombreGrado"></td>
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