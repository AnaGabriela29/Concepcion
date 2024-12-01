let tableAulas; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){


	tableAulas = $('#tableAulas').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Aulas/getAulas",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_aula"},
            {"data":"nombre"},
            {"data":"descripcion"},
            {"data":"status"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    //NUEVO Aula
    let formAula = document.querySelector("#formAula");
    formAula.onsubmit = function(e) {
        e.preventDefault();
    
        let intIdAula = document.querySelector('#idAula').value;
        let strNombre = document.querySelector('#txtNombreAula').value;
        let strDescripcion = document.querySelector('#txtDescripcionAula').value;
        let intStatus = document.querySelector('#listStatus').value;        
        if (strNombre == '' || strDescripcion == '' || intStatus == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        // divLoading.style.display = "flex";
        let ajaxUrl = base_url + '/Aulas/setAula'; 
        let formData = new FormData(formAula);
    
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(objData => {
            if (objData.status) {
                $('#modalFormAula').modal("hide");
                formAula.reset();
                Swal.fire("Aulas de unimat", objData.msg, "success");
                tableAulas.ajax.reload();  // Asegúrate de que esta línea corresponde a cómo has inicializado DataTables.
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
            // divLoading.style.display = "none";
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire("Error", "No se pudo procesar la solicitud.", "error");
            // divLoading.style.display = "none";
        });
    
        return false;
    }   
});


$('#tableAulas').DataTable();

function openModal(){

    document.querySelector('#idAula').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Aula";
    document.querySelector("#formAula").reset();
	$('#modalFormAula').modal('show');
}

window.addEventListener('load', function() {
    /*fntEditAula();
    fntDelAula();
    fntPermisos();*/
}, false);

function fntEditAula(idaula) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Aula";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let ajaxUrl = base_url + '/Aulas/getAula/' + idaula;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            document.querySelector("#idAula").value = objData.data.id_aula;
            document.querySelector("#txtNombreAula").value = objData.data.nombre;
            document.querySelector("#txtDescripcionAula").value = objData.data.descripcion;
            let optionSelect = objData.data.status == 1
                ? '<option value="1" selected class="notBlock">Activo</option><option value="2" class="notBlock">Inactivo</option>'
                : '<option value="2" selected class="notBlock">Inactivo</option><option value="1" class="notBlock">Activo</option>';
            document.querySelector("#listStatus").innerHTML = optionSelect;
            $('#modalFormAula').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información del aula.", "error");
    });
}

function fntDelAula(idaula) {
    Swal.fire({
        title: 'Eliminar Aula',
        text: "¿Realmente quiere eliminar el Aula?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            let ajaxUrl = base_url + '/Aulas/delAula/';
            let strData = new URLSearchParams({ idaula: idaula });

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
                    tableAulas.ajax.reload(); // Asegúrate de que esta línea corresponde a cómo has inicializado DataTables.
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



function fntViewAula(idaula) {
    let ajaxUrl = base_url + '/Aulas/getAula/' + idaula;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            let estadoAula = objData.data.status == 1 ? 
                '<span class="badge bg-success">Activo</span>' : 
                '<span class="badge bg-danger">Inactivo</span>';

            document.querySelector("#celNombreAula").innerHTML = objData.data.nombre;
            document.querySelector("#celDescripcionAula").innerHTML = objData.data.descripcion;
            document.querySelector("#celEstadoAula").innerHTML = estadoAula;
            $('#modalViewAula').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información del aula.", "error");
    });
}
