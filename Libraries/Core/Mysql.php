<?php
class Mysql extends Conexion
{
    private $conexion;
    private $strquery;
    private $arrValues;

    public function __construct()
    {
        $this->conexion=new Conexion();
        $this->conexion= $this->conexion->connect();
    }

    //inserte un registro
    public function insert(string $query, array $arrValues)
    {
        try {
            $this->strquery=$query;
            $this->arrValues=$arrValues;

            $insert=$this->conexion->prepare($this->strquery);
            $resInsert = $insert->execute($this->arrValues);
            $idInsert = $this->conexion->lastInsertId();
            $insert->closeCursor();
            
            return $idInsert;
            

        } catch (Exception $e) {
            $response="Error: ".$e->getMessage();
            return $response;
        }

    
    }


    //devuelve todos los registros
    public function select_all(string $query)
    {
        try {
            $this->strquery=$query;
            
            $execute= $this->conexion->query($this->strquery);
            $request= $execute->fetchall(PDO::FETCH_ASSOC);
            $execute->closeCursor();

            return $request;

        } catch (Exception $e) {
            $response="Error : ".$e->getMessage();
            return $response;
        }
    }
    
    //devuelve un registro
    public function select(string $query, array $arrValues)
    {
        try {
            $this->strquery=$query;
            $this->arrValues=$arrValues;

            $query= $this->conexion->prepare($this->strquery);
            $query-> execute($this->arrValues);
            $request= $query->fetch(PDO::FETCH_ASSOC);
            $query->closeCursor();

            return $request;

        } catch (Exception $e) {
            $response="Error : ".$e->getMessage();
            return $response;
        }
    }

    //metodo para actualizar un registro
    public function update(string $query, array $arrValues)
    {
        

        try {
            $this->strquery=$query;
            $this->arrValues=$arrValues;

            $update = $this->conexion->prepare($this->strquery);
            $restUpdate = $update->execute($this->arrValues);
            $update->closeCursor();
            return $restUpdate;
            //code...
        } catch (Exception $e) {
            $response="Error : ".$e->getMessage();
            return $response;
        }
    }

    //eliminar registro
    public function delete(string $query, array $arrValues)
    {
        try {
            $this->strquery=$query;
            $this->arrValues=$arrValues;

            $delete= $this->conexion->prepare($this->strquery);
            $del=$delete->execute($this->arrValues);
            return $del;

        } catch (Exception $e) {
            $response="Error : ".$e->getMessage();
            return $response;
        }
    }
}