<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta


require_once('../Models/RESERVA_Model.php');
require_once('../Models/HORARIO_Model.php');
require_once('../Models/PARTIDO_Model.php');
require_once('../Models/PISTA_Model.php');
include_once '../Entities/Reserva.php';
include_once '../Entities/Horario.php';
include_once '../Entities/Partido.php';


function get_data_form(){
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }else{
        $id = NULL;
    }

    if(isset( $_REQUEST['fecha'])){
      $fecha = $_REQUEST['fecha'];
    }else{
      $fecha = NULL;
    }
    
    if(isset( $_REQUEST['id_horario'])){
      $id_horario = $_REQUEST['id_horario'];
    }else{
      $id_horario = NULL;
    }

    if(isset( $_REQUEST['nombre_pista'])){
      $nombre_pista = $_REQUEST['nombre_pista'];
    }else{
      $nombre_pista = NULL;
    }

    $login_user = $_SESSION['login'];

    $Reserva = new Reserva($id, $fecha, $login_user, $id_horario, $nombre_pista);

    return $Reserva;
}

if (!isset($_REQUEST['action'])){

    $_REQUEST['action'] = '';
}

$_SESSION['currentController'] = 'RESERVA';
$_SESSION['currentEntity'] = 'Reserva';
$_SESSION['currentKey'] = 'id';


