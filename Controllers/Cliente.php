<?php

class Cliente extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cliente($idcliente)
    {
        try {

            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];

            if ($method == "GET") {

                if (empty($idcliente) or !is_numeric($idcliente)) {
                    $response = array(
                        "status" => false,
                        "mensaje" => "Error en los parámetros"
                    );
                    $code = 400;
                    jsonResponse($response, $code);
                    die();
                }

                $request = $this->model->getCliente($idcliente);
                

                if (empty($request)) {
                    $response = array(
                        "estatus" => true,
                        "msg" => "No se encontró el cliente"
                    );
                    $code = 200;

                } else {

                    $response = array(
                        "estatus" => true,
                        "msg" => "Solicitud exitosa",
                        "data" => $request,
                    );
                    $code = 200;
                }
            } else {
                $response = array(
                    "status" => true,
                    "msg" => "Error en la solicitud"
                );
                $code = 400;
            }

            jsonResponse($response, $code);
        } catch (Exception $e) {
            echo "error en el proceso: " . $e->getMessage();
        }
        die();
    }

    public function registro()
    {
        try {

            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];

            if ($method == "POST") {
                $_POST = json_decode(file_get_contents('php://input'), true);


                if (empty($_POST['identificacion'])) {
                    $response = array(
                        'status' => false,
                        'msg' => 'La identificación es obligatoria'
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if (empty($_POST['nombres']) or !testString($_POST['nombres'])) {
                    $response = array(
                        'status' => false,
                        'msg' => 'Error en el nombre'
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if (empty($_POST['apellidos']) or !testString($_POST['apellidos'])) {
                    $response = array(
                        'status' => false,
                        'msg' => 'Error en los apellidos'
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if (empty($_POST['telefono']) or !testEntero($_POST['telefono'])) {
                    $response = array(
                        'status' => false,
                        'msg' => 'Error en el teléfono'
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if (empty($_POST['email']) or !testEmail($_POST['email'])) {
                    $response = array(
                        'status' => false,
                        'msg' => 'Error en el email'
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                if (empty($_POST['direccion'])) {
                    $response = array(
                        'status' => false,
                        'msg' => 'La dirección es obligatoria'
                    );
                    $code = 200;
                    jsonResponse($response, 200);
                    die();
                }

                $strIdentifiacion = $_POST['identificacion'];
                $strNombre = ucwords(strtolower($_POST['nombres']));
                $strApellido = ucwords(strtolower($_POST['apellidos']));
                $intTelefono = $_POST['telefono'];
                $strEmail = strtolower($_POST['email']);
                $strDireccion = strClean($_POST['direccion']);
                $strNit = !empty($_POST['nit']) ? strClean($_POST['nit']) : "";
                $strNombreFiscal = !empty($_POST['nombrefiscal']) ? strClean($_POST['nombrefiscal']) : "";
                $strDirFiscal = !empty($_POST['direccionfiscal']) ? strClean($_POST['nit']) : "";

                $request = $this->model->setCliente(
                    $strIdentifiacion,
                    $strNombre,
                    $strApellido,
                    $intTelefono,
                    $strEmail,
                    $strDireccion,
                    $strNit,
                    $strNombreFiscal,
                    $strDirFiscal
                );



                if ($request > 0) {

                    $arrCliente = array(
                        "idCliente" => $request,
                        "identificacion" => $strIdentifiacion,
                        "nombre" => $strNombre,
                        "apellidos" => $strApellido,
                        "telefono" => $intTelefono,
                        "email" => $strEmail,
                        "direccion" => $strDireccion,
                        "nit" => $strNit,
                        "nombreFiscal" => $strNombreFiscal,
                        "direccionFiscal" => $strDirFiscal
                    );

                    $response = array(
                        'status' => true,
                        'msg' => 'Datos guardados cortamente',
                        'data' => $arrCliente
                    );
                } else {
                    $response = array(
                        'status' => false,
                        'msg' => 'La identificación o el email ya existen'
                    );
                    $code = 200;
                }
            } else {
                $response = array(
                    'status' => false,
                    'msg' => 'Error en la solicitud ' . $method
                );
                $code = 400;
            }

            $code = 200;
            jsonResponse($response, $code);
            die();
        } catch (Exception $e) {
            echo "error en el proceso" . $e->getMessage();
        }
        die();
    }

    public function clientes()
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];

            if ($method == "GET") {

                $clientes = $this->model->getClientes();


                if (!empty($clientes)) {
                    $response = array(
                        "status" => true,
                        "msg" => "Solicitud exitosa",
                        "data" => $clientes,
                    );
                    $code = 200;
                } else {
                    $response = array(
                        "status" => true,
                        "msg" => "No se encontraron registros"
                    );
                    $code = 200;
                }
            } else {
                $response = array(
                    "estatus" => true,
                    "msg" => "Error en la solicitud"
                );
                $code = 400;
            }

            jsonResponse($response, $code);
        } catch (Exception $e) {
            echo "error en el proceso: " . $e->getMessage();
        }
        die();
    }

    public function actualizar($idcliente)
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $response = [];

            



            if ($method == 'PUT') {
                $_PUT = json_decode(file_get_contents('php://input'), true);

                if (empty($idcliente) or !is_numeric($idcliente)) {
                    $response = array(
                        "status" => "false",
                        "msg" => "Error en los parámetros"
                    );
                    $code = 400;
                    jsonResponse($response, $code);
                    die();
                }

                if (empty($_PUT['identificacion'])) {
                    $response = array(
                        "status" => "false",
                        "msg" => "La identificación es obligatoria"
                    );
                    $code = 200;
                    jsonResponse($response, $code);
                    die();
                }

                if (empty($_PUT['nombres']) or !testString($_PUT['nombres'])) {
                    $response = array(
                        "status" => "false",
                        "msg" => "El nombre es obligatorio"
                    );
                    $code = 200;
                    jsonResponse($response, $code);
                    die();
                }

                if (empty($_PUT['apellidos']) or !testString($_PUT['apellidos'])) {
                    $response = array(
                        "status" => "false",
                        "msg" => "El apellido es obligatorio"
                    );
                    $code = 200;
                    jsonResponse($response, $code);
                    die();
                }

                if (empty($_PUT['telefono']) or !testEntero($_PUT['telefono'])) {
                    $response = array(
                        "status" => "false",
                        "msg" => "El teléfono es obligatorio"
                    );
                    $code = 200;
                    jsonResponse($response, $code);
                    die();
                }

                if (empty($_PUT['email']) or !testEmail($_PUT['email'])) {
                    $response = array(
                        "status" => "false",
                        "msg" => "El email es obligatoria"
                    );
                    $code = 200;
                    jsonResponse($response, $code);
                    die();
                }

                if (empty($_PUT['direccion'])) {
                    $response = array(
                        "status" => "false",
                        "msg" => "La dirección es obligatoria"
                    );
                    $code = 200;
                    jsonResponse($response, $code);
                    die();
                }

                $strIdentifiacion = strClean($_PUT['identificacion']);
                $strNombre = ucwords(strtolower($_PUT['nombres']));
                $strApellido = ucwords(strtolower($_PUT['apellidos']));
                $intTelefono = $_PUT['telefono'];
                $strEmail = strtolower($_PUT['email']);
                $strDireccion = strClean($_PUT['direccion']);
                $strNit = !empty($_PUT['nit']) ? strClean($_PUT['nit']) : "";
                $strNombreFiscal = !empty($_PUT['nombrefiscal']) ? strClean($_PUT['nombrefiscal']) : "";
                $strDirFiscal = !empty($_PUT['direccionfiscal']) ? strClean($_PUT['nit']) : "";

                $request=$this->model->getCliente($idcliente);

                if(empty($request)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"El cliente no existe"
                    );
                    $code= 400;
                    jsonResponse($response,$code);
                    die();
                }

                $request = $this->model->actualizarCliente(
                    $idcliente,
                    $strIdentifiacion,
                    $strNombre,
                    $strApellido,
                    $intTelefono,
                    $strEmail,
                    $strDireccion,
                    $strNit,
                    $strNombreFiscal,
                    $strDirFiscal,
                );



                if ($request) {

                    $arrCliente = array(
                        "idCliente" => $request,
                        "identificacion" => $strIdentifiacion,
                        "nombre" => $strNombre,
                        "apellidos" => $strApellido,
                        "telefono" => $intTelefono,
                        "email" => $strEmail,
                        "direccion" => $strDireccion,
                        "nit" => $strNit,
                        "nombreFiscal" => $strNombreFiscal,
                        "direccionFiscal" => $strDirFiscal
                    );

                    $response = array(
                        'status' => true,
                        'msg' => 'Datos guardados cortamente',
                        'data' => $arrCliente
                    );
                } else {
                    $response = array(
                        "status" => true,
                        "msg" => "El correo o la identificación ya existen"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Error en la petición " . $method
                );
                $code = 400;
            }

            $code = 200;
            jsonResponse($response, $code);
            die();
        } catch (Exception $e) {
            echo "error en el proceso: " . $e->getMessage();
        }
        die();
    }


    public function eliminar($idcliente)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];
            

            if($method=="DELETE"){

                if(empty($idcliente) or !is_numeric($idcliente)){
                    $response=array(
                        "esatus"=>false,
                        "msg"=>"Error en los parámetros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $requestBusqueda=$this->model->getCliente($idcliente);

                if(empty($requestBusqueda)){
                    $response=array(
                        "esatus"=>false,
                        "msg"=>"El usuario no existe"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }
                
                $request=$this->model->deleteClientes($idcliente);

                dep($request);

            }else{
                $response=array(
                    "status"=>true,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
                jsonResponse($response, $code);
                die();
            }
            $code=200;
            jsonResponse($response, $code);
            die();
        } catch (Exception $e) {
            echo "error en el proceso: " . $e->getMessage();
        }
        die();
    }
}
