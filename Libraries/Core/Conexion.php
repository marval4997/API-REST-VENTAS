<?php
class Conexion{
    
    private $conect;

    public function __construct()
    {
        if(CONNECTION){
            try {
                $connectionString="mysql:host=".DB_HOTS.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $this->conect = new PDO($connectionString, DB_USER, DB_PASSWORD);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              //  echo "Conexion exitosa";
            }catch(PDOException $e){
                $this->conect ="Error de conexion";
                echo "ERROR: ".$e->getMessage();
    
            }

        }
        
    }

    public function connect(){
        return $this->conect;
    }
}
