<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once './Libraries/vendor/autoload.php';  // Asegúrate de incluir el autoloader de Composer
require_once './Models/PagosModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator extends Controllers {
    public function __construct() {
        parent::__construct();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }

        getPermisos(MPAGOS);
        $this->model = new PagosModel();
    }

    public function imprimirFact() {
        if ($_SESSION['permisosMod']['w']) {
            $idPago = isset($_POST['id_pago']) ? intval($_POST['id_pago']) : (isset($_GET['id_pago']) ? intval($_GET['id_pago']) : 0);
            if ($idPago > 0) {
                $arrData = $this->model->obtenerPago($idPago);

                if ($arrData) {
                    $meses=Meses();
                    $mes=$meses[$arrData['mes']];
                    // Leer el contenido del archivo HTML
                    $htmlFilePath = __DIR__ . '/../Views/Template/Email/email_factura.php';
                    
                    if (!file_exists($htmlFilePath)) {
                        die('HTML template file not found: ' . $htmlFilePath);
                    }

                    $htmlTemplate = file_get_contents($htmlFilePath);

                    // Reemplazar los marcadores de posición con datos reales
                    $logoPath = __DIR__ . '/../Assets/images/logo_unimat.jpg';
                    if (!file_exists($logoPath)) {
                        die('Logo file not found: ' . $logoPath);
                    }
                    $logoPath = realpath($logoPath);
                    $logoPath = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
                    

                    $htmlContent = str_replace(
                        ['{{ logoPath }}', '{{ nombres }}', '{{ fecha_pago }}', '{{ periodo }}', '{{ id_pago }}', '{{ nombre_concepto }}', '{{ monto }}', '{{ monto_pagado }}', '{{ telefono }}', '{{ mes_mensualidad }}', '{{ web_empresa }}', '{{ direccion }}', '{{ email }}', '{{ descripcion }}','{{ whatsapp }}'],
                        [$logoPath, $arrData['nombres'], $arrData['fecha_pago'], $arrData['periodo'], $arrData['id_pago'], $arrData['nombre_concepto'], $arrData['monto'], $arrData['monto_pagado'],$arrData['telefono'],$mes, WEB_EMPRESA, DIRECCION, EMAIL_REMITENTE, DESCRIPCION, WHATSAPP],
                        $htmlTemplate
                    );

                    // Configurar Dompdf
                    $options = new Options();
                    $options->set('isHtml5ParserEnabled', true);
                    $options->set('isRemoteEnabled', true);

                    $dompdf = new Dompdf($options);
                    $dompdf->loadHtml($htmlContent);
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();
                    $dompdf->stream("recibo_pago.pdf", ["Attachment" => false]);
                } else {
                    echo 'No se encontraron datos para el pago especificado.';
                }
            } else {
                echo 'ID de pago no válido.';
            }
        }
    }

    public function generateFactura($idPago) {
        $arrData = $this->model->obtenerPago($idPago);
    
        if ($arrData) {
            $meses=Meses();
            $mes=$meses[$arrData['mes']];
            // Leer el contenido del archivo HTML
            $htmlFilePath = __DIR__ . '/../Views/Template/Email/email_factura.php';
    
            if (!file_exists($htmlFilePath)) {
                die('HTML template file not found: ' . $htmlFilePath);
            }
    
            $htmlTemplate = file_get_contents($htmlFilePath);
    
            // Reemplazar los marcadores de posición con datos reales
            $logoPath = __DIR__ . '/../Assets/images/logo_unimat.jpg';
            if (!file_exists($logoPath)) {
                die('Logo file not found: ' . $logoPath);
            }
    
            $logoPath = realpath($logoPath);
            $logoPath = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
    
            $htmlContent = str_replace(
                ['{{ logoPath }}', '{{ nombres }}', '{{ fecha_pago }}', '{{ periodo }}', '{{ id_pago }}', '{{ nombre_concepto }}', '{{ monto }}', '{{ monto_pagado }}', '{{ telefono }}', '{{ mes_mensualidad }}', '{{ web_empresa }}', '{{ direccion }}', '{{ email }}', '{{ descripcion }}','{{ whatsapp }}'],
                [$logoPath, $arrData['nombres'], $arrData['fecha_pago'], $arrData['periodo'], $arrData['id_pago'], $arrData['nombre_concepto'], $arrData['monto'], $arrData['monto_pagado'],$arrData['telefono'],$mes, WEB_EMPRESA, DIRECCION, EMAIL_REMITENTE, DESCRIPCION, WHATSAPP],
                $htmlTemplate
            );
    
            // Configurar Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
    
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($htmlContent);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
    
            // Guardar el PDF temporalmente
            $outputPath = __DIR__ . '/../Assets/facturaTemp/recibo_pago_' . $idPago . '.pdf';
            file_put_contents($outputPath, $dompdf->output());
    
            return $outputPath;
        } else {
            return false;
        }
    }
    
}
?>
