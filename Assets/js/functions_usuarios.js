let tableUsuarios;
let rowTable = ""; 
// let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableUsuarios = $('#tableUsuarios').DataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Usuarios/getUsuarios",
            "dataSrc": function(json) {
                
                return json;
            }
        },
        "columns":[
            {"data":"id_usuario"},
            {"data":"identificacion"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email"},
            {"data":"telefono"},
            {"data":"nombre"},
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
        "responsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    
    fntRolesUsuario(); 
}, false);

    $('#print_Users').on('shown.bs.modal', function () {
        $('.select-lista-roles').select2();
    });

    if(document.querySelector("#formUsuario")){
        let formUsuario = document.querySelector("#formUsuario");
        formUsuario.onsubmit = async function(e) {
            e.preventDefault();
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let intTipousuario = document.querySelector('#listRolid').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let intStatus = document.querySelector('#listStatus').value;

            if(strIdentificacion == '' || strIdentificacion.length !=8 || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || intTelefono.length !=9 || intTipousuario == '')
            {
                Swal.fire("Atención", "Hay algunos campos vacios o erroneos." , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            // divLoading.style.display = "flex";
            let ajaxUrl = base_url+'/Usuarios/setUsuario'; 
            let formData = new FormData(formUsuario);
            try{
            fetch(ajaxUrl, {
            method: 'POST',
            body: formData
            })
            .then(response =>response.json())
            .then(objData => {
            if(objData.status)
            {
                if(rowTable == ""){
                tableUsuarios.ajax.reload();
                }else{
                htmlStatus = intStatus == 1 ? 
                '<span class="badge bg-success">Activo</span>' : 
                '<span class="badge bg-danger">Inactivo</span>';
                
                rowTable.cells[1].textContent = strIdentificacion;
                rowTable.cells[2].textContent = strNombre;
                rowTable.cells[3].textContent = strApellido;
                rowTable.cells[4].textContent = strEmail;
                rowTable.cells[5].textContent = intTelefono;
                rowTable.cells[6].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
                rowTable.cells[7].innerHTML = htmlStatus;
                rowTable = ""; 
                }
                $('#modalFormUsuario').modal("hide");
                formUsuario.reset();
                Swal.fire("Usuarios", objData.msg ,"success");
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
            })

            }catch(error){
            console.error('Error:', error);
            // divLoading.style.display = "none";
            return false;
            };

        }
    }    



function fntRolesUsuario(){
    if(document.querySelector('#listRolid')){
        const ajaxUrl = base_url + '/Roles/getSelectRoles';

        fetch(ajaxUrl)
        .then(response => response.text()) // Parse the text response
        .then(responseText => {
            let tempDiv = document.createElement('div');
            tempDiv.innerHTML = responseText;
            
            let options = tempDiv.querySelectorAll('option');
                options.forEach(option => {
                    // Deshabilitar y borrar valor si la opción cumple una condición específica
                    if (option.textContent === 'Alumno') {
                        option.disabled = true;
                        option.removeAttribute('value');
                    }                    
                });
            
            document.querySelector('.select-lista-roles').innerHTML=responseText;
            document.querySelector('#listRolid').innerHTML = tempDiv.innerHTML;

        })
        .catch(error => {
          console.error('Error:', error);
        });
        
    }
}

function fntViewUsuario(idpersona){
    const ajaxUrl = base_url + '/Usuarios/getUsuario/' + idpersona;

    fetch(ajaxUrl)
    .then(response => response.json()) // Parse the JSON response
    .then(objData => {
        if (objData.status) {
        const estadoUsuario = objData.data.status == 1 ?
            '<span class="badge bg-success">Activo</span>' :
            '<span class="badge bg-danger">Inactivo</span>';
        document.querySelector('#celId').innerHTML=objData.data.id_usuario    
        document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
        document.querySelector("#celNombre").innerHTML = objData.data.nombres;
        document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
        document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
        document.querySelector("#celEmail").innerHTML = objData.data.email;
        document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombre;
        document.querySelector("#celEstado").innerHTML = estadoUsuario;
        document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;

        // Generate QR and add information to the card (assuming a function `generarQR` exists)
        // generarQR(objData.data.id_usuario);
        $('#modalViewUser').modal('show');
        } else {
        Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Atención", "Error al obtener los datos del usuario", "error");
    });

}

function fntEditUsuario(element,idpersona){
    rowTable = element.parentNode.parentNode.parentNode; 
    document.querySelector('#titleModal').innerHTML ="Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    const ajaxUrl = base_url + '/Usuarios/getUsuario/' + idpersona;

    fetch(ajaxUrl)
    .then(response => response.json()) // Parse the JSON response
    .then(objData => {
        if (objData.status) {        
        document.querySelector("#idUsuario").value = objData.data.id_usuario;
        document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
        document.querySelector("#txtNombre").value = objData.data.nombres;
        document.querySelector("#txtApellido").value = objData.data.apellidos;
        document.querySelector("#txtTelefono").value = objData.data.telefono;
        document.querySelector("#txtEmail").value = objData.data.email;
        document.querySelector("#listRolid").value = objData.data.id_rol;

        // document.querySelector("#listStatus").value = objData.data.status === 1 ? 1 : 2;
        // $('#listStatus').selectpicker('render'); // Assuming you use Selectpicker for the status dropdown

        $('#modalFormUsuario').modal('show');
        } else {
        Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Atención", "Error al obtener los datos del usuario", "error");
    });

}

function fntDelUsuario(idpersona){
    Swal.fire({
        title: 'Eliminar Usuario',
        text: '¿Realmente quiere eliminar el Usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {

            const ajaxUrl = base_url + '/Usuarios/delUsuario';
            const strData = { idUsuario: idpersona };

            fetch(ajaxUrl, {
            method: 'DELETE', // Cambia el método a DELETE
            headers: {
                'Content-Type': 'application/json' // Establece el tipo de contenido
            },
            body:JSON.stringify(strData)
            })
            .then(response => response.json()) // Analiza la respuesta JSON
            .then(objData => {
            if (objData.status) {
                Swal.fire(
                'Eliminar!',
                objData.msg,
                'success'
                );
                tableUsuarios.ajax.reload(); // Suponiendo que `tableUsuarios` es tu instancia de la tabla de datos
            } else {
                Swal.fire(
                'Atención!',
                objData.msg,
                'error'
                );
            }
            })
            .catch(error => {
            console.error('Error:', error);
            Swal.fire("Atención", "Error al eliminar el usuario", "error");
            });

        }
    });
}



function openModal()
{
    rowTable = "";
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $('#modalFormUsuario').modal('show');
}

function openModalPerfil(){
    $('#modalFormPerfil').modal('show');
}

//generamos el QR
function generarQR(idUser){    
    idUser=parseInt(idUser);
    if(Number.isInteger(idUser)){
    // Realizar un número entero
    let ajaxUrl = `${base_url}/Qrcontroller/generate/${idUser}`;
    
    fetch(ajaxUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(qrCodeHtml => {
            // Mostrar la imagen del código QR en la página web                
            document.querySelector('.img-qr').innerHTML = qrCodeHtml;
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:');
        });
}
} 

document.getElementById('print-button').addEventListener('click', function() {
    
    let id_user = parseInt(document.querySelector('#celId').textContent);
    // Construir la URL completa
    let url = base_url + '/Qrcontroller/idCard/'+id_user;

    // Abrir la tarjeta de identificación en una nueva ventana o pestaña
    let win = window.open(url, '_blank');
   
});

$('#btn-extract-information').on('click', function() {
    let selectedValues = $('.select-lista-roles').val();
    mostrarSpinner();
    let ajaxUrl = base_url + '/Qrcontroller/total_cards';
    
    // Preparar los datos a enviar
    let data = {
        ids_roles: selectedValues
    };
    
    fetch(ajaxUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(objData => {
        console.log(objData);
        ocultarSpinner();
        if (objData.status === 'true') {
            // Guardar los datos de forma temporal
            localStorage.setItem('usersData', JSON.stringify(objData.data));
            // abrir nueva ventana
            window.open(base_url + '/Qrcontroller/showCardsMassive', '_blank');
        } else {
            Swal.fire("Atención", objData.msg, "error");
        }
        
    })
    .catch(error => {
        ocultarSpinner();
        console.error('There was a problem with the fetch operation:', error);
    });
});









