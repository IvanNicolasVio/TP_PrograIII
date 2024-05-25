<?php
include_once "./Consultas/HeladeriaAlta.php";
include_once "./Consultas/HeladoConsultar.php";
include_once "./Consultas/AltaVenta.php";
include_once "./Consultas/ConsultasVentas.php";
include_once "./Consultas/ModificarVenta.php";
include_once "./Consultas/DevolverHelado.php";
include_once "./Consultas/BorrarVenta.php";
include_once "./Consultas/ConsultarDevoluciones.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case "alta":
                if(isset($_POST['sabor']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['vaso']) && isset($_POST['stock']) && isset($_FILES['foto'])){
                    HeladeriaAlta::darAlta($_POST['sabor'],$_POST['precio'],$_POST['tipo'],$_POST['vaso'],$_POST['stock'],$_FILES['foto']);
                }      
            break;

            case "consulta":
                if(isset($_POST['sabor']) && isset($_POST['tipo'])){
                    HeladoConsultar::Consulta($_POST['sabor'],$_POST['tipo']);
                }           
            break;

            case "venta":
                if(isset($_POST['mail']) && isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['vaso']) && isset($_POST['stock']) && isset($_FILES['foto'])){
                    if(isset($_POST['cupon'])){
                        AltaVenta::AltaVentaConCupon($_POST['mail'],$_POST['sabor'],$_POST['tipo'],$_POST['vaso'],$_POST['stock'],$_FILES['foto'],$_POST['cupon']);
                    }else{
                        AltaVenta::AltaVenta($_POST['mail'],$_POST['sabor'],$_POST['tipo'],$_POST['vaso'],$_POST['stock'],$_FILES['foto']);
                    }
                }           
            break;

            case "devolver":
                if(isset($_POST['npedido']) && isset($_POST['causa']) && isset($_FILES['foto'])){
                    DevolverHelado::Devolver($_POST['npedido'], $_POST['causa'],$_FILES['foto']);
                }           
            break;
        }
    }
}elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case "consulta a":
                ConsultasVentas::ListarCantidad($_GET['dia']);
            break;

            case "consulta b":
                if(isset($_GET['usuario'])){
                    ConsultasVentas::ListarPorUsuario($_GET['usuario']);
                }
            break;

            case "consulta c":
                if(isset($_GET['fechaUno']) && isset($_GET['fechaDos'])){
                    ConsultasVentas::ListarPorFechas($_GET['fechaUno'],$_GET['fechaDos']);
                }
            break;

            case "consulta d":
                if(isset($_GET['sabor'])){
                    ConsultasVentas::ListarPorSabor($_GET['sabor']);
                }
            break;

            case "consulta e":
                if(isset($_GET['vaso'])){
                    ConsultasVentas::ListarPorVaso($_GET['vaso']);
                }
            break;

            case "consulta 9a":
                ConsultasDevoluciones::ListarDevoluciones();
            break;

            case "consulta 9b":
                ConsultasDevoluciones::ListarCupones();
            break;

            case "consulta 9c":
                ConsultasDevoluciones::ListarCuponesUsados();
            break;

        }
    }
}elseif($_SERVER['REQUEST_METHOD'] === 'PUT'){
    parse_str(file_get_contents("php://input"),$putData);
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case "modificar":
                if(isset($putData['pedido']) && isset($putData['email']) && isset($putData['sabor']) && isset($putData['tipo']) && isset($putData['vaso']) && isset($putData['stock'])){
                    ModificarVenta::Modificar($putData['pedido'],$putData['email'],$putData['sabor'],$putData['tipo'],$putData['vaso'],$putData['stock']);
                }
            break;
        }
    }
}elseif($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case "borrar":
                if(isset($_GET['npedido'])){
                    BorrarVenta::Borrar($_GET['npedido']);
                }
            break;
        }
    }
}
