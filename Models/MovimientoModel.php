<?php
class MovimientoModel extends Mysql
{
    private $intIdMovimiento;
    private $strMovimineto;
    private $intTipo;
    private $strDescripcion;
    private $intStatus;
    public function __construct()
    {
        parent::__construct();
    }

    public function setMovimiento(string $movimiento, int $tipoMovimiento, string $descripcion)
    {
        $this->strMovimineto = $movimiento;
        $this->intTipo = $tipoMovimiento;
        $this->strDescripcion = $descripcion;

        $query_Busqueda = "SELECT tipo_movimiento FROM tipo_movimiento WHERE tipo_movimiento=:tipo AND status=1";
        $arrData = array(
            ":tipo" => $this->intTipo
        );

        $request = $this->select($query_Busqueda, $arrData);

        if (empty($request)) {

            $query_insert = "INSERT INTO tipo_movimiento (movimiento, tipo_movimiento, descripcion)
                            VALUES (:mov, :tipo, :desp)";
            $arrParams = array(
                ":mov" => $this->strMovimineto,
                ":tipo" => $this->intTipo,
                ":desp" => $this->strDescripcion
            );

            $request_insert=$this->insert($query_insert,$arrParams);
            return $request_insert;
        } else {
            return false;
        }
    }

    public function updateMovimiento(int $idmovimineto, string $movimiento, int $tipoMovimiento, string $descripcion)
    {
        $this->intIdMovimiento=$idmovimineto;
        $this->strMovimineto = $movimiento;
        $this->intTipo = $tipoMovimiento;
        $this->strDescripcion = $descripcion;

        $query_Busqueda = "SELECT tipo_movimiento FROM tipo_movimiento WHERE (tipo_movimiento=:tipo AND idtipomovimiento!=:id)
        AND status=1";
        $arrData = array(
            ":tipo" => $this->intTipo,
            ":id"=>$this->intIdMovimiento
        );

        $request = $this->select($query_Busqueda, $arrData);

        

        if (empty($request)) {

            $query_update = "UPDATE tipo_movimiento SET
            movimiento=:mov,
            tipo_movimiento=:tipo, 
            descripcion=:desp
            WHERE idtipomovimiento=:id";
            $arrParams = array(
                ":mov" => $this->strMovimineto,
                ":tipo" => $this->intTipo,
                ":desp" => $this->strDescripcion,
                ":id"=>$this->intIdMovimiento
            );

            $request_update=$this->insert($query_update,$arrParams);
            return $request_update;
        } else {
            return false;
        }

    }

    public function getMovimiento(int $idmovimineto)
    {
        $this->intIdMovimiento=$idmovimineto;

        $query="SELECT * FROM tipo_movimiento WHERE idtipomovimiento=:id";
        $arrParams=array(
            ":id"=>$this->intIdMovimiento
        );

        $request=$this->select($query,$arrParams);
        return $request;
    }

    public function getMovimientos()
    {
        $query="SELECT * FROM tipo_movimiento";
        $request=$this->select_all($query);
        return $request;
    }

    public function deleteMovimiento($idmovimineto)
    {
        $this->intIdMovimiento=$idmovimineto;

        $query="DELETE FROM tipo_movimiento WHERE idtipomovimiento=:id";
        $arrParams=array(
            ":id"=>$this->intIdMovimiento
        );
        $request=$this->delete($query,$arrParams);
        return $request;
    }
}
