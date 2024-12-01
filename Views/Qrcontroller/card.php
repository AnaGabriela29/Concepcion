<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Main CSS-->

    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/plugins/bootstrap.min.css">
    <title>card</title>
</head>

<body>
    <style>
        /* ================================================ */
        /* ========== Estilos para imprimir  y card =========================== */
        /* ================================================ */

        @font-face {
            font-family: 'GFS Didot';
            src: url('../../Assets/colegio/images/fonts/GFS_Didot/GFSDidot-Regular.ttf') format('ttf');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'GFS Didot', sans-serif;
        }

        .id-card {
            border-radius: 15px;
            padding-top: 1rem;
            background: radial-gradient(circle at 49% 50%, rgb(255, 255, 255) 75%, rgb(238, 121, 0) 25%);
            background-color: rgb(255, 193, 7);
            width: 13rem;
            height: 21rem;
            margin: 10px auto;
        }

        .id-card-header {
            text-align: center;
        }

        .id-card-logo {
            width: 4rem;
            height: 4rem;
        }

        .id-card-content {
            text-align: center;
        }

        .id-card-name {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .id-card-profession {
            margin: 0;
            font-size: 16px;
            color: #888;
        }

        .id-card-qr {
            margin-top: 15px;
            width: 100px;
            height: 100px;
        }

        .id-card-footer {
            text-align: center;
            font-size: 12px;
            letter-spacing: 1px;
        }
        @media screen {
        .card-page {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
    }

    @media print {
        .card-page {
            page-break-after: always;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 10px;
        }

        .id-card {
            break-inside: avoid;
            margin-bottom: 10px;
        }

        /* última página no tenga un salto de página después */
        .card-page:last-child {
            page-break-after: avoid;
        }
    }

        
    </style>

    <div class="id-card <?= isset($data['multiple']) ? 'd-none' : '' ?>">
        <div class=" d-flex align-items-center flex-column">
            <p class="m-0"><b>Unimat</b></p>
            <small class="text-center">“Donde el futuro se forja hoy”</small>
        </div>
        <div class="id-card-header">
            <img src="<?= media() ?>/images/logo_unimat.webp" alt="Logo" class="id-card-logo">
        </div>

        <div class="id-card-content">
            <?php
            foreach ($data['nombre'] as $clave => $valor) {
                if ($clave == 'nombres') {
                    echo "<p class='id-card-name m-0' ><b>$valor</b></p>";
                } elseif ($clave == 'nombrerol') {
                    echo "<p class='id-card-profession m-0'>$valor</p>";
                }
            }
            ?>

        </div>
        <div class="img-qr d-flex justify-content-center">
            <img src="<?= $data['qr'] ?>" alt="QR Code">
        </div>
        <div class="id-card-footer">
            Colegios UNIMAT <br>
            <small>cañete</small>
        </div>
    </div>
    <div class=" text-center">
        <div id="multiple-cards" class="row <?= !empty($data['multiple']) ? '' : 'd-none' ?>">

        </div>

    </div>

</body>
<script>
    let base_url = "<?= base_url() ?>";
</script>
<script src="<?= $data['page_functions_js'] ?>"></script>

</html>