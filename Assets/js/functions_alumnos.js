let tableAlumnos; 
let rowTable = "";
mostrarSpinner();
document.addEventListener('DOMContentLoaded', function(){
    ocultarSpinner();
    tableAlumnos = $('#tableAlumnos').DataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": ""+base_url+"/Alumnos/getAlumnos",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_usuario"},
            {"data":"identificacion"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email"},
            {"data":"telefono"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='bi bi-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary m-2 rounded"
            },{
                "extend": "excelHtml5",
                "text": "<i class='bi bi-file-earmark-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success m-2 rounded"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='bi bi-file-earmark-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger m-2 rounded"
            },{
                "extend": "csvHtml5",
                "text": "<i class='bi bi-filetype-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info m-2 rounded"
            }
        ],
        "responsive":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

	if(document.querySelector("#formAlumno")){
        let formAlumno = document.querySelector("#formAlumno");
        formAlumno.onsubmit = function(e) {
            e.preventDefault();
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let strApoderado = document.querySelector('#txtApoderado').value;
            let intNumeroApoderado= document.querySelector('#txtNumeroApoderado').value;
            let intMatricula=document.querySelector('#listMatriculado').value

            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' || strApoderado=='' || intNumeroApoderado=='')
            {
                Swal.fire("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            mostrarSpinner();
            const formData = new FormData(formAlumno); 
            const ajaxUrl = base_url + '/Alumnos/setAlumno';
            fetch(ajaxUrl, {
                method: 'POST',
                body: formData // Envía los datos del formulario
            })
            .then(response => response.json()) // Parsea la respuesta JSON
            .then(objData => {
                if (objData.status) {
                if (rowTable === "") {
                    tableAlumnos.ajax.reload(); // Suponiendo que `tableAlumnos` es instancia de la tabla de datos
                } else {
                    rowTable.cells[1].textContent = strIdentificacion;
                    rowTable.cells[2].textContent = strNombre;
                    rowTable.cells[3].textContent = strApellido;
                    rowTable.cells[4].textContent = strEmail;
                    rowTable.cells[5].textContent = intTelefono;
                    rowTable = "";
                }
                $('#modalFormAlumno').modal("hide");
                formAlumno.reset();
                ocultarSpinner();
                Swal.fire("Usuarios", objData.msg, "success");
                } else {
                Swal.fire("Error", objData.msg, "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire("Atención", "Error al enviar los datos del formulario", "error");
            });
        }
    }


}, false);


function fntViewInfo(idpersona) {
    let ajaxUrl = base_url + '/Alumnos/getAlumno/' + idpersona;
    mostrarSpinner();
    fetch(ajaxUrl)
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            document.querySelector("#celId").innerHTML = objData.data.id_usuario;
            document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
            document.querySelector("#celNombre").innerHTML = objData.data.nombres;
            document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
            document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
            document.querySelector("#celEmail").innerHTML = objData.data.email;                
            document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
            document.querySelector("#celNombreApoderado").innerHTML = objData.data.nombre_apoderado;
            document.querySelector("#celNumeroApoderado").innerHTML = objData.data.numero_whatsapp;
            document.querySelector("#celMatriculado").innerHTML = objData.data.matriculado == 0 ? "no" : "si";
            // Generate QR and add information to the card (assuming a function `generarQR` exists)          
            // generarQR(objData.data.id_usuario);
            ocultarSpinner();
            $('#modalViewAlumno').modal('show');
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo obtener la información del alumno.", "error");
    });
}


async function fntEditInfo(element, idpersona) {
    const rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Alumno";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    const ajaxUrl = base_url + '/Alumnos/getAlumno/' + idpersona;
    mostrarSpinner();
    try {
        const response = await fetch(ajaxUrl);
        if (response.ok) {
            const objData = await response.json();
            if (objData.status) {
                document.querySelector("#idUsuario").value = objData.data.id_usuario;
                document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                document.querySelector("#txtNombre").value = objData.data.nombres;
                document.querySelector("#txtApellido").value = objData.data.apellidos;
                document.querySelector("#txtTelefono").value = objData.data.telefono;
                document.querySelector("#txtEmail").value = objData.data.email;
                document.querySelector("#txtApoderado").value = objData.data.nombre_apoderado;
                document.querySelector("#txtNumeroApoderado").value = objData.data.numero_whatsapp;
                document.querySelector("#listMatriculado").value = objData.data.matriculado;
                
            }
        } else {
            throw new Error('Failed to fetch data');
        }
    } catch (error) {
        console.error('Error:', error);
    }
    ocultarSpinner();
    $('#modalFormAlumno').modal('show');
}


function fntDelInfo(idpersona) {
    Swal.fire({
        title: 'Eliminar Alumno',
        text: '¿Realmente quiere eliminar al Alumno?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!'
    }).then((result) => {
        if (result.isConfirmed) {
            let ajaxUrl = base_url + '/Alumnos/delAlumno';
            mostrarSpinner();
            let strData = new URLSearchParams({ idUsuario: idpersona });

            fetch(ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: strData
            })
            .then(response => response.json())
            .then(objData => {
                ocultarSpinner();
                if (objData.status) {
                    Swal.fire('Eliminar!', objData.msg, 'success');
                    tableAlumnos.ajax.reload(); 
                } else {
                    Swal.fire('Atención!', objData.msg, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudo eliminar el alumno.', 'error');
            });
        }
    });
};



function openModal()
{
    rowTable = "";
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Alumno";
    document.querySelector("#formAlumno").reset();
    $('#modalFormAlumno').modal('show');
}


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
                console.error('There was a problem with the fetch operation:', error);
            });
    }
}  

