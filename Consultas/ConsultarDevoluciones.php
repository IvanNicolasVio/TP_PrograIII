<?php
    include_once "./clases/ManejadorJson.php";
    include_once "./clases/CuponDescuento.php";

    class ConsultasDevoluciones{
        public static function  ListarDevoluciones(){
            $archivoJson = new ManejadorJson("./devoluciones.json");
            $archivoJsonCupones = new ManejadorJson("./cupones.json");
            $arrayDevo = $archivoJson->TraerJson();
            $arrayCupo = $archivoJsonCupones->TraerJson();
            Cupon::Listar($arrayDevo,$arrayCupo);
        }

        public static function ListarCupones(){
            $archivoJson = new ManejadorJson("./cupones.json");
            $archivoJson->ListarCupon();
        }

        public static function ListarCuponesUsados(){
            $archivoJson = new ManejadorJson("./devoluciones.json");
            $archivoJsonCupones = new ManejadorJson("./cupones.json");
            $arrayDevo = $archivoJson->TraerJson();
            $arrayCupo = $archivoJsonCupones->TraerJson();
            Cupon::ListarUsados($arrayDevo,$arrayCupo);
        }

    }