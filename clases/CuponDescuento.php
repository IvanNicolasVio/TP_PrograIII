<?php
    include_once "./clases/ManejadorJson.php";

    class Cupon{
        public $id;
        public $devolucion_id;
        public $descuento;
        public $estado;

        public function __construct($devolucion_id,$precio){
            $this->id = ManejadorJson::autoincrementarId(3);
            $this->devolucion_id = $devolucion_id;
            $this->descuento = $precio * 0.10;
            $this->estado = "No usado";
        }

        public static function Listar($arrayDevo,$arrayCup){
            foreach($arrayDevo as $devolucion){
                foreach($arrayCup as $cupones){
                    if($devolucion['numeroDePedido'] == $cupones['devolucion_id']){
                        echo json_encode(['Coincidencia' => 'Devolucion: ' . $devolucion['numeroDePedido'] . ' tiene el cupon: ' . $cupones['devolucion_id']]);
                    }
                }
            }
        }

        public static function ListarUsados($arrayDevo,$arrayCup){
            foreach($arrayDevo as $devolucion){
                foreach($arrayCup as $cupones){
                    if($devolucion['numeroDePedido'] == $cupones['devolucion_id']){
                        echo json_encode(['Coincidencia' => 'Devolucion: ' . $devolucion['numeroDePedido'] . ' tiene el cupon: ' . $cupones['devolucion_id'] . ' con estado: ' . $cupones['estado']]);
                    }
                }
            }
        }

    }