<?php
    include_once "./clases/ManejadorJson.php";
    include_once "./clases/Validador.php";
    class ModificarVenta{
        public static function Modificar($pedido,$email,$sabor,$tipo,$vaso,$stock){
            if(Validador::ValidarTipo($tipo) && Validador::ValidarVaso($vaso)){
                $archivoJson = new ManejadorJson("./ventas.json");
                $archivoJson->ModificarVenta($pedido,$email,$sabor,$tipo,$vaso,$stock);
            }
        }
    }
