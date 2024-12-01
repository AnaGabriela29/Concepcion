let tableCursos; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){


	tableCursos = $('#tableCursos').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Cursos/getCursos",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_curso"},
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

    //NUEVO CURSO
    let formCurso = document.querySelector("#formCurso");
    formCurso.onsubmit = function(e) {
        e.preventDefault();
    
        let intIdCurso = document.querySelector('#idCurso').value;
        let strNombre = document.querySelector('#txtNombreCurso').value;
        let strDescripcion = document.querySelector('#txtDescripcionCurso').value;
        let intStatus = document.querySelector('#listStatus').value;
        
        if (strNombre == '' || strDescripcion == '' || intStatus == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        // divLoading.style.display = "flex";
        let ajaxUrl = base_url + '/Cursos/setCURSO';
        let formData = new FormData(formCurso);
    
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(objData => {
            if (objData.status) {
                $('#modalFormCursos').modal("hide");
                formCurso.reset();
                Swal.fire("Cursos de alumno", objData.msg, "success");
                tableCursos.ajax.reload();
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

$('#tableCursos').DataTable();

function openModal(){

    document.querySelector('#idCurso').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Curso";
    document.querySelector("#formCurso").reset();
	$('#modalFormCursos').modal('show');
}


function fntEditCurso(idcurso) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Curso";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let ajaxUrl = base_url + '/Cursos/getCurso/' + idcurso;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            document.querySelector("#idCurso").value = objData.data.id_curso;
            document.querySelector("#txtNombreCurso").value = objData.data.nombre;
            document.querySelector("#txtDescripcionCurso").value = objData.data.descripcion;

            let optionSelect = objData.data.status == 1
                ? '<option value="1" selected class="notBlock">Activo</option><option value="2" class="notBlock">Inactivo</option>'
                : '<option value="2" selected class="notBlock">Inactivo</option><option value="1" class="notBlock">Activo</option>';
            
            document.querySelector("#listStatus").innerHTML = optionSelect;
            $('#modalFormCursos').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información del curso.", "error");
    });
}


function fntViewCurso(idcurso) {
    let ajaxUrl = base_url + '/Cursos/getCurso/' + idcurso;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            document.querySelector("#celNombreCurso").innerHTML = objData.data.nombre;
            document.querySelector("#celDescripcionCurso").innerHTML = objData.data.descripcion;
            document.querySelector("#celEstadoCurso").innerHTML = objData.data.status == 1 ?
                '<span class="badge bg-success">Activo</span>' :
                '<span class="badge bg-danger">Inactivo</span>';
            $('#modalViewCurso').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información del curso.", "error");
    });
}



function fntDelCurso(idcurso) {
    Swal.fire({
        title: 'Eliminar Curso',
        text: "¿Realmente quiere eliminar el Curso?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            let ajaxUrl = base_url + '/Cursos/delCurso/';
            let strData = new URLSearchParams({ idcurso: idcurso });

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
                    tableCursos.ajax.reload();
                } else {
                    Swal.fire('Atención!', objData.msg, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
            });
        }
    })
}

