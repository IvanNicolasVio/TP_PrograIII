<?php
    include_once "./clases/ManejadorJson.php";
    include_once "./clases/ManejarFotos.php";
    include_once "./clases/CuponDescuento.php";

    class DevolverHelado{
        public static function Devolver($numeroPedido,$causaD,$foto){
            $archivoJson = new ManejadorJson("./ventas.json");
            $elemento = $archivoJson->ConsultaPorNPedido($numeroPedido);
            if($elemento && !isset($elemento['eliminado'])){
                ManejarFotos::GuardarFoto($elemento,$foto,3);
                $archivoDevolucion = new ManejadorJson("./devoluciones.json");
                $elemento["causa"] = $causaD;
                $archivoDevolucion->AgregarUno($elemento);
                $cupon = new Cupon($numeroPedido,$elemento['precio']);
                $archivoCupones = new ManejadorJson("./cupones.json");
                $archivoCupones->AgregarUno($cupon);
                echo json_encode(['estado' => 'Se realizo la devolucion']);
            }else{
                echo json_encode(['estado' => 'El numero de pedido NO existe']);
            }
            
        }
    }