let tableGrados; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){


	tableGrados = $('#tableGrados').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Grados/getGrados",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_grado"},
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

    //NUEVO ROL
    let formGrado = document.querySelector("#formGrado");
    formGrado.onsubmit = function(e) {
        e.preventDefault();
    
        let intIdGrado = document.querySelector('#idGrado').value;
        let strNombre = document.querySelector('#txtNombreGrado').value;
        let strDescripcion = document.querySelector('#txtDescripcionGrado').value;
        let intStatus = document.querySelector('#listStatus').value;
        if (strNombre == '' || strDescripcion == '' || intStatus == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        // divLoading.style.display = "flex";
        let ajaxUrl = base_url + '/Grados/setGrado';
        let formData = new FormData(formGrado);
    
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(objData => {
            if (objData.status) {
                $('#modalFormGrado').modal("hide");
                formGrado.reset();
                Swal.fire("Grados de usuario", objData.msg, "success");
                tableGrados.ajax.reload();
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
    };
    

});

$('#tableGrados').DataTable();

function openModal(){

    document.querySelector('#idGrado').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Grado";
    document.querySelector("#formGrado").reset();
	$('#modalFormGrado').modal('show');
}

window.addEventListener('load', function() {
    /*fntEditRol();
    fntDelRol();
    fntPermisos();*/
}, false);

function fntEditGrado(idgrado) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Grado";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let ajaxUrl = base_url + '/Grados/getGrado/' + idgrado;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            document.querySelector("#idGrado").value = objData.data.id_grado;
            document.querySelector("#txtNombreGrado").value = objData.data.nombre;
            document.querySelector("#txtDescripcionGrado").value = objData.data.descripcion;
            let optionSelect = objData.data.status == 1
                ? '<option value="1" selected class="notBlock">Activo</option><option value="2" class="notBlock">Inactivo</option>'
                : '<option value="2" selected class="notBlock">Inactivo</option><option value="1" class="notBlock">Activo</option>';
            
            document.querySelector("#listStatus").innerHTML = optionSelect;
            $('#modalFormGrado').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información del grado.", "error");
    });
}



function fntViewGrado(idgrado) {
    let ajaxUrl = base_url + '/Grados/getGrado/' + idgrado;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            document.querySelector("#celNombreGrado").innerHTML = objData.data.nombre;
            document.querySelector("#celDescripcionGrado").innerHTML = objData.data.descripcion;
            document.querySelector("#celEstadoGrado").innerHTML = objData.data.status == 1 ? 
                '<span class="badge bg-success">Activo</span>' : 
                '<span class="badge bg-danger">Inactivo</span>';
                
            $('#modalViewGrado').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información del grado.", "error");
    });
}


function fntDelGrado(idgrado) {
    Swal.fire({
        title: 'Eliminar Grado',
        text: "¿Realmente quiere eliminar el Grado?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            let ajaxUrl = base_url + '/Grados/delGrado/';
            let strData = new URLSearchParams({ idgrado: idgrado });

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
                    tableGrados.ajax.reload();
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

