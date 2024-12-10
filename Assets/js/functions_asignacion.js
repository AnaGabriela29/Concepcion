let tableAsignaciones;
let idAula;
let idCurso;
let idGrado;
//seleccionar los box
mostrarSpinner();
document.addEventListener('DOMContentLoaded', function(){
    ocultarSpinner();
    if(document.querySelectorAll('.box-aula')){
    document.querySelectorAll('.box-aula').forEach(function(aula){
        aula.addEventListener('click', function(event) {
            // Desseleccionar todas las cajas
            document.querySelectorAll('.box-aula').forEach(function(otraAula) {
                if (otraAula !== aula) {
                    otraAula.classList.remove('select-box-asiganacion');
                }
            });    
            // Seleccionar la caja actual
            if (!this.classList.contains('select-box-asiganacion')) {
                this.classList.add('select-box-asiganacion');
            }
            idAula = this.querySelector('span').dataset.id;            
        });
    });
    }
    if(document.querySelectorAll('.box-curso')){
    document.querySelectorAll('.box-curso').forEach(function(curso){
        curso.addEventListener('click', function() {        
        // Desseleccionar todas las cajas
        document.querySelectorAll('.box-curso').forEach(function(otroCurso) {
            if (otroCurso !== curso) {
                otroCurso.classList.remove('select-box-asiganacion');
            }
        });
        // Seleccionar la caja actual
        if (!this.classList.contains('select-box-asiganacion')) {
            this.classList.add('select-box-asiganacion');
        }

        idCurso = this.querySelector('span').dataset.id;
        })
    })
    }
    if(document.querySelectorAll('.box-grado')){
    document.querySelectorAll('.box-grado').forEach(function(grado){
        grado.addEventListener('click', function() {
        // Desseleccionar todas las cajas
        document.querySelectorAll('.box-grado').forEach(function(otroGrado) {
            if (otroGrado !== grado) {
                otroGrado.classList.remove('select-box-asiganacion');
            }
        });
        // Seleccionar la caja actual
        if (!this.classList.contains('select-box-asiganacion')) {
            this.classList.add('select-box-asiganacion');        }

        idGrado = this.querySelector('span').dataset.id;       
        })
    })
    }
    // boton asignar
    if(document.querySelector('.btnIrAsignar')){
        document.querySelector('.btnIrAsignar').addEventListener('click', function(){
            let gradoBoolean=false;
            let cursoBoolean=false;
            let aulaBoolean=false;

            document.querySelectorAll('.box-grado').forEach(function(grado) {               
                    if(grado.classList.contains('select-box-asiganacion')){
                        gradoBoolean=true;
                    };                
            });
            document.querySelectorAll('.box-aula').forEach(function(aula) {               
                if(aula.classList.contains('select-box-asiganacion')){
                    aulaBoolean=true;
                };                
            });
            document.querySelectorAll('.box-curso').forEach(function(curso) {               
            if(curso.classList.contains('select-box-asiganacion')){
                cursoBoolean=true;
            };                
            });
            
            if (cursoBoolean === true && aulaBoolean === true && gradoBoolean === true) {
                window.location.href = base_url + "/Asignacion/asignarUsuario/" + idAula + "/" + idGrado + "/" + idCurso;
            } else {
                Swal.fire("Atención", "Seleccione todas las opciones", "error");
            }
            
        })
    }
})

// let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector('.dataAula')){
        idAula=document.querySelector('.dataAula').dataset.id;
    }
    if(document.querySelector('.dataGrado')){
        idGrado=document.querySelector('.dataGrado').dataset.id;
    }
    if(document.querySelector('.dataCurso')){
        idCurso=document.querySelector('.dataCurso').dataset.id;
    }
    tableAsignaciones = $('#tableAsignaciones').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Asignacion/getAsignaciones/"+ idAula + "/" + idGrado + "/" + idCurso,
            "dataSrc":""
        },
        "columns":[
            {"data":"id_asignacion"},
            {"data":"identificacion"},
            {"data":"nombres_usuario"},
            {"data":"apellidos_usuario"},
            {"data":"nombre_rol"},                      
            {"data":"status"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='bi bi-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary  m-2 rounded"
            },{
                "extend": "excelHtml5",
                "text": "<i class='bi bi-file-earmark-excel'></i> Excel",
                "titleAttr":"Exportar a Excel ",
                "className": "btn btn-success  m-2 rounded"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='bi bi-file-earmark-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger  m-2 rounded"
            },{
                "extend": "csvHtml5",
                "text": "<i class='bi bi-filetype-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info text-white m-2 rounded"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });    
   
    //NUEVA ASIGNACION
    let formAsignacion = document.querySelector("#formAsignacion");
    formAsignacion.onsubmit = function(e) {
        e.preventDefault();
    
        let intIdAsignacion = document.querySelector('#idAsignacion').value;
        let strUsuario = document.querySelector('#listaUsuarios').value;
        let intStatus = document.querySelector('#listStatus').value;
    
        if (strUsuario == '' || intStatus == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        // divLoading.style.display = "flex";
        let ajaxUrl = base_url + '/Asignacion/setAsignacion/' + idAula + "/" + idGrado + "/" + idCurso; // Ensure URL is correct
        let formData = new FormData(formAsignacion);
        mostrarSpinner();
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(objData => {
            if (objData.status) {
                $('#modalFormAsignacion').modal("hide");
                formAsignacion.reset();
                Swal.fire("Asignaciones de usuarios", objData.msg, "success");
                tableAsignaciones.ajax.reload();
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
            ocultarSpinner();
        })
        .catch(error => {
           
            ocultarSpinner();
            Swal.fire("Error", "No se pudo procesar la solicitud.", "error");
           
        });
    
        return false;
    };
    


});



