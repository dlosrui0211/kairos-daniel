<?php
class Carrito {
    private $id;
    private $id_usuario;
    private $fecha_creacion;

    /**
     * Constructor
     */
    public function __construct(
        $id_usuario = "",
        $fecha_creacion = "",
        $id = ""
    ) {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->fecha_creacion = $fecha_creacion;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name = $value;
    }
}
?>