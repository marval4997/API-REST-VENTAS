<?php

class Frecuencia extends Controllers
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
            if($method == "POST"){
                $_POST=json_decode(file_get_contents("php://input"),true);

                if(empty($_POST['frecuencia']) or !testString($_POST['frecuencia'])){
                    $response=array(
                    "status"=>false,
                    "msg"=>"Error en la frecuencia"
                );
                $code=400;
                jsonResponse($response,$code);
                die();
                }

                $strFrecuencia=$_POST['frecuencia'];

                $request=$this->model->setFrecuencia($strFrecuencia);
                
                if(!empty($request)){
                    $response=array(
                        "status"=>true,
                        "msg"=>"Proceso exitoso",
                        "data"=>$_POST
                    );
                    $code=200;
                }else{
                    $response=array(
                        "status"=>true,
                        "msg"=>"La frecuencia ya existe",
                        "data"=>""
                    );
                    $code=200;
                }

            }else{
                $response=array(
                    "status"=>true,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "error en el proceso ".$e->getMessage();
        }
        die();
    }

    public function actualizar($idFrecuencia)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];
            if($method=="PUT"){
                $_PUT=json_decode(file_get_contents("php://input"),true);

                if(empty($idFrecuencia) or !is_numeric($idFrecuencia)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"error en los parametros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_PUT['frecuencia']) or !testString($_PUT['frecuencia'])){
                    $response=array(
                    "status"=>false,
                    "msg"=>"Error en la frecuencia"
                );
                $code=400;
                jsonResponse($response,$code);
                die();
                }

                $request_busqueda=$this->model->Frecuencia($idFrecuencia);
                if(empty($request_busqueda)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"No se encontró la Frecuencia"
                    );
                    $code=200;
                    jsonResponse($response,$code);
                    die();
                }


                $strFrecuencia=$_PUT['frecuencia'];

                $request=$this->model->updateFrecuencia($idFrecuencia,$strFrecuencia);

                if(!empty($request)){
                    $response=array(
                        "status"=>true,
                        "msg"=>"Proceso exitoso",
                        "data"=>$_PUT
                    );
                    $code=200;
                }else{
                    $response=array(
                        "status"=>false,
                        "msg"=>"La frecuencia ya existe",
                        "data"=>""
                    );
                    $code=400;
                }


            }else{
                $response=array(
                    "status"=>true,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "error en el proceso ".$e->getMessage();
        }
        die();
    }

    public function frecuencia($idFrecuencia)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];
            if($method=="GET"){
                
                if(empty($idFrecuencia) or !is_numeric($idFrecuencia)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"error en los parametros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request_busqueda=$this->model->Frecuencia($idFrecuencia);
                if(!empty($request_busqueda)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"Búsqueda exitosa",
                        "data"=>$request_busqueda
                    );
                    $code=200;
                }else{
                    $response=array(
                        "status"=>false,
                        "msg"=>"No se encontró la Frecuencia"
                    );
                    $code=200;
                }




            }else{
                $response=array(
                    "status"=>true,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }
            jsonResponse($response,$code);
            die();
        } catch (Exception $e) {
            echo "error en el proceso ".$e->getMessage();
        }
        die();
    }

    public function frecuencias()
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];
            if($method=="GET"){

                $request_busqueda=$this->model->Frecuencias();
                if(!empty($request_busqueda)){
                    $response=array(
                        "status"=>true,
                        "msg"=>"Búsqueda exitosa",
                        "data"=>$request_busqueda
                    );
                    $code=200;
                }else{
                    $response=array(
                        "status"=>false,
                        "msg"=>"No se encontraron resultados"
                    );
                    $code=200;
                }




            }else{
                $response=array(
                    "status"=>true,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }
            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "error en el proceso ".$e->getMessage();
        }
        die();
    }

    public function eliminar($idFrecuencia)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];
            if($method=="DELETE"){
                
                if(empty($idFrecuencia) or !is_numeric($idFrecuencia)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"error en los parametros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request_busqueda=$this->model->Frecuencia($idFrecuencia);

                if(empty($request_busqueda)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"No se encontró la frecuencia",
                        "data"=>$request_busqueda
                    );
                    $code=200;
                    jsonResponse($response,$code);
                    die();
                }

                $request_delete=$this->model->deleteFrecuencia($idFrecuencia);

                if(!empty($request_delete)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"Frecuencia eliminada correctamente"
                    );
                    $code=200;
                }




            }else{
                $response=array(
                    "status"=>true,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }
            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "error en el proceso ".$e->getMessage();
        }
        die();
    }
}