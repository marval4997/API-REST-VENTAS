<?php
class ClienteModel extends Mysql
{
    private $intIdCliente;
    private $strIdentifiacion;
    private $strNombre;
    private $strApellido;
    private $intTelefono;
    private $strEmail;
    private $strDireccion;
    private $strNit;
    private $strNombreFiscal;
    private $strDirFiscal;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function setCliente(string $identifiacion, string $nombre, string $apellido, int $telefono, string $email, string $direccion, string $nit, string $nombreFiscal, string $dirFiscal)
    {
        $this->strIdentifiacion = $identifiacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strDireccion = $direccion;
        $this->strNit = $nit;
        $this->strNombreFiscal = $nombreFiscal;
        $this->strDirFiscal = $dirFiscal;


        $sql = "SELECT identificacion,email FROM `cliente` WHERE (email=:email OR identificacion=:ident) AND status=:estado;";
        $arrParams = [
            ":email" => $this->strEmail,
            ":ident" => $this->strIdentifiacion,
            ":estado" => 1
        ];

        $request = $this->select($sql, $arrParams);

        if (!empty($request)) {

            return false;
        } else {
            $query = "INSERT INTO cliente (
            identificacion, nombres, apellidos, telefono, email, direccion, nit, nombrefiscal, direccionfiscal)
            VALUES(:ident, :nom, :ape, :tel, :email, :dir, :nit, :nomFis, :dirFis)";

            $arrData = array(
                ":ident" => $this->strIdentifiacion,
                ":nom" => $this->strNombre,
                ":ape" => $this->strApellido,
                ":tel" => $this->intTelefono,
                ":email" => $this->strEmail,
                ":dir" => $this->strDireccion,
                ":nit" => $this->strNit,
                ":nomFis" => $this->strNombreFiscal,
                ":dirFis" => $this->strNombreFiscal
            );

            $request_insert = $this->insert($query, $arrData);
            return $request_insert;
        }
    }

    //ACTUALIZAR CLIENTE

    public function actualizarCliente(int $idcliente, string $identifiacion, string $nombre, string $apellido, int $telefono, string $email, string $direccion, string $nit, string $nombreFiscal, string $dirFiscal)
    {
        $this->strIdentifiacion = $identifiacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strDireccion = $direccion;
        $this->strNit = $nit;
        $this->strNombreFiscal = $nombreFiscal;
        $this->strDirFiscal = $dirFiscal;
        $this->intIdCliente = $idcliente;

        $query="SELECT identificacion, email FROM cliente WHERE 
        (identificacion=:iden AND idcliente!=:id) OR
        (email=:email AND idcliente!=:id) AND
        status=1";
        $arrParams=array(
            ":id"=>$this->intIdCliente,
            ":iden"=>$this->strIdentifiacion,
            ":email"=>$this->strEmail
        );

        $request=$this->select($query,$arrParams);
        

        if(empty($request) ){
            $queryActualizar="UPDATE cliente SET
            identificacion=:ident,
            nombres=:nom,
            apellidos=:ape,
            telefono=:tel,
            email=:email,
            direccion=:dir,
            nit=:nit,
            nombrefiscal=:nomFis,
            direccionfiscal=:dirFis
            WHERE idcliente=:id;";

            $arrData=array(
                ":ident" => $this->strIdentifiacion,
                ":nom" => $this->strNombre,
                ":ape" => $this->strApellido,
                ":tel" => $this->intTelefono,
                ":email" => $this->strEmail,
                ":dir" => $this->strDireccion,
                ":nit" => $this->strNit,
                ":nomFis" => $this->strNombreFiscal,
                ":dirFis" => $this->strNombreFiscal,
                ":id"=> $this->intIdCliente
            );

            $requestActualizar= $this->update($queryActualizar,$arrData);
            return $requestActualizar;
            
        }else{
            return false;
        }
    }

    public function getClientes()
    {

        $query = "SELECT * FROM cliente 
        WHERE status !=0 ORDER BY idcliente DESC";
        $request = $this->select_all($query);
        return $request;
    }

    public function getCliente($idcliente)
    {
        $this->intIdCliente = $idcliente;

        $query = "SELECT * FROM cliente WHERE idcliente=:id";
        $arrParams = array(
            ":id" => $this->intIdCliente
        );

        $request = $this->select($query, $arrParams);

        return $request;
    }

    public function deleteClientes($idcliente)
    {
        $this->intIdCliente=$idcliente;

        $query="DELETE FROM cliente WHERE idcliente=:id";
        $arrParams=array(
            ":id"=>$this->intIdCliente
        );

        $request=$this->delete($query,$arrParams);

        return $request;
    }
}
