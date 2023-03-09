<?php

class Producto extends Controllers{
    public function __construct ()
    {
        parent::__construct();
        
    }

    public function insertar()
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];
            
            if($method =="POST"){
                $_POST=json_decode(file_get_contents('php://input'),true);

                if(empty($_POST['codigo'] or !testEntero($_POST['codigo']))){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el código"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_POST['nombre'] or !testString($_POST['nombre']))){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el nombre"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_POST['descripcion'] )){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"La descripción es obligatoria"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_POST['precio'] or !testEntero($_POST['precio']))){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el precio"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $intCodigo=$_POST['codigo'];
                $strNombre=$_POST['nombre'];
                $strDescripcion= strClean($_POST['descripcion']);
                $intPrecio=$_POST['precio'];

                $request=$this->model->setProducto(
                    $intCodigo,
                    $strNombre,
                    $strDescripcion,
                    $intPrecio
                );

                if(!empty($request)){
                    $response=array(
                        "status"=>true,
                        "msg"=>"Proceso Exitoso",
                        "data"=>$_POST
                    );
                    $code =200;
                }else{
                    $response=array(
                        "status"=>true,
                        "msg"=>"El código del producto ya existe",
                    );
                    $code =400;
                }
            }else{
                $response=array(
                    "status"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "error en el proceso: ".$e->getMessage();
        }
        die();
    }

    public function actualizar($idproducto)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];

            if($method =="PUT"){
                $_PUT=json_decode(file_get_contents('php://input'),true);

                if(empty($idproducto) or !is_numeric($idproducto)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en los parámetros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_PUT['codigo'] or !testEntero($_PUT['codigo']))){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el código"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_PUT['nombre'] or !testString($_PUT['nombre']))){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el nombre"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_PUT['descripcion'] )){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"La descripción es obligatoria"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                if(empty($_PUT['precio'] or !testEntero($_PUT['precio']))){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en el precio"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $intCodigo=$_PUT['codigo'];
                $strNombre=$_PUT['nombre'];
                $strDescripcion= strClean($_PUT['descripcion']);
                $intPrecio=$_PUT['precio'];

                $request_busqueda=$this->model->getProducto($idproducto);

                if(empty($request_busqueda)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"No se encontró el producto"
                    );
                    $code=200;
                    jsonResponse($response,$code);
                    die();
                }
                


                $request=$this->model->updateProducto(
                    $idproducto,
                    $intCodigo,
                    $strNombre,
                    $strDescripcion,
                    $intPrecio
                );

                if(!empty($request)){
                    $response=array(
                        "status"=>true,
                        "msg"=>"Proceso exitoso",
                        "data"=>$_PUT
                    );
                    $code=200;
                }else{
                    $response=array(
                        "status"=>true,
                        "msg"=>"El codigo del producto ya existe",
                    );
                    $code=400;

                }

            }else{
                $response=array(
                    "status"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
                jsonResponse($response,$code);
                die();
            }

            jsonResponse($response,$code);

        } catch (Exception $e) {
            echo "error en el proceso: ".$e->getMessage();
        }
    }

    public function eliminar($idproducto)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];

            if($method =="DELETE"){

                if(empty($idproducto) or !is_numeric($idproducto)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en los parámetros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request_busqueda=$this->model->getProducto($idproducto);

                if(empty($request_busqueda)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"No se encontró el producto"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request_delete=$this->model->deleteProducto($idproducto);

                if(!empty($request_delete)){
                    $response=array(
                        "status"=>false,
                        "msg"=>"Registro eliminado"
                    );
                    $code=200;
                }

                



                

            }else{
                $response=array(
                    "status"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
                
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "error en el proceso: ".$e->getMessage();
        }
        die();
    }

    public function producto($idproducto)
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];

            if($method =="GET"){

                if(empty($idproducto) or !is_numeric($idproducto)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Error en los parámetros"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }

                $request_busqueda=$this->model->getProducto($idproducto);

                if(empty($request_busqueda)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"No se encontró el producto"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }else{
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Búsqueda exitosa",
                        "data"=>$request_busqueda
                    );
                    $code=200;

                }

            }else{
                $response=array(
                    "status"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
                
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "error en el proceso: ".$e->getMessage();
        }
        die();
    }

    public function productos()
    {
        try {
            $method=$_SERVER['REQUEST_METHOD'];
            $response=[];

            if($method =="GET"){

                $request_busqueda=$this->model->getProductos();

                if(empty($request_busqueda)){
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"No se encontraron el productos"
                    );
                    $code=400;
                    jsonResponse($response,$code);
                    die();
                }else{
                    $response=array(
                        "estatus"=>false,
                        "msg"=>"Búsqueda exitosa",
                        "data"=>$request_busqueda
                    );
                    $code=200;

                }

            }else{
                $response=array(
                    "status"=>false,
                    "msg"=>"Error en la solicitud ".$method
                );
                $code=400;
                
            }

            jsonResponse($response,$code);
        } catch (Exception $e) {
            echo "error en el proceso: ".$e->getMessage();
        }
        die();
    }
}