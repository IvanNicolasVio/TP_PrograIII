<?php
    class ManejadorJson{

        private $_archivo;

        public function __construct($stringArchivo){
            $this->_archivo = $stringArchivo;
        }

        public function TraerJson()
        {
            if(file_exists($this->_archivo))
            {
                $datosJson = file_get_contents($this->_archivo);
                $array = json_decode($datosJson,true);
            }
            else
            {
                $array = array();
            }
            return $array;
        }

        public function CargarDatos($datosJsonNuevos)
        {
            $datosJsonNuevos = json_encode($datosJsonNuevos);

            $archivo = fopen($this->_archivo,'w');
            if($archivo)
            {
                fwrite($archivo,$datosJsonNuevos);
                fclose($archivo);

                echo json_encode(['datos cargados' => ' en ' . $this->_archivo]);
            }else
            {
                echo json_encode(['error al cargar los datos' => ' en ' . $this->_archivo]);
            }
        }

        public function AgregarUno($objeto)
        {
            $array = $this->TraerJson();
            $array[] = $objeto;
            $array = json_encode($array);

            $archivo = fopen($this->_archivo,'w');
            if($archivo)
            {
                fwrite($archivo,$array);
                fclose($archivo);

                echo json_encode(['datos cargados' => ' en ' . $this->_archivo]);
            }else
            {
                echo json_encode(['error al cargar los datos' => ' en ' . $this->_archivo]);
            }
        }

        public function ActualizarJson($cuenta)
        {
            $array = $this->TraerJson();
            $banderaEncontrado = false;
            foreach($array as $indice => $elemento)
            {
                if($array[$indice]['sabor'] == $cuenta->sabor && $array[$indice]['tipo'] == $cuenta->tipo)
                {
                    $banderaEncontrado = true;  
                    break;
                }
            }
            if($banderaEncontrado)
            {
                $array[$indice]['precio'] = $cuenta->precio;
                $array[$indice]['stock'] += $cuenta->stock;
                echo json_encode(['saldo y saldo' => 'actualizado']);
            }
            else
            {
                $array[] = $cuenta;
            }    
            json_encode($array);
            $this->CargarDatos($array);
            return $banderaEncontrado;
        }

        public function RestarStock($cuenta)
        {
            $array = $this->TraerJson();
            $banderaEncontrado = false;
            foreach($array as $indice => $elemento)
            {
                if($array[$indice]['sabor'] == $cuenta->sabor && $array[$indice]['tipo'] == $cuenta->tipo)
                {
                    $banderaEncontrado = true;  
                    break;
                }
            }
            if($banderaEncontrado)
            {
                $array[$indice]['stock'] -= $cuenta->stock;
                echo json_encode(['stock' => 'actualizado']);
            }
            else
            {
                $array[] = $cuenta;
            }    
            json_encode($array);
            $this->CargarDatos($array);
            return $banderaEncontrado;
        }

        public function ConsultaJson($tipo,$sabor)
        {
            $array = $this->TraerJson();
            $banderaSabor = false;
            $banderaTipo = false;
            $arrayDevuelto = [];
            foreach($array as $indice => $elemento)
            {
                if ($elemento['sabor'] == $sabor)
                {
                    $banderaSabor = true;
                    if ($elemento['tipo'] == $tipo)
                    {
                        $banderaTipo = true;
                        echo json_encode(['estado' => 'existe']);
                        $arrayDevuelto[] = $elemento;
                        return $arrayDevuelto;
                    }
                }
            }

            if ($banderaSabor && !$banderaTipo)
            {
                echo json_encode(['estado' => 'no existe el tipo']);
            }
            elseif (!$banderaSabor)
            {
                echo json_encode(['estado' => 'no existe el sabor']);
            }
            return false;
        }

        public function ConsultaPorDia($dia = "")
        {
            $array = $this->TraerJson();
            $stock = 0;
            if($dia == ""){
                date_default_timezone_set("America/Buenos_Aires");
                $dia = date('d-m-Y', strtotime('-1 day'));
            }
            foreach($array as $indice => $elemento)
            {
                if($array[$indice]['fecha'] == $dia)
                {
                    $stock +=  $array[$indice]['stock'];
                }
            }
            return $stock;
        }

        public function ConsultaPorUsuario($usuario)
        {
            $array = $this->TraerJson();
            $arrayVentas = [];
            foreach($array as $indice => $elemento)
            {
                if($elemento['email'] == $usuario)
                {
                    $arrayVentas[] = $elemento;
                }
            }
            return $arrayVentas;
        }

        public function ConsultaPorFechas($fechaUno,$fechaDos)
        {
            $array = $this->TraerJson();
            $arrayFechas = [];
            foreach($array as $indice => $elemento)
            {
                if($elemento['fecha'] >= $fechaUno && $elemento['fecha'] <= $fechaDos)
                {
                    $arrayFechas[] = $elemento;
                }
            }

            usort($arrayFechas, function($a, $b) {
                return strcmp($a['email'], $b['email']);
            });

            return $arrayFechas;
        }

        public function ConsultaPorSabor($sabor)
        {
            $array = $this->TraerJson();
            $arrayVentas = [];
            foreach($array as $indice => $elemento)
            {
                if($elemento['sabor'] == $sabor)
                {
                    $arrayVentas[] = $elemento;
                }
            }
            return $arrayVentas;
        }

        public function ConsultaPorVaso($vaso)
        {
            $array = $this->TraerJson();
            $arrayVentas = [];
            foreach($array as $indice => $elemento)
            {
                if($elemento['vaso'] == $vaso)
                {
                    $arrayVentas[] = $elemento;
                }
            }
            return $arrayVentas;
        }

        public function ModificarVenta($pedido,$email,$sabor,$tipo,$vaso,$stock)
        {
            $array = $this->TraerJson();
            $banderaModificacion = false;
            foreach($array as $indice => $elemento)
            {
                if($array[$indice]['numeroDePedido'] == $pedido)
                {
                    $array[$indice]['email'] = $email;
                    $array[$indice]['sabor'] = $sabor;
                    $array[$indice]['tipo'] = $tipo;
                    $array[$indice]['vaso'] = $vaso;
                    $array[$indice]['stock'] = $stock;
                    $banderaModificacion = true;
                }
            }   
            if($banderaModificacion){
                json_encode($array);
                $this->CargarDatos($array);
                echo json_encode(['Ventas' => 'La venta N°' . $pedido . ' fue modificada']);
            }else{
                echo json_encode(['Ventas' => 'La venta N°' . $pedido . ' NO existe']);
            }

        }

        public function ConsultaPorNPedido($NPedido){
            $array = $this->TraerJson();
            foreach($array as $indice => $elemento)
            {
                if($elemento['numeroDePedido'] == $NPedido)
                {
                    return $elemento;
                }
            }
            return false;
        }

        public function SoftDelete($NPedido){
            $array = $this->TraerJson();
            foreach($array as $indice => $elemento)
            {
                if($array[$indice]['numeroDePedido'] == $NPedido)
                {
                    $array[$indice]['eliminado'] = "eliminado";
                    echo json_encode(['ESTADO' => 'Pedido N°' . $NPedido . ' ELIMINADO']);
                    break;
                }
            }
            json_encode($array);
            $this->CargarDatos($array);
        }

        public function DevolverCupon($ncupon){
            $array = $this->TraerJson();
            $cupon = false;
            foreach($array as $indice => $elemento)
            {
                if($array[$indice]['devolucion_id'] == $ncupon)
                {
                    $array[$indice]['estado'] = "usado";
                    $cupon = $elemento;
                }
            }
            return $cupon;
        }

        public function CancelarCupon($ncupon){
            $array = $this->TraerJson();
            foreach($array as $indice => $elemento)
            {
                if($array[$indice]['devolucion_id'] == $ncupon)
                {
                    $array[$indice]['estado'] = "usado";
                }
            }
            json_encode($array);
            $this->CargarDatos($array);
        }

        public function ListarCupon(){
            $array = $this->TraerJson();
            foreach($array as $indice => $elemento)
            {
                echo json_encode(['CUPON' => 'N° ' . $array[$indice]['devolucion_id'] . ' Estado: ' . $array[$indice]['estado']]);
            }
        }

        public static function autoincrementarId($identificador = 1)
        {
            if($identificador == 1){
                $archivoJson = new ManejadorJson("./heladeria.json");
            }elseif($identificador == 2){
                $archivoJson = new ManejadorJson("./ventas.json");
            }elseif($identificador == 3){
                $archivoJson = new ManejadorJson("./cupones.json");
            }
            
            $array = $archivoJson->TraerJson();
            $idMasGrande = 0;
            foreach($array as $elemento)
            {
                if(isset($elemento["id"]) && is_numeric($elemento["id"]))
                {
                    $id = intval($elemento["id"]);

                    if($id > $idMasGrande)
                    {
                        $idMasGrande = $id;
                    }
                }
            }
            $idMasGrande += 1;
            return $numeroFormateado = sprintf("%06d", $idMasGrande);
        }
        }
