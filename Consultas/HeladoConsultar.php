<?php
    include_once "./clases/Helado.php";
    include_once "./clases/Validador.php";
    class HeladoConsultar{

        public static function Consulta($sabor,$tipo){
            if(Validador::ValidarTipo($tipo) ){
                    $archivoJson = new ManejadorJson("./heladeria.json");
                    $archivoJson->ConsultaJson($tipo,$sabor);
                }       
            }
        }