Switch ($_REQUEST['action']){

    case 'ADD':
  //  exit('add reserva');
        checkPermission('RESERVA','ADD', $_SESSION['login']);

            $message = array();
        
            $reserva = get_data_form();
            $model = new RESERVA_Model($reserva);
            $respuesta = $model->Add();
                
            if(isset($respuesta["text"]) && isset($respuesta["type"])){
                $_SESSION['text_message'] = $respuesta["text"];
                $_SESSION['type_message'] = $respuesta["type"];
            }
          //  exit;

            //si hay partidos promocionados para la fecha y hora de la reserva se deben eliminar
            if(isset($respuesta["id_partido"])){
                $Partido = new Partido($respuesta["id_partido"], '', '', '', '', '');
                $model_partido = new PARTIDO_Model($Partido);
                $respuesta_p = $model_partido->delete();

                if(isset($respuesta_p["type"]) && $respuesta_p["type"]){ 
                    $_SESSION['text_message'] = $respuesta["text"].'<br> Se ha eliminado el partido que estaba promocionado para esa fecha y hora';
                    $_SESSION['type_message'] = $respuesta["type"];
                }
            }

            header('Location:../Controllers/RESERVA_Controller.php?action=SHOWALL_PISTAS_RESERVA');
        break;

    case 'DELETE':

        checkPermission('RESERVA','DELETE', $_SESSION['login']);

            if ($_POST){

                $entity = get_data_form();

                $nombre_pista = $entity->getNombre_pista();
                $model = new RESERVA_Model($entity);
                $respuesta = $model->delete();

                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }
            }
            if(isset($respuesta["pista"])){
                header('Location:../Controllers/RESERVA_Controller.php?action=SHOW_RESERVAS_PISTA&nombre_pista='.$respuesta["pista"]);
            }
            else{
                header('Location:../Controllers/RESERVA_Controller.php?action=SHOWALL_PISTAS_RESERVA');
            }

        break;

    case 'SHOWCURRENT':
    
            checkPermission('RESERVA','SHOWCURRENT', $_SESSION['login']);

            $reserva = get_data_form();
            $reserva_model = new RESERVA_Model($reserva);

            $data = $reserva_model->getData();

            include '../Views/RESERVA/Showcurrent.php';
            new Showcurrent($data);

        break;


    case 'SHOW_PISTAS':

        if( (isset($_REQUEST["id_horario"])) && (isset($_REQUEST["fecha"])) ) {
            $Reserva = new Reserva('', $_REQUEST["fecha"], '', $_REQUEST["id_horario"], '');
            $reserva_model = new RESERVA_Model($Reserva);

            $pistas_sin_reserva = $reserva_model->Get_pistas_libres();

            /*if(is_string($pistas_sin_reserva)){

            $mensajes = new MESSAGE($pistas_sin_reserva, '../Controllers/RESERVAR_PISTA_Controller.php');*/
            if(isset($respuesta["text"]) && isset($respuesta["type"])){
                $_SESSION['text_message'] = $respuesta["text"];
                $_SESSION['type_message'] = $respuesta["type"];

            }else{
            
                $Horario = new Horario($_REQUEST["id_horario"], '', '');
                $horario_model = new HORARIO_Model($Horario);
                $horario = $horario_model->Get_horario();

                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
    
                
            /* $horario = $HORARIO->SHOW();
                if(is_string($horario)){
                    $mensajes = new MESSAGE($horario, '../Controllers/RESERVAR_PISTA_Controller.php');*/
                }else{
                    include '../Views/RESERVA/Add_reserva_pista.php';
                  //  new Show_pistas_reserva($horarios,$reservas, $pistas);

                    new Add_reserva_pista($pistas_sin_reserva, $_REQUEST["fecha"], $horario );
                }
            }
        }
        break;

    case 'SHOWALL_PISTAS_RESERVA':

        checkPermission('RESERVA','SHOWALL', $_SESSION['login']);
        $message = array();
        $model_res = new RESERVA_Model(new Reserva('','','','',''));
        $model = new PISTA_Model('');

        if($_SESSION['rol']['nombre'] == 'Administrador'){
            $data = $model->Show_pistas_reserva();
        }else{
            $data = $model->AllData_user($_SESSION['login']);
        }

        if( !is_int($data) && !is_array( $data)){
            $labels = array_keys($data->fetch_assoc());
        }
        else{
            $labels=NULL;
            $data=NULL;
        }
        $message=array();
        include '../Views/RESERVA/Showall_pistas_reserva.php';
        new Showall_pistas_reserva($data, $labels, $message);
        unset($_SESSION['text_message']);
        unset($_SESSION['type_message']);
        break;


    case 'SHOW_RESERVAS_PISTA': 
        checkPermission('RESERVA','SHOWALL', $_SESSION['login']);
        $message = array();
        $reserva = get_data_form();
        $model = new RESERVA_Model($reserva);

        if($_SESSION['rol']['nombre'] == 'Administrador'){
            $data = $model->Get_reservas_pista();
        }else{
            $data = $model->Get_reservas_pista_user($_SESSION['login']);
        }
        
        $message=array();
        if($data->num_rows == 0){ 
            if(!isset($_SESSION['text_message'])){
                $_SESSION['text_message'] = 'No hay reservas asociadas a esa pista';
                $_SESSION['type_message'] = false;
            }
            
            header('Location:../Controllers/RESERVA_Controller.php?action=SHOWALL_PISTAS_RESERVA');
        }else{
            if( !is_int($data) && !is_array($data)){
                $labels = array_keys($data->fetch_assoc());
            }
            else{
                $labels=NULL;
                $data=NULL;
            }
            include '../Views/RESERVA/Showall.php';
            new Showall($data, $labels, $message);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        }
       
        break;
        
    default:
            checkPermission('RESERVA','SHOWALL', $_SESSION['login']);
            $message = array();
            $Reserva = new Reserva('', '',  $_SESSION['login'], '', '');
            $reserva_model_check = new RESERVA_Model($Reserva);
            $reserva_model = new RESERVA_Model(new Reserva('','','','',''));
            $horario_model = new HORARIO_Model('');
            $pista_model = new PISTA_Model('');

            
            if($_SESSION["rol"]['nombre'] != 'Administrador' && $reserva_model_check->CHECK_MAX()){ 
                $_SESSION['text_message'] = 'Has alcanzado el número máximo de reservas!';
                $_SESSION['type_message'] = false;
               // new MESSAGE("Has alcanzado el número máximo de reservas!", '../Controllers/RESERVAR_PISTA_Controller.php?action=SHOW_RESERVAS');
                if($_SESSION['rol']['nombre'] == "Administrador"){
                    header('Location:../Controllers/LOGIN_Controller.php');
                }else{
                    header('Location:../Controllers/RESERVA_Controller.php?action=SHOWALL_PISTAS_RESERVA');
                }
                exit;
          
            }else{
                $horarios = $horario_model->ShowAll();
                $reservas = $reserva_model->ShowAll();
                $pistas =  $pista_model->ShowAll();
            }

            $message=array();
            include '../Views/RESERVA/Show_horarios_reserva.php';
            new Show_horarios_reserva($horarios, $reservas, $pistas);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        break;
    }
}


?>
