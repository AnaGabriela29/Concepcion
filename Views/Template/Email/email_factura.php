<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        
        .container {
            width: 100%;
            max-width: 600px;
            padding: 2rem;            
            
        }
        .header {
            position: relative;
            /* margin-bottom: 2rem; */
                    
        }
        .info-pay{
            position: relative;
        }
        .header img {
           
            width: 200px;
            display: block;
            margin: 0 auto;
        }
        .logo_info {
            float: left;
        }       
        .title h1{
            background-color: #00B8A9;
            color: white;
            padding: 1rem;
            border-radius: 1rem;
        }
        .logo_info h5 {
            margin-top: 2rem;
            display: block;
        }
            
        .header .title {            
            float: right;
        }
        .clear {
            clear: both;
        }

        .contact-info{
            float: left;
            margin-left: 2rem ;
        }
        .contact-info span {
            display: block;
        }
        .method-pay{
            margin-top:2.5rem ;
            float: right;
        }
        .method-pay span{
            display: block;
        }


        .table {
            width: 100%;
            border-collapse: collapse;   
            margin-top: 2rem;            
        }
        .table td{
            padding: 1rem;
            margin: 0.5rem;
            text-align: left;
        }
        .table th {            
            color: white;
            margin: 0.5rem;
            padding: 1rem;
            text-align: left;
        }
        .table th:nth-child(1){
            border-radius: 1rem 0 0 1rem;
        }
        .table th:nth-child(4){
            border-radius: 0 1rem 1rem 0;
        }
        .color-turquesa{
            color: #00B8A9;
        }
        .bg-color-turquesa{
            background-color: #00B8A9;
        }
        .color-black-light{
            color: #2A2A28;
        }
        .total {
            margin-top: 20px;
            text-align: right;
        }
        .total h2 {
            font-size: 16pt;
            
        }
        .footer {
            text-align: center;
            font-size: 10pt;
            color: #666;
            margin-top: 8rem;
        }
        
    </style>
</head>
<body>
    <div class="bar-left">

    </div>
    <div class="container">
        <div class="header">
            <div class="logo_info">
                <img src="{{ logoPath }}" alt="Logo">            
                <h5 class="color-turquesa">“UNIMAT donde el futuro se forja hoy”</h5>
            </div>
            <div class="title">
                <h1 class="">Recibo de pago</h1>
                <h5><span class="color-turquesa">Fecha:</span> <span class="color-black-light">{{ fecha_pago }}</span> </h5>
                <h5><span class="color-turquesa">Factura:</span> <span class="color-black-light">N° {{ id_pago }}</span> </h5>
            </div>
            <div class="clear"></div>
        </div>    
        </div>

        <div class="info-pay">
            <div class="contact-info">
                <h1 class="color-turquesa">{{ nombres }}</h1>
                <span>San Vicente de Cañete</span>
                <span>n°: {{ telefono }}</span>
                <span>{{ web_empresa }}</span>
            </div>
            <div class="method-pay">
                <h4 class="color-turquesa">Metodo de pago</h4>
                <span>Metodo: efectivo</span>
                <span>Correo: {{ email }}</span>
            </div>
            <div class="clear"></div>
        </div>
                
        <table class="table">
            <thead class="bg-color-turquesa">
                <tr>
                    <th class="">CONCEPTO</th>
                    <th class="">Mes</th>
                    <th class="">Monto</th>
                    <th class="">Monto pagado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ nombre_concepto }}</td>
                    <td class="">{{ mes_mensualidad }}</td>
                    <td class="">{{ monto }}</td>
                    <td class="">{{ monto_pagado }}</td>
                </tr>
            </tbody>
        </table>
        <div class="total color-turquesa">
            <h2>Total pagado: {{ monto_pagado }}</h2>
        </div>
        
        <div class="footer">
            <hr class="color-turquesa">
            <p><b class="color-turquesa">¡Gracias por su pago!</b> Si tiene alguna pregunta, por favor contacte con nosotros. {{ whatsapp }}</p>
            <p>Av. 28 de julio N° 665, San Vicente de Cañete,   www.colegiosunimat.com</p>
        </div>
    </div>
</body>
</html>
