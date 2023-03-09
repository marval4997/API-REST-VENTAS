<?php

class FrecuenciaModel extends Mysql
{
    private $intIdFrecuencia;
    private $strFrecuencia;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function setFrecuencia(string $frecuencia)
    {
        $this->strFrecuencia = $frecuencia;

        $query = "SELECT * FROM frecuencia WHERE frecuencia=:frec AND status=1";
        $arrParams = array(
            ":frec" => $this->strFrecuencia
        );
        $request = $this->select($query, $arrParams);

        if (empty($request)) {
            $query_insert = "INSERT INTO frecuencia (frecuencia) VALUES(:frec)";
            $arrData = array(
                ":frec" => $this->strFrecuencia
            );

            $request_insert = $this->insert($query_insert, $arrData);
            return $request_insert;
        } else {
            return false;
        }
    }

    public function updateFrecuencia(int $idfrecuecnia, string $frecuencia)
    {
        $this->strFrecuencia = $frecuencia;
        $this->intIdFrecuencia = $idfrecuecnia;

        $query = "SELECT * FROM frecuencia WHERE (idfrecuencia!=:id AND frecuencia=:frec) AND status=1";
        $arrParams = array(
            ":id" => $this->intIdFrecuencia,
            ":frec" => $this->strFrecuencia
        );
        $request = $this->select($query, $arrParams);



        if (empty($request)) {
            $query_update = "UPDATE frecuencia SET frecuencia=:frec WHERE idfrecuencia=:id";
            $arrData = array(
                ":frec" => $this->strFrecuencia,
                ":id" => $this->intIdFrecuencia
            );

            $request_update = $this->update($query_update, $arrData);
            return $request_update;
        } else {
            return false;
        }
    }

    public function Frecuencia(int $idfrecuecnia)
    {
        $this->intIdFrecuencia = $idfrecuecnia;

        $query = "SELECT * FROM frecuencia WHERE idfrecuencia=:id AND status!=0";
        $arrParams = array(
            ":id" => $this->intIdFrecuencia
        );

        $request = $this->select($query, $arrParams);
        return $request;
    }

    public function Frecuencias()
    {
        $query = "SELECT * FROM frecuencia";
        $request = $this->select_all($query);
        return $request;
    }

    public function deleteFrecuencia(int $idfrecuecnia)
    {
        $this->intIdFrecuencia = $idfrecuecnia;

        $query = "DELETE FROM frecuencia WHERE idfrecuencia=:id ";
        $arrParams = array(
            ":id" => $this->intIdFrecuencia
        );

        $request = $this->delete($query, $arrParams);
        return $request;
    }
}
