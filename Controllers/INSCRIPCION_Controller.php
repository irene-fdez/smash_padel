<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta


require_once('../Models/INSCRIPCION_Model.php');
require_once('../Models/CATEGORIA_Model.php');
require_once('../Models/USUARIO_Model.php');
require_once('../Models/PAREJA_Model.php');
require_once('../Models/CAMPEONATO_Model.php');
require_once('../Models/CATEGORIA_Model.php');
include_once '../Entities/Inscripcion.php';
include_once '../Entities/Pareja.php';
include_once '../Entities/Campeonato.php';

if(isset($_REQUEST['campeonato_id'])){
    $campeonato_id = $_REQUEST['campeonato_id'];
}else{
    $campeonato_id = NULL;
}

function get_data_form(){

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }else{
        $id = NULL;
    }

    if(isset($_REQUEST['fecha'])){
        $fecha = $_REQUEST['fecha'];
    }else{
        $fecha = date("Y-m-d"); 
    }

    if(isset($_REQUEST['pareja_id'])){
        $pareja_id = $_REQUEST['pareja_id'];
    }else{
        $pareja_id = NULL;
    }

    if(isset($_REQUEST['camp_cat_id'])){
        $camp_cat_id =  $_REQUEST['camp_cat_id'];
    }else{
        $camp_cat_id = NULL;
    }

    if(isset($_REQUEST['grupo_id'])){
        $grupo_id= $_REQUEST['grupo_id'];
    }else{
        $grupo_id = NULL;
    }

    $Inscripcion = new Inscripcion($id, $fecha, $pareja_id, $camp_cat_id, $grupo_id);

    return $Inscripcion;
}

function get_data_form_pareja(){

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }else{
        $id = NULL;
    }

    if(isset($_REQUEST['capitan'])){
        $capitan = $_REQUEST['capitan'];
    }else{
        $capitan = NULL;
    }

    if(isset($_REQUEST['jugador2'])){
        $jugador2 = $_REQUEST['jugador2'];
    }else{
        $jugador2 = NULL;
    }

    $Pareja = new Pareja($id, $capitan, $jugador2);

    return $Pareja;
}

if (!isset($_REQUEST['action'])){

    $_REQUEST['action'] = '';
}

$_SESSION['currentController'] = 'INSCRIPCION';
$_SESSION['currentEntity'] = 'Inscripcion';
$_SESSION['currentKey'] = 'id';


Switch ($_REQUEST['action']){

    case 'ADD':
        checkPermission('INSCRIPCION','ADD', $_SESSION['login']);

            $inscripcion = get_data_form();
            $model = new INSCRIPCION_Model($inscripcion);
            $respuesta = $model->ADD();
            
            
            if(isset($respuesta["text"]) && isset($respuesta["type"])){
                $_SESSION['text_message'] = $respuesta["text"];
                $_SESSION['type_message'] = $respuesta["type"];
            }

            header('Location:../Controllers/CAMPEONATO_Controller.php');
    
        break;


    case 'ADD_PAREJA': //diferenciar Admin y DEportista
            if(!$_POST){
                //muestra la vista
                $campeonato = new Campeonato($campeonato_id, '', '', '');
                $model = new CAMPEONATO_Model($campeonato);
                $data = array($model->Get_deportistas_campeonato(), $model->Get_deportistas_campeonato_reverse());
              
                include '../Views/CAMPEONATO/Add_pareja_campeonato.php';
                new Add_pareja_campeonato($data);
            }
            else{
                            
                //registra la pareja
                $pareja = get_data_form_pareja();
                $model_pareja = new PAREJA_Model($pareja);

                $respuesta = $model_pareja->ADD();
                $id_pareja = $model_pareja->GET_ID();

                if($campeonato_id != NULL){
                    $model_cat = new CATEGORIA_Model('');
                    $data = $model_cat->Get_categorias_campeonato($campeonato_id, $pareja->getCapitan(), $pareja->getJugador_2());
                }

                include '../Views/CAMPEONATO/Add_categoria_campeonato.php';
                new Add_categoria_campeonato($data, $id_pareja, $campeonato_id);
            }
        break;


    case 'DELETE':

        checkPermission('INSCRIPCION','DELETE', $_SESSION['login']);

            $message = array();

            if ($_POST){

                $entity = get_data_form();
                $model = new INSCRIPCION_Model($entity);
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
            header('Location:../Controllers/INSCRIPCION_Controller.php');


        break;



        //el default muestra los inscripcions abiertos
    default:
            checkPermission('INSCRIPCION','SHOWALL', $_SESSION['login']);

            $message = array();
            $model = new INSCRIPCION_Model('');
            $data = $model->Get_inscripcions_abiertos();

            if( !is_int($data) && !is_array( $data)){
                $labels = array_keys($data->fetch_assoc());
            }
            else{
                $labels=NULL;
                $data=NULL;
            }
            $message=array();
            include '../Views/INSCRIPCION/Showall.php';
            new Showall($data, $labels, $message);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        break;
    }
}


?>
