<?php
class Conexion {
    private $host = "127.0.0.1:3306";
    private $usu = "dwes";
    private $pass = "abc123.";
    private $bd = "kairos-daniel";
    private $conexion;
    
    public function __construct(){
        try {
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $this->conexion = new PDO(
                "mysql:host=$this->host;dbname=$this->bd", 
                $this->usu, 
                $this->pass, 
                $opciones
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public function getConexion(){
        return $this->conexion;
    }
}

?>