let IntIdentificacion=document.getElementById('IntIdentificacion');
let formNewPay=document.getElementById('formNewPay');
let btnNewPay=document.getElementById('registerNewPay');
let btnNoPays=document.getElementById('btnSearchNoPays');
// Obtenemos la fecha
const today = new Date();
const month = today.getMonth() + 1;
// buscar pagos
let btnSearchPays=document.getElementById('btnSearchPays');
mostrarSpinner();
document.addEventListener('DOMContentLoaded', function(){
    ocultarSpinner(); 
    if(formNewPay){
        IntIdentificacion.addEventListener('input', function() {            
            let identificacion = IntIdentificacion.value;
            if (identificacion.length === 8) {
                identificacion=parseInt(identificacion);
                
                fetch(`${base_url}/Pagos/getFullName?dni=${identificacion}`)

                    .then(response => {
                        if (!response.ok) {
                            
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {                        
                        document.getElementById('txtNombre').value=data.data.nombres==""?"":data.data.nombres;
                        document.getElementById('txtApellido').value=data.data.apellidos==""?"":data.data.apellidos;
                        IntIdentificacion.dataset.idUsuario=data.data.id_usuario==""?"":data.data.id_usuario;
                        
                    })
                    .catch(error => {
                        // console.log("No hay Datos".error);  
                                        
                    });
            }else{
                document.getElementById('txtNombre').value="";
                document.getElementById('txtApellido').value="";
                IntIdentificacion.dataset.idUsuario="";

            }
        });

        let conceptoPagoSelect = document.getElementById('txtConceptoPago');
        const containMonthDiv = document.getElementById('contain_month');

        conceptoPagoSelect.addEventListener('change', function() {
            const selectedText = conceptoPagoSelect.options[conceptoPagoSelect.selectedIndex].text;
            if (selectedText.includes('Mensualidad')) {
                document.getElementById('monthName').value=month;                
                containMonthDiv.classList.remove('d-none');
            } else {                
                containMonthDiv.classList.add('d-none');                
            }
        });

        // funcion para imprimir la factura 
        function printInvoice(id_pago){
            const url = `${base_url}/Pdfgenerator/imprimirFact?id_pago=${id_pago}`;
            window.open(url, '_blank');
        }
        


        btnNewPay.addEventListener('click', function() {
            // Obtención de valores de los campos del formulario
            let IntIdentificacionElement = document.getElementById('IntIdentificacion');
            let IntIdentificacion = IntIdentificacionElement.value;
            let txtConceptoPago = document.getElementById('txtConceptoPago').value;
            let floatMonto = parseFloat(document.getElementById('floatMonto').value);
            let txtTipoPago = document.getElementById('txtTipoPago').value;
            let estadoPago = document.getElementById('estadoPago').value;
            let txtObservaciones = document.getElementById('txtObservaciones').value;
            let periodo = document.getElementById('periodo').value;
            let monthName = document.getElementById('monthName').value;
            let token = document.getElementById('token').value;
            let idUsuario = IntIdentificacionElement.dataset.idUsuario;
        
            // Validaciones
            if (IntIdentificacion === "" || IntIdentificacion.length !== 8) {
                Swal.fire("Atención", "Valores incorrectos en el documento de identificación", "error");
                return false;
            }
            if (isNaN(floatMonto) || floatMonto <= 0) {
                Swal.fire("Atención", "El monto total no puede ser valores negativos o '0'", "error");
                return false;
            }

            // logica para evitar enviar completo y que el monto no sea igual al concepto
            let conceptoPagoSelect = document.getElementById('txtConceptoPago');

            // Si no está seleccionada la opción de mensualidad, se envía el valor vacío para monthName
            const selectedText = conceptoPagoSelect.options[conceptoPagoSelect.selectedIndex].text;
            if (!selectedText.includes('Mensualidad')) {
                monthName = "";
            }
            
            let selectedOptionText = conceptoPagoSelect.options[conceptoPagoSelect.selectedIndex].text;
            // Extraer el monto del concepto de pago del texto seleccionado
            let montoConcepto = parseFloat(selectedOptionText.split('- s/')[1].split('/')[0].trim());
            if (isNaN(montoConcepto)) {
                console.error('El monto del concepto de pago no es un número válido.');
                return; 
            }
    
            const estadoSeleccionado = document.getElementById('estadoPago').options[document.getElementById('estadoPago').selectedIndex].text;
            if(estadoSeleccionado==="Completo"){
                
                if(floatMonto !== montoConcepto){
                    Swal.fire({
                        title: 'Atención',
                        text: `El monto pagado de $${floatMonto} es menor al monto total del concepto de $${montoConcepto} y el estado del pago es completo`,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
            }else if(estadoSeleccionado==="Parcial"){
                if(floatMonto>=montoConcepto){
                    Swal.fire({
                        title: 'Atención',
                        text: `El monto pagado de $${floatMonto} es igual al monto total del concepto de $${montoConcepto} y el estado del pago es parcial`,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    return false;
                }
            }
            const conceptoSeleccionado = conceptoPagoSelect.options[conceptoPagoSelect.selectedIndex].text;


            // Creación del objeto de datos
            const data = {
                IntIdUsuario: idUsuario,
                txtConceptoPago: txtConceptoPago,
                floatMonto: floatMonto,
                txtTipoPago: txtTipoPago,
                estadoPago: estadoPago,
                txtObservaciones: txtObservaciones,
                periodo: periodo,
                monthName: monthName,
                tokencsrf: token
            };
        
            // Confirmación con SweetAlert2
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Confirmar el registro de pago",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, registrar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar los datos al servidor
                    mostrarSpinner();
                    fetch(`${base_url}/Pagos/setPay`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === true) {
                             // Mostrar nueva ventana con opción de imprimir
                            
                             ocultarSpinner();
                            Swal.fire({
                                title: "Pago registrado con éxito",
                                text: data.msg,
                                icon: "success",
                                showCancelButton: true,
                                confirmButtonText: 'Imprimir Factura',
                                cancelButtonText: 'Cerrar',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // función para imprimir la factura
                                    printInvoice(data.id_pay);
                                }
                            });
                            formNewPay.reset();
                            
                            document.getElementById('monthName').value = month;
                        } else {
                            ocultarSpinner();
                            Swal.fire("Error", data.msg, "error");
                        }
                    })
                    .catch(error => {
                        ocultarSpinner();
                        Swal.fire("Error", "Hubo un problema al registrar el pago", "error");
                    });
                }
            });
        });
        

    }

    // buscar pagos
    if(btnSearchPays){
        btnSearchPays.addEventListener('click', function() {
            let txtIdentificacion = document.getElementById('txtIdentificacion').value;
            if (txtIdentificacion === "" || txtIdentificacion.length !== 8) {
                Swal.fire("Atención", "Valores incorrectos en el documento de identificación", "error");
                return false;
            }
            txtIdentificacion = parseInt(txtIdentificacion);
        
            // Destruir la tabla existente si ya está inicializada
            if ($.fn.DataTable.isDataTable('#tablePays')) {
                $('#tablePays').DataTable().destroy();
            }
            mostrarSpinner();
            // Inicializa DataTables 
            $('#tablePays').DataTable({
                "aProcessing": true,
                "aServerSide": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "ajax": {
                    "url": base_url + "/Pagos/getPays/" + txtIdentificacion,
                    "dataSrc": function(json) {
                        if (!json.status) {
                            document.getElementById('contain-table-search').classList.add('d-none');
                            Swal.fire("Atención", json.msg, "error");
                            return [];
                        }
                        document.getElementById('contain-table-search').classList.remove('d-none');
                        ocultarSpinner();
                        return json.data;
                    } // respuesta JSON
                },
                "columns": [
                    {"data": "id_pago"},
                    {"data": "nombres"},
                    {"data": "nombre_concepto"},
                    {"data": "fecha_pago"},
                    {"data": "monto"},
                    {"data": "monto_pagado"},
                    {"data": "tipo_pago"},
                    {"data": "estado_pago"},
                    {"data": "observaciones"},
                    {"data": "nombre"},
                    {"data": "mes"}
                ],
                "responsive": true,
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [[0, "desc"]],
                "columnDefs": [
                    {
                        "targets": 8, // Índice de la columna de observaciones
                        "render": function (data, type, row) {
                            return `<div class="text-wrap" style="white-space: normal; width: 200px;">${data}</div>`;
                        }
                    }
                ],
                "dom": 'Bfrtip', // Añadir los botones en el DOM
                "buttons": [
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
                ]

            });
        });
        
    }

    // no pagos
    if(btnNoPays){
        document.getElementById('intMonth').value=month;
        btnNoPays.addEventListener('click', function() {
            let intMes = document.getElementById('intMonth').value;
            let intPeriodo = document.getElementById('periodoNoPay').value;
            let EstadoPago = document.getElementById('EstadoPago').value;
            let conceptoNoPay=document.getElementById('txtConceptoNoPay').value;
        
            if (parseInt(intMes) > 12 || parseInt(intMes) < 1) {
                Swal.fire("Atención", "Valores incorrectos en el la digitacion del mes", "error");
                return false;
            }
            if (parseInt(intPeriodo) < 1) {
                Swal.fire("Atención", "Valores incorrectos en el la digitacion del periodo", "error");
                return false;
            }

            // Destruir la tabla existente si ya está inicializada
            if ($.fn.DataTable.isDataTable('#tableNoPays')) {
                $('#tableNoPays').DataTable().destroy();
                $('#tableNoPays tbody').empty();
            }

            // Actualizar HTML de la tabla en función del estado seleccionado
            let tableHeader = document.querySelector('#tableNoPays thead tr');
            tableHeader.innerHTML = '';

            if (EstadoPago === "Parcial") {
                tableHeader.innerHTML = `
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Nombre del apoderado</th>
                    <th>Numero del Padre</th>
                    <th>Total pagado</th>
                    <th>Monto a pagar</th>
                    <th>Periodo</th>
                    <th>Mes</th>
                `;
            } else if (EstadoPago === "Deuda") {
                tableHeader.innerHTML = `
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Nombre del apoderado</th>
                    <th>Numero del Padre</th>                              
                    <th>Concepto del pago</th>                              
                    <th>Periodo</th>
                    <th>Mes</th>
                `;
            }
             // Configurar columnas dinámicamente
            let columns = [];
            if (EstadoPago === "Parcial") {
                columns = [
                    {"data": "identificacion"},
                    {"data": "nombres"},
                    {"data": "nombre_apoderado"},
                    {"data": "numero_whatsapp"},
                    {"data": "total_pagado"},
                    {"data": "monto_completo"},
                    {"data": "periodo"},
                    {"data": "mes"}
                ];
            } else if (EstadoPago === "Deuda") {
                columns = [
                    {"data": "identificacion"},
                    {"data": "nombres"},
                    {"data": "nombre_apoderado"},
                    {"data": "numero_whatsapp"},
                    {"data": "concepto"},
                    {"data": "periodo"},
                    {"data": "mes"}
                ];
            }
            mostrarSpinner();
            // Inicializa DataTables
            $('#tableNoPays').DataTable({
                "aProcessing": true,
                "aServerSide": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "ajax": {
                    "url": base_url + "/Pagos/getNoPays",
                    "type": "POST",
                    "data": {
                        mes: intMes,
                        periodo: intPeriodo,
                        estado: EstadoPago, 
                        concepto: conceptoNoPay
                    },
                    "dataSrc": function(json) {
                        if (!json.status) {
                            Swal.fire("Atención", json.msg, "error");
                            return [];
                        }
                        ocultarSpinner();
                        return json.data;
                    }
                },
                "columns": columns,
                "responsive": true,
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [[0, "desc"]],
                "dom": 'Bfrtip', // Añadir los botones en el DOM
                "buttons": [
                    {
                        "extend": "copyHtml5",
                        "text": "<i class='bi bi-copy'></i> Copiar",
                        "titleAttr": "Copiar",
                        "className": "btn btn-secondary m-2 rounded"
                    },
                    {
                        "extend": "excelHtml5",
                        "text": "<i class='bi bi-file-earmark-excel'></i> Excel",
                        "titleAttr": "Exportar a Excel ",
                        "className": "btn btn-success m-2 rounded"
                    },
                    {
                        "extend": "pdfHtml5",
                        "text": "<i class='bi bi-file-earmark-pdf'></i> PDF",
                        "titleAttr": "Exportar a PDF",
                        "className": "btn btn-danger m-2 rounded"
                    },
                    {
                        "extend": "csvHtml5",
                        "text": "<i class='bi bi-filetype-csv'></i> CSV",
                        "titleAttr": "Exportar a CSV",
                        "className": "btn btn-info text-white m-2 rounded"
                    }
                ]
            });
        });
        
    }

})
