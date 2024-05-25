<?php
    include_once "./clases/Helado.php";
    include_once "./clases/Validador.php";
    include_once "./clases/Venta.php";
    include_once "./clases/ManejarFotos.php";
    class AltaVenta{
        
        public static function AltaVenta($email,$sabor,$tipo,$vaso,$stock,$foto){
            if(Validador::ValidarTipo($tipo) ){
                if(!Validador::ValidarInt($stock)){
                    echo json_encode(['error' => 'datos incorrectos']);
                }else{
                    $archivoJson = new ManejadorJson("./heladeria.json");
                    $Helado = $archivoJson->ConsultaJson($tipo,$sabor);
                    $stockHelado = $Helado[0]['stock'];
                    $precioHelado = $Helado[0]['precio'];
                    if($stockHelado >= $stock){
                        $venta = new Venta($email,$sabor,$precioHelado,$tipo,$vaso,$stock);
                        $archivoVentaJson = new ManejadorJson("./ventas.json");
                        $archivoVentaJson->AgregarUno($venta);
                        $archivoJson->RestarStock($venta);
                        ManejarFotos::GuardarFoto($venta,$foto,2);
                    }else{
                        echo json_encode(['error' => 'stock insuficiente']);
                    }
                }       
            }
        }

        public static function AltaVentaConCupon($email,$sabor,$tipo,$vaso,$stock,$foto,$ncupon){
            if(Validador::ValidarTipo($tipo) ){
                if(!Validador::ValidarInt($stock)){
                    echo json_encode(['error' => 'datos incorrectos']);
                }else{
                    $archivoCuponJson = new ManejadorJson("./cupones.json");
                    $cupon = $archivoCuponJson->DevolverCupon($ncupon);
                    if($cupon){
                        if($cupon['estado'] == "usado"){
                            echo json_encode(['error' => 'El Cupon ya fue utilizado']);
                        }else{
                            $archivoJson = new ManejadorJson("./heladeria.json");
                            $Helado = $archivoJson->ConsultaJson($tipo,$sabor);
                            $stockHelado = $Helado[0]['stock'];
                            $precioHelado = $Helado[0]['precio'];
                            $precioHelado = $precioHelado  - $cupon['descuento'];
                            if($precioHelado <= 0){
                                echo json_encode(['error' => 'El precio con el descuento no puede ser 0']);
                            }else{
                                if($stockHelado >= $stock){
                                    $archivoCuponJson->CancelarCupon($ncupon);
                                    $venta = new Venta($email,$sabor,$precioHelado,$tipo,$vaso,$stock);
                                    $archivoVentaJson = new ManejadorJson("./ventas.json");
                                    $archivoVentaJson->AgregarUno($venta);
                                    $archivoJson->RestarStock($venta);
                                    ManejarFotos::GuardarFoto($venta,$foto,2);
                                }else{
                                    echo json_encode(['error' => 'stock insuficiente']);
                                }
                            }
                        }
                    }else{
                        echo json_encode(['error' => 'Cupon INVALIDO']);
                    }
                    
                }       
            }
        }
    }