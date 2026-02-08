<?php
class Producto{
    private $id;
    private $titulo;
    private $cover;
    private $platform_id;
    private $descuento;
    private $precio;
    private $modo;
    private $descripcion;
    private $stock;
    private $fecha_lanzamiento;

    /**
     * Constructor
     */
    public function __construct(
        $titulo = "",
        $cover = "",
        $platform_id = "",
        $descuento = 0,
        $precio = 0,
        $modo = "",
        $descripcion = "",
        $stock = 0,
        $fecha_lanzamiento = "",
        $id = ""
    ) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->cover = $cover;
        $this->platform_id = $platform_id;
        $this->descuento = $descuento;
        $this->precio = $precio;
        $this->modo = $modo;
        $this->descripcion = $descripcion;
        $this->stock = $stock;
        $this->fecha_lanzamiento = $fecha_lanzamiento;
    }

    public function __get(string $name): mixed {
        return $this->$name;
    }
    
    public function __set(string $name, mixed $value): void {
        $this->$name=$value;
    }
    
    

}

?>