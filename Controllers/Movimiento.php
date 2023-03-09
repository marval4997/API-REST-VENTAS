<?php
class Movimiento extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertar()
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];

            if($method=="POST"){
                $_POST=json_decode(file_get_contents('php://input'),true);

                if(empty($_POST['movimiento']) or !testString($_POST['movimiento'])){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el movimiento"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_POST['tipomovimiento']) or !testEntero($_POST['tipomovimiento'])){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el tipo de movimiento"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_POST['descripcion']) ){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en la descripción"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $strMovimiento=$_POST['movimiento'];
                $intTipoMov=$_POST['tipomovimiento'];
                $strDescripcion=strClean($_POST['descripcion']);

                $request=$this->model->setMovimiento(
                    $strMovimiento,
                    $intTipoMov,
                    $strDescripcion
                );

                if(!empty($request)){
                    $response=array(
                        "status"=>true,
                        "msg"=>"Proceso exitoso",
                        "data"=>$_POST,
                    );
                    $code=200;
                    
                }else{
                    $response=array(
                        "status"=>true,
                        "msg"=>"El movimiento ya existe"
                    );
                    $code=400;
                }

                    
            }else{
                $response=array(
                    "estatus"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }

            jsonResponse($response,$code);

        } catch (Exception $e) {
            echo "Error en el proceso:" .$e->getMessage();
        }
        die();
    }

    public function actualizar($idmovimiento)
    {
        try {
            $method=$_SERVER["REQUEST_METHOD"];
            $response=[];

            if($method=="PUT"){
                $_PUT= json_decode(file_get_contents('php://input'),true);

                if(empty($idmovimiento) or !is_numeric($idmovimiento)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en los parámetros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }


                if(empty($_PUT['movimiento']) or !testString($_PUT['movimiento'])){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el movimiento"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_PUT['tipomovimiento']) or !testEntero($_PUT['tipomovimiento'])){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el tipo de movimiento"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_PUT['descripcion']) ){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en la descripción"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $strMovimiento=$_PUT['movimiento'];
                $intTipoMov=$_PUT['tipomovimiento'];
                $strDescripcion=strClean($_PUT['descripcion']);

                $request_busqueda=$this->model->getMovimiento($idmovimiento);

                if(empty($request_busqueda)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"No se encontró el movimiento"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request=$this->model->updateMovimiento(
                    $idmovimiento,
                    $strMovimiento,
                    $intTipoMov,
                    $strDescripcion
                );


                if(!empty($request)){
                    $response=array(
                        "status"=>true,
                        "msg"=>"Proceso exitoso",
                        "data"=>$_PUT,
                    );
                    $code=200;
                    
                }else{
                    $response=array(
                        "status"=>true,
                        "msg"=>"El movimiento ya existe"
                    );
                    $code=400;
                }


            }else{
                $response=array(
                    "estatus"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;

            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "Error en el proceso:" .$e->getMessage();
        }
        die();
    }

    public function movimiento($idmovimiento)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];

            if($method=="GET"){
                if(empty($idmovimiento) or !is_numeric($idmovimiento)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en los parámetros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request=$this->model->getMovimiento($idmovimiento);

                if(!empty($request)){
                    $response=array(
                        "estatus"=>true,
                        "msg"=>"Búsqueda exitosa",
                        "data"=>$request
                    );
                    $code=200;

                }else{
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"No se encontraron resultados"
                    );
                    $code=400;

                }

            }else{
                $response=array(
                    "estatus"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "Error en el proceso ".$e->getMessage();
        }
        die();
    }

    public function movimientos()
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];

            if($method=="GET"){


                $request=$this->model->getMovimientos();

                if(!empty($request)){
                    $response=array(
                        "estatus"=>true,
                        "msg"=>"Búsqueda exitosa",
                        "data"=>$request
                    );
                    $code=200;

                }else{
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"No se encontraron resultados"
                    );
                    $code=400;

                }

            }else{
                $response=array(
                    "estatus"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "Error en el proceso ".$e->getMessage();
        }
        die();
    }

    public function eliminar($idmovimiento)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];

            if($method=="DELETE"){
                if(empty($idmovimiento) or !is_numeric($idmovimiento)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en los parámetros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request=$this->model->getMovimiento($idmovimiento);

                if(empty($request)){
                    $response=array(
                        "estatus"=>true,
                        "msg"=>"El registro no existe",
                        "data"=>$request
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request_delete=$this->model->deleteMovimiento($idmovimiento);

                if(!empty($request_delete)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"Registro eliminado"
                    );
                    $code=200;
                }

            }else{
                $response=array(
                    "estatus"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "Error en el proceso ".$e->getMessage();
        }
        die();
    }
} 