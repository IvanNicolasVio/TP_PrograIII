<?php

    include_once "./clases/ManejadorJson.php";
    include_once "./clases/Helado.php";

    class Venta extends Helado {
        public $email;
        public $fecha;
        public $numeroDePedido;
    
        public function __construct($email, $sabor,$precio, $tipo, $vaso, $stock) {
            parent::__construct($sabor,$precio, $tipo, $vaso, $stock);
            
            $this->precio = $stock * $precio;
            $this->email = $email;
            date_default_timezone_set("America/Buenos_Aires");
            $this->fecha = date("d-m-Y");
            $this->numeroDePedido = rand(1, 10000000);
            $this->id = ManejadorJson::autoincrementarId(2);
        }
    }