$('#tableAsignaciones').DataTable();
function getDataList() {
    $(document).ready(function () {
        $('#listaUsuarios').select2({
            width: '100%',
            dropdownParent: $('#modalFormAsignacion'),
            ajax: {
                url: '/concepcion/Asignacion/getUsuarios',
                dataType: 'json',
                delay: 250, // Retarda la búsqueda para no hacer demasiadas solicitudes
                processResults: function (data) {    
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.id_usuario,
                                text: item.nombres
                            };
                        })
                    };
                },
                cache: true  // Almacena en caché para no hacer nuevas solicitudes repetidas
            },
            templateResult: function (data) {
                if (data.loading) {
                    return data.text;
                }
                return data.text;
            },
            templateSelection: function (data) {
                return data.text || data.id;
            }
        });
    
    });
    
}


function openModal(){

    document.querySelector('#idAsignacion').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Asignación ";
    document.querySelector("#formAsignacion").reset();
    document.querySelector("#selectNombreUsuario").textContent="";  
    
	$('#modalFormAsignacion').modal('show');
    getDataList();
}

window.addEventListener('load', function() {
    /*fntEditCURSO();
    fntDelCURSO();
    fntPermisos();*/
}, false);

function fntEditAsignacion(idAsignacion) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Asignación";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let ajaxUrl = base_url + '/Asignacion/getAsignacion/' + idAsignacion;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            document.querySelector('#idAsignacion').value = objData.data.id_asignacion;
            document.querySelector('#selectNombreUsuario').textContent = objData.data.identificacion + " " + objData.data.nombres_usuario + " " + objData.data.apellidos_usuario;

            let optionSelect = objData.data.status == 1
                ? '<option value="1" selected class="notBlock">Activo</option><option value="2" class="notBlock">Inactivo</option>'
                : '<option value="2" selected class="notBlock">Inactivo</option><option value="1" class="notBlock">Activo</option>';

            document.querySelector("#listStatus").innerHTML = optionSelect;
            $('#modalFormAsignacion').modal('show');
            getDataList(); // Ensure this function is defined and properly updates relevant data.
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información de la asignación.", "error");
    });
}


function fntViewAsignacion(idAsignacion) {
    let ajaxUrl = base_url + '/Asignacion/viewAsignacion/' + idAsignacion;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            document.querySelector("#celNombreUsuario").innerHTML = objData.data.nombres_usuario;
            document.querySelector("#celApellidoUsuario").innerHTML = objData.data.apellidos_usuario;
            document.querySelector("#celNombreRol").innerHTML = objData.data.nombre_rol;
            document.querySelector("#celNombreAula").innerHTML = objData.data.nombre_aula;
            document.querySelector("#celNombreCurso").innerHTML = objData.data.nombre_curso;
            document.querySelector("#celNombreGrado").innerHTML = objData.data.nombre_grado;
            document.querySelector("#celPeriodo").innerHTML = objData.data.nombre_periodo;
            document.querySelector("#celFecha").innerHTML = objData.data.date_created + " / " + objData.data.date_modificated;
            document.querySelector("#celEstado").innerHTML = objData.data.status == 1 ?
                '<span class="badge bg-success">Activo</span>' : 
                '<span class="badge bg-danger">Inactivo</span>';
                
            $('#modalViewAsignacion').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información de la asignación.", "error");
    });
}



function fntDelAsignacion(idAsignacion) {
    Swal.fire({
        title: 'Eliminar Asignación',
        text: "¿Realmente quiere eliminar la asignación?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            let ajaxUrl = base_url + '/Asignacion/delAsignacion/';
            let strData = new URLSearchParams({idAsignacion: idAsignacion});

            fetch(ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: strData
            })
            .then(response => response.json())
            .then(objData => {
                if (objData.status) {
                    Swal.fire('Eliminar!', objData.msg, 'success');
                    tableAsignaciones.ajax.reload();
                } else {
                    Swal.fire('Atención!', objData.msg, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
            });
        }
    });
}

