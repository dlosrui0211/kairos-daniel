<?php
class Valoracion {
    private $id_usuario;
    private $id_producto;
    private $puntuacion;
    private $comentario;
    private $fecha_valoracion;

    /**
     * Constructor
     */
    public function __construct(
        $id_usuario = "",
        $id_producto = "",
        $puntuacion = 5,
        $comentario = "",
        $fecha_valoracion = ""
    ) {
        $this->id_usuario = $id_usuario;
        $this->id_producto = $id_producto;
        $this->puntuacion = $puntuacion;
        $this->comentario = $comentario;
        $this->fecha_valoracion = $fecha_valoracion;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }

    public function __set(string $name, mixed $value): void {
        $this->$name = $value;
    }
}
?>