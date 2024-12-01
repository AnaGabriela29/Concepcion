<?php

require_once './Libraries/vendor/barcode/barcode.php';

class Qrcontroller extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
    }

    // public function generate($param) {

    //     try {      

    //         $generator=new barcode_generator();
    //         header('Content-type: image/svg+xml');
    //         $svg=$generator->render_svg("qr", $param,"");
    //         echo $svg;

    //     } catch (Error $e) {
    //         echo "Ocurrió un error al generar el código QR." .$e;
    //     }
    // }  

    public function generate($param, $output = true)
    {
        while (ob_get_level()) {
            ob_end_clean();
        }

        $generator = new barcode_generator();
        $svg = $generator->render_svg("qr", $param, "");

        if (!$output) {
            return $svg;
        } else {
            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        }
    }

    public function idcard($idUser)
    {

        $data['nombre'] = $this->model->searchName($idUser);
        $data['qr'] = $this->generate($idUser);

        $data['page_functions_js'] = media() . "/js/functions_qr.js";
        $this->views->getView($this, "Card", $data);
    }

    public function total_cards()
    {
        // Obtener los datos de la solicitud POST
        $postData = file_get_contents('php://input');
        // Decodificar los datos JSON

        $data = json_decode($postData, true);
        // Verificar si se han recibido los datos correctamente
        if (isset($data['ids_roles'])) {
            $ids_roles = $data['ids_roles'];
            $result = $this->model->searchNames($ids_roles);
            if (!empty($result)) {
                foreach ($result as &$user) {
                    $user['qr'] = $this->generate($user['id_usuario']);
                }
                $arrResponse = array(
                    'status' => 'true',
                    'data' => $result
                );                
            } else {
                $arrResponse = array(
                    'status' => 'false',
                    'msg' => 'Ningun dato encontrado'
                );
            }
        } else {
            // Manejar el caso en el que los datos no se hayan recibido correctamente
            $arrResponse = array(
                'status' => 'false',
                'message' => 'No se recibieron los datos correctamente'
            );
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function showCardsMassive() {
        
        $data['page_functions_js'] = media() . "/js/functions_qr.js";
        $data['multiple'] = true;
        $this->views->getView($this, "Card", $data);
    }
    
}
