<?php

    class Validador{
        public static function ValidarTipo($string)
        {
            if($string === 'Agua' || $string === 'Crema')
            {
                return true;
            }
            else
            {
                echo json_encode(['error' => 'tipo invalido']);
                return false;
            }
        }

        public static function ValidarVaso($string)
        {
            if($string === 'Cucurucho' || $string === 'Plastico')
            {
                return true;
            }
            else
            {
                echo json_encode(['error' => 'vaso invalido']);
                return false;
            }
        }

        public static function ValidarInt($int){
            if(is_string($int)){
                if((int)$int){
                    return (int)$int;
                }else{
                    echo json_encode(['error' => 'no es posible convertir']);
                    return false;
                }  
            }elseif(is_int($int)){
                return $int;
            }else{
                echo json_encode(['error' => 'no es strng']);
                return false;
            }
        }
    }

?>