let scaner;
document.addEventListener('DOMContentLoaded', function(){    
    prenderCamara();

    let formAsistencia = document.querySelector("#formAsistencia");
    formAsistencia.onsubmit = function(e) {
        e.preventDefault();
        let strIdentificacion = document.querySelector('#txtidentificacion').value;
        let estadoAsistencia = document.querySelector('#estadoAsistencia').value;
        
        if(strIdentificacion==""){
            Swal.fire("Atención", "El campo DNI no puede estar vacio" , "error");
            return false;
        }

        let ajaxUrl = base_url + '/Asistencia/setAsistenciaDni';
        let formData = new FormData();
        formData.append('identificacion', strIdentificacion);
        formData.append('estado', estadoAsistencia);

        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(objData => {
            if (objData.status) {
                setTimeout(reproducirAudio, 100); // Ensure this function is defined elsewhere
                Swal.fire("Asistencia registrada", objData.msg + ` con ${estadoAsistencia}` , "success");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
            prenderCamara(); // Ensure this function is defined elsewhere to restart the camera
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire("Error", "No se pudo procesar la solicitud.", "error");
        });

        formAsistencia.reset();
        
    }
})

function prenderCamara(){    
     scaner=new Html5QrcodeScanner('reader',{
        qrbox:{
            width:250,
            height: 250
        },
        fps:25,
        formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
        cameraFacingMode: "environment",// Para usar la cámara trasera,
    });
    scaner.render(success, error);    
    function success(result){
        if(/^[0-9]+$/.test(result)){                     
            scaner.clear();
            let estadoAsistencia = document.querySelector('#estadoAsistencia').value; 
            insertarAsistencia(result, estadoAsistencia);
        }                
    }
    function error(err){
    }
}

function insertarAsistencia(idUsuario, estadoAsistencia) {

    idUsuario = parseInt(idUsuario);
    let ajaxUrl = base_url + '/Asistencia/setAsistencia';
    let formData = new FormData();
    formData.append('idUsuario', idUsuario);
    formData.append('estado', estadoAsistencia);

    fetch(ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            setTimeout(reproducirAudio, 100); // Ensure this function is defined elsewhere
            Swal.fire("Asistencia registrada", objData.msg + ` con ${estadoAsistencia}` , "success");
        } else {
            Swal.fire("Error", objData.msg, "error");
        }
        prenderCamara(); // Ensure this function is defined elsewhere to restart the camera
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "No se pudo procesar la solicitud.", "error");
    });
}

// sonido de exito de asistencia
function reproducirAudio(){
    let audio = new Audio(base_url+'/Assets/songs/star.mp3');
        audio.play();
}

