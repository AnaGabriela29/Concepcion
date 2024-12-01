let tableNotas; 
let idAula;
let idCurso;
let idGrado;
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){

//seleccionar los box
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
            console.log(cursoBoolean, aulaBoolean, gradoBoolean);
            if (cursoBoolean === true && aulaBoolean === true && gradoBoolean === true) {
                window.location.href = base_url + "/Notas/notasAdmin/" + idAula + "/" + idGrado + "/" + idCurso;
            } else {
                Swal.fire("Atención", "Seleccione todas las opciones", "error");
            }
            
        })
    }


    if(document.querySelector('.dataAula')){
        idAula=document.querySelector('.dataAula').dataset.id;
    }
    if(document.querySelector('.dataGrado')){
        idGrado=document.querySelector('.dataGrado').dataset.id;
    }
    if(document.querySelector('.dataCurso')){
        idCurso=document.querySelector('.dataCurso').dataset.id;
    }


       
	tableNotas = $('#tableNotas').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Notas/getNotas/"+idAula+"/"+idGrado+"/"+idCurso,
            "dataSrc":""
        },
        "columns":[
            {"data":"id_nota"},
            {"data":"identificacion"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"nota_1"},
            {"data":"nota_2"},
            {"data":"nota_3"},
            {"data":"nota_4"},
            {"data":"status"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });    

   
       
    //NUEVO Nota
    let formNotas = document.querySelector("#formNotas");
    if(formNotas){
        formNotas.onsubmit = function(e) {
            e.preventDefault();
        
            let intIdNota = document.querySelector('#idNota').value;
            let strAlumno = document.querySelector('#listaAlumnos').value;
            let strDocente = document.querySelector('#listaDocentes').value;
            let intNota1 = document.querySelector('#nota1').value;
            let intNota2 = document.querySelector('#nota2').value;
            let intNota3 = document.querySelector('#nota3').value;
            let intNota4 = document.querySelector('#nota4').value;
            let intStatus = document.querySelector('#listStatus').value;
        
            if (intIdNota == "") {
                if (strAlumno == '' || strDocente == '' || intStatus == '' || (intNota1 == '' && intNota2 == '' && intNota3 == '' && intNota4 == '')) {
                    Swal.fire("Atención", "Complete campos obligatorios.", "error");
                    return false;
                }
            } else if (intStatus == '' || (intNota1 == '' && intNota2 == '' && intNota3 == '' && intNota4 == '')) {
                Swal.fire("Atención", "Complete campos obligatorios.", "error");
                return false;
            }
        
            let ajaxUrl = base_url + '/Notas/setNota'; 
            let formData = new FormData(formNotas);
        
            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(objData => {
                if (objData.status) {
                    $('#modalFormNotas').modal("hide");
                    formNotas.reset();
                    Swal.fire("Notas de usuario", objData.msg, "success");
                    tableNotas.ajax.reload();
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
        
}

    
});

$('#tableNotas').DataTable();

//usamos la funcion para traer la lista de usuarios tanto para alumnos y docentes
function getDataList(){
    $(document).ready(function() {
        
        
        $('.listaAlumnos').select2({
            dropdownParent: $('#modalFormNotas'),
            ajax: {
                url: base_url+'/Notas/getAlumnosModal/'+idAula+"/"+idGrado+"/"+idCurso,
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.data.map(function(item) {                    
                            return {
                                id: item.id_asignacion,
                                text: item.nombres,
                                
                            };
                        })
                    };
                }
            },
            templateResult: function (data) {
                if (data.loading) {
                    return data.text;
                }
                var markup = data.text;
                return markup;
            },
            templateSelection: function (data) {
                return data.text || data.id;
            }
        });     
        
        $('.listaAlumnos').val(null).trigger('change.select2'); 

        $('.listaDocentes').select2({
            dropdownParent: $('#modalFormNotas'),
            ajax: {
                url: base_url+'/Notas/getDocentes/'+idAula+"/"+idGrado+"/"+idCurso,
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.data.map(function(item) {                            
                            return {
                                id: item.id_usuario,
                                text: item.nombres,
                                
                            };
                        })
                    };
                }
            },
            templateResult: function (data) {
                if (data.loading) {
                    return data.text;
                }
                var markup = data.text;
                return markup;
            },
            templateSelection: function (data) {
                return data.text || data.id;
            }
        });     
        
        $('.listaDocentes').val(null).trigger('change.select2'); 
    });        
}

function openModal(){

    document.querySelector('#idNota').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Nota";
    document.querySelector("#formNotas").reset();
    getDataList();
    let boxes=document.querySelectorAll(".box-nota-aux");
    boxes.forEach(function(box){
        box.classList.remove('d-none');
    })  
	$('#modalFormNotas').modal('show');
}

window.addEventListener('load', function() {
    /*fntEditRol();
    fntDelRol();
    fntPermisos();*/
}, false);

function fntEditNota(idNota) {
    document.querySelector('#titleModal').innerHTML = "Actualizar Nota";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let ajaxUrl = base_url + '/Notas/getNota/' + idNota;

    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            let boxes = document.querySelectorAll(".box-nota-aux");
            boxes.forEach(function(box) {
                box.classList.add('d-none');
            });
            document.querySelector("#idNota").value = objData.data.id_nota;
            document.querySelector("#nota1").value = objData.data.nota_1;
            document.querySelector("#nota2").value = objData.data.nota_2;
            document.querySelector("#nota3").value = objData.data.nota_3;
            document.querySelector("#nota4").value = objData.data.nota_4;

            let optionSelect = objData.data.status == 1
                ? '<option value="1" selected class="notBlock">Activo</option> <option value="2" class="notBlock">Inactivo</option>'
                : '<option value="2" selected class="notBlock">Inactivo</option> <option value="1" class="notBlock">Activo</option>';

            document.querySelector("#listStatus").innerHTML = optionSelect;
            $('#modalFormNotas').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información de la nota.", "error");
    });
}


function fntViewNota(idNota) {
    let ajaxUrl = base_url + '/Notas/getNotaAlumno/' + idNota;

    fetch(ajaxUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(objData => {
        if (objData.status) {
            document.querySelector("#celNombresAlumno").innerHTML = objData.data.nombres_alumno;
            document.querySelector("#celNombresDocente").innerHTML = objData.data.nombres_docente;
            document.querySelector("#celNota1").innerHTML = objData.data.nota_1;
            document.querySelector("#celNota2").innerHTML = objData.data.nota_2;
            document.querySelector("#celNota3").innerHTML = objData.data.nota_3;
            document.querySelector("#celNota4").innerHTML = objData.data.nota_4;
            document.querySelector("#celPeriodo").innerHTML = objData.data.nombre_periodo;
            document.querySelector("#celFecha").innerHTML = objData.data.fecha;
            document.querySelector("#celEstado").innerHTML = objData.data.status == 1 ? 
                '<span class="badge bg-success">Activo</span>' : 
                '<span class="badge bg-danger">Inactivo</span>';
                
            $('#modalViewNota').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información de la nota.", "error");
    });
}


function fntDelNota(idNota) {
    Swal.fire({
        title: 'Eliminar Nota',
        text: "¿Realmente quiere eliminar la Nota?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            let ajaxUrl = base_url + '/Notas/delNota/';
            let strData = new URLSearchParams({idNota: idNota}).toString();

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
                    tableNotas.ajax.reload();
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


