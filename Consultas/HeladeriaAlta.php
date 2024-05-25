<?php
    include_once "./clases/Helado.php";
    include_once "./clases/Validador.php";
    include_once "./clases/ManejarFotos.php";
    class HeladeriaAlta{

        public static function darAlta($sabor,$precio,$tipo,$vaso,$stock,$foto){
            if(Validador::ValidarTipo($tipo) && Validador::ValidarVaso($vaso)){
                if(!Validador::ValidarInt($precio) || !Validador::ValidarInt($stock)){
                    echo json_encode(['error' => 'datos incorrectos']);
                }else{
                    $precio = Validador::ValidarInt($precio);
                    $stock = Validador::ValidarInt($stock);
                    $archivoJson = new ManejadorJson("./heladeria.json");
                    $helado = new Helado($sabor,$precio,$tipo,$vaso,$stock);
                    $banderaCreado = $archivoJson->ActualizarJson($helado);
                    if(!$banderaCreado){
                        ManejarFotos::GuardarFoto($helado,$foto);
                    }
                }       
            }
        }
    }
