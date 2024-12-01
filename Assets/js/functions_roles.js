let tableRoles; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){


	tableRoles = $('#tableRoles').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Roles/getRoles",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_rol"},
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
    let formRol = document.querySelector("#formRol");
    formRol.onsubmit = function(e) {
        e.preventDefault();

        let intIdRol = document.querySelector('#idRol').value;
        let strNombre = document.querySelector('#txtNombre').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let intStatus = document.querySelector('#listStatus').value;        
        if(strNombre == '' || strDescripcion == '' || intStatus == '')
        {
            Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        // divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Roles/setRol'; 
        let formData = new FormData(formRol);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormRol').modal("hide");
                    formRol.reset();
                    Swal.fire("Roles de usuario", objData.msg ,"success");
                    tableRoles.ajax.reload();
                }else{
                    Swal.fire("Error", objData.msg , "error");
                }              
            } 
            // divLoading.style.display = "none";
            return false;
        }

        
    }

});

$('#tableRoles').DataTable();

function openModal(){

    document.querySelector('#idRol').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector("#formRol").reset();
	$('#modalFormRol').modal('show');
}

window.addEventListener('load', function() {
    /*fntEditRol();
    fntDelRol();
    fntPermisos();*/
}, false);

function fntEditRol(idrol){
    document.querySelector('#titleModal').innerHTML ="Actualizar Rol";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Roles/getRol/'+idrol;
    request.open("GET",ajaxUrl ,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector("#idRol").value = objData.data.id_rol;
                document.querySelector("#txtNombre").value = objData.data.nombre;
                document.querySelector("#txtDescripcion").value = objData.data.descripcion;
                let optionSelect;
                if(objData.data.status == 1)
                {
                    optionSelect= '<option value="1" selected class="notBlock">Activo</option> <option value="2" class="notBlock">Inactivo</option>';
                }else{
                    optionSelect = '<option value="2" selected class="notBlock">Inactivo</option> <option value="1" class="notBlock">Activo</option>';
                }
                
                document.querySelector("#listStatus").innerHTML = optionSelect;
                $('#modalFormRol').modal('show');
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }

}

function fntDelRol(idrol){
    Swal.fire({
        title: 'Eliminar Rol',
        text: "¿Realmente quiere eliminar el Rol?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Roles/delRol/';
            let strData = "idrol="+idrol;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire(
                            'Eliminar!',
                            objData.msg,
                            'success'
                        )
                        tableRoles.ajax.reload();
                    }else{
                        Swal.fire(
                            'Atención!',
                            objData.msg,
                            'error'
                        )
                    }
                }
            }
        }
    })
}


function fntPermisos(idrol) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Permisos/getPermisosRol/' + idrol;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 200) {
                document.querySelector('#contentAjax').innerHTML = request.responseText;
                $('.modalPermisos').modal('show');
                let formPermisos = document.querySelector('#formPermisos');
                if (formPermisos) {
                    formPermisos.addEventListener('submit', fntSavePermisos, false);
                }
            } else {
                console.error('Error al cargar los permisos:', request.status);
            }
        }
    }
}


function fntSavePermisos(evnet){
    evnet.preventDefault();
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Permisos/setPermisos'; 
    let formElement = document.querySelector("#formPermisos");
    let formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                $('.modalPermisos').modal('hide');
                Swal.fire("Permisos de usuario", objData.msg ,"success");
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
        }
    }
    
}