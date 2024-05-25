<?php
    include_once "./clases/ManejadorJson.php";
    include_once "./clases/Validador.php";

    class ConsultasVentas{
        public static function  ListarCantidad($dia){
            $archivoJson = new ManejadorJson("./ventas.json");
            $cantidad = $archivoJson->ConsultaPorDia($dia);
            echo json_encode(['Ventas' => 'El total vendido es de ' . $cantidad]);
        }

        public static function ListarPorUsuario($usuario){
            $archivoJson = new ManejadorJson("./ventas.json");
            $arrayVentas = $archivoJson->ConsultaPorUsuario($usuario);
            echo json_encode($arrayVentas);
        }

        public static function ListarPorFechas($fechaUno,$fechaDos){
            $archivoJson = new ManejadorJson("./ventas.json");
            $arrayFechas = $archivoJson->ConsultaPorFechas($fechaUno,$fechaDos);
            echo json_encode($arrayFechas);
        }

        public static function ListarPorSabor($sabor){
            $archivoJson = new ManejadorJson("./ventas.json");
            $arrayVentas = $archivoJson->ConsultaPorSabor($sabor);
            echo json_encode($arrayVentas);
        }

        public static function ListarPorVaso($vaso){
            if(Validador::ValidarVaso($vaso) ){
                $archivoJson = new ManejadorJson("./ventas.json");
                $arrayVentas = $archivoJson->ConsultaPorVaso($vaso);
                echo json_encode($arrayVentas);
            }
        }
    }