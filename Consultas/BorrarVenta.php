<?php
    include_once "./clases/ManejarFotos.php";
    include_once "./clases/ManejadorJson.php";

    class BorrarVenta{
        public static function Borrar($npedido){
            $archivoJson = new ManejadorJson("./ventas.json");
            $archivoJson->SoftDelete($npedido);
            $elemento = $archivoJson->ConsultaPorNPedido($npedido);
            ManejarFotos::MoverFoto($elemento);
        }
    }