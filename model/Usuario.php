<?php
class Usuario{
    private $id;
    private $username;
    private $password;
    private $nombre;
    private $apellidos;
    private $correo;
    private $fecha_nacimiento;
    private $codigo_postal;
    private $telefono;
    private $rol;

    private $fecha_creacion;
    private $activo;


    public function __construct(
        $username = "",
        $password = "",
        $nombre = "",
        $apellidos = "",
        $correo = "",
        $fecha_nacimiento = "",
        $codigo_postal = "",
        $telefono = "",
        $rol = 3,
        $id = "",
        $fecha_creacion = "",
        $activo = true
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->codigo_postal = $codigo_postal;
        $this->telefono = $telefono;
        $this->rol = $rol;
        $this->fecha_creacion = $fecha_creacion;
        $this->activo = $activo;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
    
    

}

?>