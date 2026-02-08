<?php
class CarritoProducto {
    private $id_carrito;
    private $id_producto;
    private $cantidad;
    private $fecha_agregado;

    /**
     * Constructor
     */
    public function __construct(
        $id_carrito = "",
        $id_producto = "",
        $cantidad = 1,
        $fecha_agregado = "",
        $id = ""
    ) {
        $this->id_carrito = $id_carrito;
        $this->id_producto = $id_producto;
        $this->cantidad = $cantidad;
        $this->fecha_agregado = $fecha_agregado;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name = $value;
    }
}
?>