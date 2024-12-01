let tableControlasistencia  ; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){


	tableControlasistencia = $('#tableControlasistencia').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Controlasistencia/getAsistencias",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_asistencia"},
            {"data":"identificacion"},
            {"data":"fecha_hora"},
            {"data":"estado_asistencia"},
            {"data":"observaciones"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='bi bi-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary  m-2 rounded",
                "exportOptions": {
                    "modifier": {
                        "selected": null // Para asegurarse de que todas las filas estén seleccionadas para copiar
                    },
                    "columns": [1, 2, 3] // Índices de las columnas 
                }
            },{
                "extend": "excelHtml5",
                "text": "<i class='bi bi-file-earmark-excel'></i> Excel",
                "titleAttr":"Exportar a Excel ",
                "className": "btn btn-success  m-2 rounded",
                "exportOptions": {
                    "modifier": {
                        "selected": null // Para asegurarse de que todas las filas estén seleccionadas para copiar
                    },
                    "columns": [1, 2, 3] // Índices de las columnas 
                }
            },{
                "extend": "pdfHtml5",
                "text": "<i class='bi bi-file-earmark-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger  m-2 rounded",
                "exportOptions": {
                    "modifier": {
                        "selected": null // Para asegurarse de que todas las filas estén seleccionadas para copiar
                    },
                    "columns": [1, 2, 3] // Índices de las columnas 
                }
            },{
                "extend": "csvHtml5",
                "text": "<i class='bi bi-filetype-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info text-white m-2 rounded",
                "exportOptions": {
                    "modifier": {
                        "selected": null // Para asegurarse de que todas las filas estén seleccionadas para copiar
                    },
                    "columns": [1, 2, 3] // Índices de las columnas 
                }
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    //NUEVO Asistencia
    let formControlasistencia = document.querySelector("#formControlasistencia");
    formControlasistencia.onsubmit = function(e) {
        e.preventDefault();
    
        let intIdAsistencia = document.querySelector('#idAsistencia').value;
        let strNumerodni = document.querySelector('#txtNumerodni').value;
        let strFechaRegistro = document.querySelector('#txtFechaRegistro').value;
        let strObservacion = document.querySelector('#txtObservacion').value;
        
        if (strNumerodni == '' || strFechaRegistro == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        // divLoading.style.display = "flex";
        let ajaxUrl = base_url + '/Controlasistencia/setAsistencia'; 
        let formData = new FormData(formControlasistencia);
    
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(objData => {
            if (objData.status) {
                $('#modalformControlasistencia').modal("hide");
                formControlasistencia.reset();
                tableControlasistencia.ajax.reload();
                Swal.fire("Control asistencia de unimat", objData.msg, "success");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire("Error", "No se pudo procesar la solicitud.", "error");
        });
    
        return false;
    }
    

});

$('#tablaControlasistencia').DataTable();

function openModal(){

    document.querySelector('#idAsistencia').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Asistencia";
    document.querySelector("#formControlasistencia").reset();
	$('#modalformControlasistencia').modal('show');
}

window.addEventListener('load', function() {
    /*fntEditAula();
    fntDelAula();
    fntPermisos();*/
}, false);

function fntEditAsistencia(idAsistencia) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Asistencia";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let ajaxUrl = base_url + '/Controlasistencia/getAsistencia/' + idAsistencia;

    fetch(ajaxUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(objData => {
        if (objData.status) {
            let fechaHora = new Date(objData.data.fecha_hora);
            // Format the date and time for datetime-local input
            let fecha = fechaHora.toISOString().split('T')[0];
            let hora = fechaHora.toTimeString().split(' ')[0].slice(0, 5); // Gets only the hour and minutes (HH:mm)

            document.querySelector("#idAsistencia").value = objData.data.id_asistencia;
            document.querySelector("#txtNumerodni").value = objData.data.identificacion;
            document.querySelector("#txtFechaRegistro").value = fecha + 'T' + hora;
            document.querySelector("#txtObservacion").value = objData.data.observaciones;
            document.querySelector("#txtEstadoAsistencia").value= objData.data.estado_asistencia;

            $('#modalformControlasistencia').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información de la asistencia.", "error");
    });
}


function fntDelAsistencia(idAsistencia) {
    Swal.fire({
        title: 'Eliminar Asistencia',
        text: "¿Realmente quiere eliminar la Asistencia?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            let ajaxUrl = base_url + '/Controlasistencia/delAsistencia/';
            let strData = new URLSearchParams({ idasistencia: idAsistencia });

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
                    tableControlasistencia.ajax.reload();
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


function fntViewAsistencia(idAsistencia) {
    let ajaxUrl = base_url + '/Controlasistencia/getAsistencia/' + idAsistencia;

    fetch(ajaxUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(objData => {
        if (objData.status) {
            document.querySelector("#celNombredni").innerHTML = objData.data.identificacion;
            document.querySelector("#celFechaRegistro").innerHTML = objData.data.fecha_hora;
            document.querySelector("#celNombreApellidos").innerHTML = objData.data.nombre;
            document.querySelector("#celEstado").innerHTML= objData.data.estado_asistencia;
            document.querySelector("#celObservaciones").innerHTML = objData.data.observaciones;
            $('#modalViewAsistencia').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información de la asistencia.", "error");
    });
}
