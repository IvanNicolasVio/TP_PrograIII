<?php
  class ManejarFotos
  {

    public static function GuardarFoto($objeto, $file,$identificador = 1)
    {
      $nombreTemporal = $_FILES['foto']['tmp_name'];
      $nombreOriginal = $_FILES['foto']['name'];
      $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

      if($identificador == 1){
        $directorio = "./ImagenesDeHelados/2024";
        $nombreNuevo = $objeto->id . "_" . $objeto->sabor . "_" . $objeto->tipo . "." . $extension;
      }elseif($identificador == 2){
        $directorio = "./ImagenesDeLaVenta/2024";
        $nombreNuevo = $objeto->sabor . "_" . $objeto->tipo . "_" . $objeto->email . "_" . $objeto->fecha . "." . $extension;
      }elseif($identificador == 3){
        $directorio = "./ImagenesDeLaVenta/2024";
        $nombreNuevo = $objeto['numeroDePedido'] . "_" . $objeto['email'] . "." . $extension;
      }
      
      if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
      }

      $rutaGuardado = $directorio . "/" . $nombreNuevo;

      if (move_uploaded_file($nombreTemporal, $rutaGuardado)) {
        return true;
      } else {
        return false;
      }
    }

    public static function MoverFoto($objeto)
    {      
      $directorio = "./ImagenesBackupVentas/2024";

      if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
      }

      $rutaOrigen = "./ImagenesDeLaVenta/2024/" . $objeto['sabor'] . "_" . $objeto['tipo'] . "_" . $objeto['email'] . "_" . $objeto['fecha'] . "." . "jpg";
      $rutaDestino = $directorio . "/" . $objeto['sabor'] . "_" . $objeto['tipo'] . "_" . $objeto['email'] . "_" . $objeto['fecha'] . "." . "jpg";

      if (rename($rutaOrigen, $rutaDestino)) {
        echo json_encode(['estado' => 'Movido con exito']);
      } else {
        echo json_encode(['estado' => 'ERROR al mover']);
      }
    }
  }

?>