document.getElementById('print-button').addEventListener('click', function() {
    
    let id = parseInt(document.querySelector('#celId').textContent);
    // Construir la URL completa
    let url = base_url + '/Qrcontroller/idCard/'+id;

    // Abrir la tarjeta de identificación en una nueva ventana o pestaña
    let win = window.open(url, '_blank');
   
});
// funciones para agregar datos masivamente
const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('file-input');
const uploadForm = document.getElementById('upload-form');
const uploadBtn = document.getElementById('upload-btn');
const tableContainer = document.getElementById('table-container');
const dataTable = document.getElementById('uploaded-data-table');

dropArea.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', handleFiles);

dropArea.addEventListener('dragover', (event) => {
  event.preventDefault();
  dropArea.classList.add('dragover');
});

dropArea.addEventListener('dragleave', () => {
  dropArea.classList.remove('dragover');
});

dropArea.addEventListener('drop', (event) => {
  event.preventDefault();
  dropArea.classList.remove('dragover');
  const files = event.dataTransfer.files;
  handleFiles({ target: { files } });
});

let jsonDataGlobal = null; // Variable global para almacenar los datos JSON procesados

function handleFiles(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const data = e.target.result;
        const workbook = XLSX.read(data, { type: 'binary' });
        const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
        const jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
        jsonDataGlobal = jsonData; // Guardamos los datos en la variable global
        displayTable(jsonData);
      };
      reader.readAsBinaryString(file);
    }
  }

function displayTable(data) {
  if (data.length === 0) {
    Swal.fire('El archivo está vacío.');
    return;
  }
  
  let tableHtml = '<thead><tr>';
  data[0].forEach(header => {
    tableHtml += `<th class="bg-color-sky-blue">${header}</th>`;
  });
  tableHtml += '</tr></thead><tbody>';
  data.slice(1).forEach(row => {
    tableHtml += '<tr>';
    row.forEach(cell => {
      tableHtml += `<td>${cell}</td>`;
    });
    tableHtml += '</tr>';
  });
  tableHtml += '</tbody>';
  dataTable.innerHTML = tableHtml;
  tableContainer.style.display = 'block';
}

uploadBtn.addEventListener('click', async () => {
    mostrarSpinner();
    if (jsonDataGlobal !== null && jsonDataGlobal.length > 0) {
      try {
        // Enviamos los datos al servidor con fetch
        const response = await fetch(base_url + '/Alumnos/importAlumnos', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(jsonDataGlobal)
        });
  
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
  
        const result = await response.json();
        // Verifica el estado de la respuesta para decidir qué mensaje mostrar
        if (result.status) {
        ocultarSpinner();
          Swal.fire('Completado', result.msg, 'success');
        } else {
            ocultarSpinner();
          Swal.fire('Error', result.msg, 'error');
        }
      } catch (error) {
        ocultarSpinner();
        Swal.fire('Error', 'Hubo un problema al procesar tu solicitud. Por favor, intenta de nuevo más tarde.', 'error');
      }
    } else {
        ocultarSpinner();
      Swal.fire('Por favor, selecciona un archivo y carga los datos primero.');
    }
  });
  
