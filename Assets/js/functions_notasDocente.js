document.addEventListener("DOMContentLoaded", function () {
  //añadir evento click, para escoger aula, grado y curso
  document.querySelectorAll(".box-docente-asignacion").forEach(function (element) {
      element.addEventListener("click", function () {
        let idAula = this.querySelector(".date-aula").dataset.id;
        let idGrado = this.querySelector(".date-grado").dataset.id;
        let idCurso = this.querySelector(".date-curso").dataset.id;
      
        let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl =base_url + "/Notas/getAlumnos/" + idAula + "/" + idGrado + "/" + idCurso;
        request.open("GET", ajaxUrl, true);
        request.send();

        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let tablaNotas = document.getElementById("tablaNotas");
            tablaNotas.innerHTML='';
            let cantidad=0;
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              // recorremos la respusta de servidor y añadimos las filas a la tabla
              objData.data.forEach(function (alumno) {
                
                let fila = document.createElement("tr");
                fila.innerHTML = `<td>${++cantidad}</td> <td>${alumno.nombres}</td> 
                <td><input type="number" class="nota" data-id="${alumno.id_asignacion}" name="valueNota" /></td>`;               
                tablaNotas.append(fila);        
              });

              $("#modalNotas").modal("show");
            } else {
              Swal.fire("Error", objData.msg, "error");
            }
          }
        };

        
      });
    });

    //NUEVO INGRESO DE NOTAS
    let formRol = document.querySelector("#formNotas");
    formRol.onsubmit = function(e) {
        e.preventDefault();
        let csrf=document.getElementById('csrf').value;
     
        let dataToSend = {
          notasData: [],
          csrf: csrf
      };
        
        let InputNotas = document.querySelectorAll('.nota');
        let notasInvalidas=false;

        InputNotas.forEach(nota => {
        let idAsignacion = nota.dataset.id;
        let valorNota = nota.value;

        if (parseInt(valorNota) < 0 || parseInt(valorNota) > 20) {            
            notasInvalidas=true;
        }
        dataToSend.notasData.push({
            id_asignacion: idAsignacion,
            nota: valorNota
        });
       });
       //si el valor es notas invalidas es verdadero, entonces manda error;
       if(notasInvalidas){Swal.fire("Atención", "Ingrese un valor de notas en el rango de 0-20", "error"); return};

        // divLoading.style.display = "flex";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Notas/setNotas'; 
        let jsonData=JSON.stringify(dataToSend);
        
        request.open("POST",ajaxUrl,true);
        request.setRequestHeader("Content-Type", "application/json");
        request.send(jsonData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalNotas').modal("hide");
                    formNotas.reset();
                    Swal.fire("Notas UNIMAT", objData.msg ,"success");
                    
                }else{
                    Swal.fire("Error", objData.msg , "error");
                }              
            } 
            // divLoading.style.display = "none";
            return false;
        }

        
    }


});




// function openModal(){

//     // document.querySelector('#idRol').value ="";
//     document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
//     document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
//     document.querySelector('#btnText').innerHTML ="Guardar";
//     document.querySelector('#titleModal').innerHTML = "Ingresar Notas";
//     // document.querySelector("#formRol").reset();
// 	$('#modalNotas').modal('show');
// }
