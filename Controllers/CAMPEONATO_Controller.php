<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta


require_once('../Models/HORARIO_Model.php');
require_once('../Models/CAMPEONATO_Model.php');
require_once('../Models/CATEGORIA_Model.php');
require_once('../Models/RESERVA_Model.php');
require_once('../Models/PISTA_Model.php');
include_once '../Entities/Campeonato.php';
include_once '../Entities/Reserva.php';


if(isset($_REQUEST['categorias'])){
    $categorias = $_POST['categorias'];
}else{
   $categorias = NULL;
}


function get_data_form(){


    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }else{
        $id = NULL;
    }

    if(isset($_REQUEST['nombre'])){
        $nombre = $_REQUEST['nombre'];
    }else{
        $nombre = NULL;
    }

    if(isset($_REQUEST['fecha'])){
        $fecha = $_REQUEST['fecha'];
    }else{
        $fecha = NULL;
    }

    if(isset($_SESSION['login'])){
        $login_admin= $_SESSION['login'];
    }else{
        $login_admin = NULL;
    }

    $Campeonato = new Campeonato($id, $nombre, $fecha, $login_admin);

    return $Campeonato;
}

if (!isset($_REQUEST['action'])){

    $_REQUEST['action'] = '';
}

$_SESSION['currentController'] = 'CAMPEONATO';
$_SESSION['currentEntity'] = 'Campeonato';
$_SESSION['currentKey'] = 'id';


Switch ($_REQUEST['action']){

    case 'ADD':
        checkPermission('CAMPEONATO','ADD', $_SESSION['login']);

            if(!$_POST){
                $model = new CATEGORIA_Model('');
                $data = array($model->AllData());
              
                include '../Views/CAMPEONATO/Add_campeonato.php';
                new Add_campeonato($data,false);

            }
            else{
                $campeonato = get_data_form();
                $model = new CAMPEONATO_Model($campeonato);
                $respuesta = $model->Add($categorias);
                
                
                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }

                header('Location:../Controllers/CAMPEONATO_Controller.php');
                
            }
    
        break;

    case 'DELETE':

        checkPermission('CAMPEONATO','DELETE', $_SESSION['login']);

            $message = array();

            if ($_POST){

                $entity = get_data_form();
                $model = new CAMPEONATO_Model($entity);
                $respuesta = $model->delete();

                if(isset($respuesta["id_reserva"]) && $respuesta["id_reserva"] <> NULL){
                    $RESERVA = new RESERVA_Model(new Reserva($respuesta["id_reserva"], '', '', '', ''));
                    $mensaje = $RESERVA->DELETE();
                }

                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }
            }
            header('Location:../Controllers/CAMPEONATO_Controller.php');


        break;

    case 'CAMPEONATOS_CERRADOS':

        $message = array();
        $model = new CAMPEONATO_Model('');
        $camp_enfrent = $model->Get_camp_con_enfrentamiento();
        $camp_no_enfrent = $model->Get_camp_sin_enfrentamiento();
        $labels = NULL;


        if( !is_int($camp_enfrent) && !is_array($camp_enfrent)) $labels = array_keys($camp_enfrent->fetch_assoc());
        else  $camp_enfrent = NULL;
        
        if( !is_int($camp_no_enfrent) && !is_array($camp_no_enfrent))  $labels = array_keys($camp_no_enfrent->fetch_assoc());
        else  $camp_no_enfrent = NULL;
        
        

        include '../Views/CAMPEONATO/Showall_close.php';
        new Showall_close($camp_enfrent, $camp_no_enfrent, $labels, $message);
        unset($_SESSION['text_message']);
        unset($_SESSION['type_message']);

        break;

    case 'GENERAR':
    
        $campeonato = get_data_form();
        $model = new CAMPEONATO_Model($campeonato);

        $respuesta = $model->Comprobar_camp_pasados();

        if(isset($respuesta["text"]) && isset($respuesta["type"])){
            $_SESSION['text_message'] = $respuesta["text"];
            $_SESSION['type_message'] = $respuesta["type"];
        }

        header('Location:../Controllers/CAMPEONATO_Controller.php?action=CAMPEONATOS_CERRADOS');

        break;

    case 'CAMPEONATOS_USUARIO':
            $model = new CAMPEONATO_Model('');
            $campeonatos = $model->Get_campeonatos_usuario($_SESSION['login']);
            $message=array();
            include '../Views/CAMPEONATO/Showall_campeonato_usuario.php';
            new Showall_campeonato_usuario($campeonatos, $message);

        break;

        
        //el default muestra los campeonatos abiertos
    default:
            checkPermission('CAMPEONATO','SHOWALL', $_SESSION['login']);

            $message = array();
            $model = new CAMPEONATO_Model('');
            if($_SESSION['rol']['nombre'] == "Administrador"){
                $data = $model->Get_campeonatos_abiertos();
            }else{
                $data = $model->Get_campeonatos_abiertos_usuario($_SESSION['login']);
            }

            if( !is_int($data) && !is_array($data)){
                $labels = array_keys($data->fetch_assoc());
            }
            else{
                $labels=NULL;
                $data=NULL;
            }
            $message=array();
            include '../Views/CAMPEONATO/Showall.php';
            new Showall($data, $labels, $message);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        break;
    }
}


?>
