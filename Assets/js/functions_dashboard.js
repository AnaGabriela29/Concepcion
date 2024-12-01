document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');
    if(calendarEl){
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // vista de calendario mensual
        locale: 'es',  // Configuración regional para español
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch(base_url + "/Dashboard/getAsistencias")
            .then(response => response.json())
            .then(data => {
                
                const events = data.data.map(asistencia => {
                    return {
                        title: asistencia.estado, // "Asistió", "Falta", etc.
                        start: asistencia.fecha, // asegúrate de que las fechas están en formato YYYY-MM-DD
                        color: getColor(asistencia.estado), // función para obtener el color basado en el estado
                        extendedProps: {
                            observaciones: asistencia.observaciones || "Sin observaciones" // Manejo de nulos
                        }
                    };
                });
                successCallback(events);
            })
            .catch(error => {
                failureCallback(error);
            });
        },        
        eventClick: function(info) {
            // Función para mostrar detalles al hacer clic en un evento
            Swal.fire({
                title: info.event.title,
                text: info.event.extendedProps.observaciones,
                icon: 'info'
            });
        }
    });

    calendar.render();
    }

    let btnNotas = document.querySelector('.btn-notas');
    if(btnNotas){
        btnNotas.addEventListener('click', function(){
            let ajaxUrl = base_url + '/Dashboard/getNotas';
    
            fetch(ajaxUrl)
            .then(response => response.json())
            .then(objData => {
                if (objData.status) {             
                    document.querySelector("#notas-body").innerHTML = objData.html;
                    document.querySelector(".tablaPagoAlumno").classList.add('d-none');
                    document.querySelector(".tablaNotaAlumno").classList.remove('d-none');
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            })
            .catch(error => {                
                Swal.fire("Error", "No se pudo obtener la información de las notas.", "error");
            });
        });
    }

    let btnpays = document.querySelector('.btn-pays');
    if(btnpays){
        btnpays.addEventListener('click', function(){
            let ajaxUrl = base_url + '/Dashboard/getPagos';
    
            fetch(ajaxUrl)
            .then(response => response.json())
            .then(objData => {
                if (objData.status) {
                    document.querySelector("#pagos-body").innerHTML = objData.html;
                    document.querySelector(".tablaNotaAlumno").classList.add('d-none');
                    document.querySelector(".tablaPagoAlumno").classList.remove('d-none');
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            })
            .catch(error => {              
                Swal.fire("Error", "No se pudo obtener la información de los pagos.", "error");
            });
        });
    }
    

    function fetchDailyAttendance() {
        fetch(`${base_url}/Dashboard/asistenciaDiaria`)
            .then(response => response.json())
            .then(data => {
                const labels = ['Asistencias', 'Ausencias'];
                const values = [data.data.total_asistencias, data.data.total_inasistencias];

                const ctx = document.getElementById('dailyAttendanceChart').getContext('2d');
                const dailyAttendanceChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'cantidad',
                            data: values,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Porcentaje de asistencia diaria'
                            }
                        }
                    }
                });
                
            })
            .catch(error => console.error('Error fetching daily attendance data:', error));
    }
    
    if(document.getElementById('dailyAttendanceChart')){fetchDailyAttendance()};
    

    function fetchMonthlyPayments() {
        fetch(`${base_url}/Dashboard/pagosMensual`)
            .then(response => response.json())
            .then(data => {
                const labels = ['Pagos realizados', 'Faltan Pagar'];
                const values = [data.data.total_pagos , data.data.total_no_pagos];

                const ctx = document.getElementById('monthlyPaymentsChart').getContext('2d');
                const monthlyPaymentsChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'cantidad',
                            data: values,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(255, 99, 132, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Porcetanje de pagos en el mes'
                            }
                        }
                    }
                });    
                
            })
            .catch(error => console.error('Error fetching monthly payments data:', error));
    }
    
    if(document.getElementById('monthlyPaymentsChart')){fetchMonthlyPayments()}; 
});

function getColor(estado) {
    switch (estado) {
        case 'Puntual':
            return 'green'; // Verde para puntual
        case 'Tardanza':
            return 'red'; // Rojo para tarde
        default:
            return 'blue'; // Azul como color por defecto
    }
}
// funcion para el boton de whatsapp
if(document.getElementById('whatsapp-button')){
    document.getElementById('whatsapp-button').addEventListener('click', function() {    
        let phoneNumber = '51998589309';    
        let message = 'Hola, tengo una consulta al colegio unimat';
        let encodedMessage = encodeURIComponent(message);
        let whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;    
        window.open(whatsappUrl, '_blank');
    });    
}