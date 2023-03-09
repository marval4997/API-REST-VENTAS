<?php
class ProductoModel extends Mysql
{
    private $intIdproducto;
    private $intCodigo;
    private $strNombre;
    private $strDescripcion;
    private $fltPrecio;
    private $inrStatus;
    public function __construct()
    {
        parent::__construct();
    }

    public function setProducto(int  $codigo, string $nombre, string $descripcion, float $precio)
    {
        $this->intCodigo = $codigo;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->fltPrecio = $precio;

        $query = "SELECT codigo FROM producto WHERE codigo=:cod AND status=1";
        $arrParams = array(
            ":cod" => $this->intCodigo
        );

        $request = $this->select($query, $arrParams);

        if (empty($request)) {
            $query_insert="INSERT INTO producto(codigo, nombre, descripcion,  precio) VALUES(:cod, :nom, :desp, :pre)";
            $arrData=array(
                ":cod"=>$this->intCodigo,
                ":nom"=>$this->strNombre,
                ":desp"=>$this->strDescripcion,
                ":pre"=>$this->fltPrecio
            );

            $request_insert=$this->insert($query_insert,$arrData);
            return $request_insert;

        } else {
            return false;
        }
    }

    public function updateProducto(int $idproducto, int  $codigo, string $nombre, string $descripcion, float $precio)
    {
        $this->intIdproducto= $idproducto;
        $this->intCodigo = $codigo;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->fltPrecio = $precio;

        $query="SELECT codigo FROM producto WHERE 
        (codigo=:cod AND idproducto!=:id ) AND status=1";

        $arrParams=array(
            ":cod"=>$this->intCodigo,
            ":id"=>$this->intIdproducto
        );

        $request=$this->select($query,$arrParams);

        if(empty($request)){
            $query_update="UPDATE producto SET
            codigo=:cod,
            nombre=:nom,
            descripcion=:desp,
            precio=:pre
            WHERE idproducto=:id";

            $arrData=array(
                ":cod"=>$this->intCodigo,
                ":nom"=>$this->strNombre,
                ":desp"=>$this->strDescripcion,
                ":pre"=>$this->fltPrecio,
                ":id"=>$this->intIdproducto
            );

            $request_update=$this->update($query_update,$arrData);
            return $request_update;

        }else{
            return false;
        }
    }

    public function getProducto(int $idproducto)
    {
        $this->intIdproducto=$idproducto;

        $query="SELECT * FROM producto WHERE idproducto=:id";
        $arrParams=array(
            ":id"=>$this->intIdproducto
        );
        $request=$this->select($query,$arrParams);
        return $request;
    }

    public function getProductos()
    {
        $query="SELECT * FROM producto";
        $request=$this->select_all($query);
        return $request;
    }

    public function deleteProducto($idproducto)
    {
        $this->intIdproducto=$idproducto;

        $query="DELETE FROM producto WHERE idproducto=:id";
        $arrParams=array(
            ":id"=>$this->intIdproducto
        );

        $request=$this->delete($query,$arrParams);
        return $request;
    }
}
