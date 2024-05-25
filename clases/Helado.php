<?php

    include_once "./clases/ManejadorJson.php";

    class Helado{
        public $id;
        public $sabor;
        public $precio;
        public $tipo;
        public $vaso;
        public $stock;

        public function __construct($sabor,$precio,$tipo,$vaso,$stock){
            $this->id = ManejadorJson::autoincrementarId();
            $this->sabor = $sabor;
            $this->precio = $precio;
            $this->tipo = $tipo;
            $this->vaso = $vaso;
            $this->stock = $stock;
        }

    }

?>