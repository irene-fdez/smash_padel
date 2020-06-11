<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta


require_once('../Models/HORARIO_Model.php');
require_once('../Models/PARTIDO_Model.php');
require_once('../Models/RESERVA_Model.php');
require_once('../Models/PISTA_Model.php');
include_once '../Entities/Partido.php';
include_once '../Entities/Reserva.php';


function get_data_form(){


    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }else{
        $id = NULL;
    }

    if(isset($_REQUEST['fecha'])){
        $fecha = $_REQUEST['fecha'];
    }else{
        $fecha = NULL;
    }

    if(isset($_REQUEST['inscripciones'])){
        $inscripciones = $_REQUEST['inscripciones'];
    }else{
        $inscripciones = 0;
    }

    if(isset($_REQUEST['reserva'])){
        $reserva= $_REQUEST['reserva'];
    }else{
        $reserva = NULL;
    }

    if(isset($_REQUEST['horario'])){
        $horario = $_REQUEST['horario'];
    }else{
        $horario = NULL;
    }


    $Partido = new Partido($id, $fecha,$inscripciones,$_SESSION['login'],$reserva,$horario);

    return $Partido;
}

if (!isset($_REQUEST['action'])){

    $_REQUEST['action'] = '';
}

$_SESSION['currentController'] = 'PARTIDO';
$_SESSION['currentEntity'] = 'Partido';
$_SESSION['currentKey'] = 'id';



Switch ($_REQUEST['action']){

    case 'ADD':
        checkPermission('PARTIDO','ADD', $_SESSION['login']);

         
                    $partido = get_data_form();
                //if(!$partido->check()) {
                /*    $model = new ROL_Model('');
                    $data = $model->AllData();*/

                    $model = new PARTIDO_Model($partido);
                    $respuesta = $model->Add();
                    
                    foreach($data as $rol) {
                        if(isset($_POST['rol_'.$rol['id']]) == true ) {
                            $respuesta = $model->setUserRole($rol['id']);
                        }
                    }
                    
                    if(isset($respuesta["text"]) && isset($respuesta["type"])){
                        $_SESSION['text_message'] = $respuesta["text"];
                        $_SESSION['type_message'] = $respuesta["type"];
                    }

               /* } else {

                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = false;
                }*/
                header('Location:../Controllers/PARTIDO_Controller.php');
        


        break;
    
    case 'SHOW_HORARIOS':
         //   checkPermission('PARTIDO','ADD', $_SESSION['login']);

            $message = array();
            $Reserva = new Reserva('', '',  $_SESSION['login'], '', '');
            $reserva_model_check = new RESERVA_Model($Reserva);
            $reserva_model = new RESERVA_Model(new Reserva('','','','',''));
            $horario_model = new HORARIO_Model('');
            $pista_model = new PISTA_Model('');

            $horarios = $horario_model->ShowAll();
            $reservas = $reserva_model->ShowAll();
            $pistas =  $pista_model->ShowAll();

            $message=array();
            include '../Views/PARTIDO/Show_horarios_promocionar.php';
            new Show_horarios_promocionar($horarios, $reservas, $pistas);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);

        break;


    case 'DELETE':

        checkPermission('PARTIDO','DELETE', $_SESSION['login']);

            $message = array();

            if ($_POST){

                $entity = get_data_form();
                $model = new PARTIDO_Model($entity);
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
            header('Location:../Controllers/PARTIDO_Controller.php');


        break;

    case 'SHOWALL_PARTIDOS_INSCRIPCION':

            checkPermission('PARTIDO','SHOWALL', $_SESSION['login']);

            if($_SESSION["rol"]["nombre"] == 'Administrador'){
                $partido_model = new PARTIDO_Model('');
                $partidos = $partido_model->ShowAll_incripciones();

               // var_dump($partidos);exit;
                 
                $message=array();
                include '../Views/PARTIDO/Showall_partidos_inscripcion.php';
                new Showall_partidos_inscripcion($partidos, $message);
                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);

            }

        break;

    case 'SHOW_INSCRITOS_PARTIDO':
        checkPermission('PARTIDO','SHOWALL', $_SESSION['login']);

    //    if($_SESSION["rol"]["nombre"] == 'Administrador'){
            $entity = get_data_form();
            $partido_model = new PARTIDO_Model($entity);

            $partidos = $partido_model->Show_inscritos();
            $rows = $partidos->fetch_array();
            $fecha = $rows['fecha'];
            $hora_inicio = $rows['hora_inicio'];
            $hora_fin = $rows['hora_fin'];
            
            $partidos = $partido_model->Show_inscritos();
            if( !is_int($partidos) && !is_array($partidos) ){
                $labels = array_keys($partidos->fetch_assoc());
            }
            else{
                $labels=NULL;
                $partidos=NULL;
            }

            $message=array();
            include '../Views/PARTIDO/Show_inscritos_partido.php';
            new Show_inscritos_partido($partidos, $labels, $message, $fecha, $hora_inicio, $hora_fin);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);

       // }
        break;

    
    case 'INSCRIBIRSE_PARTIDO':
            checkPermission('PARTIDO','SHOWALL', $_SESSION['login']);

            $partido_model = new PARTIDO_Model('');
            if($_SESSION["rol"]["nombre"] == 'Administrador'){
                $partidos = $partido_model->Show_futuros_partidos();
                if( !is_int($partidos) && !is_array( $partidos)){
                    $labels = array_keys($partidos->fetch_assoc());
                }
                else{
                    $labels=NULL;
                    $partidos=NULL;
                }
            }else{
                $partidos = $partido_model->Show_futuros_partidos_user($_SESSION['login']); 
            }

            

            $message=array();
            include '../Views/PARTIDO/Inscribirse_partido.php';
            if($_SESSION["rol"]["nombre"] == 'Administrador'){
                new Inscribirse_partido($partidos, $labels, $message);
            }else{
                new Inscribirse_partido($partidos, $message);
            }
           
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);

       
        break;

    case 'INSCRIPCION_USUARIO':
        if($_SESSION["rol"]["nombre"] == 'Administrador'){
            $entity = get_data_form();
            $partido_model = new PARTIDO_Model($entity);
            $partidos = $partido_model->Show_usuarios_inscripcion();
            
            if( !is_int($partidos) && !is_array( $partidos)){
                $labels = array_keys($partidos->fetch_assoc());
            }
            else{
                $labels=NULL;
                $partidos=NULL;
            }

            $message=array();
            include '../Views/PARTIDO/Inscribir_usuario_partido.php';
            new Inscribir_usuario_partido($partidos, $labels, $message);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        }
        break;

    case 'INSCRIPCIONES_USER_PARTIDOS': //Ver inscripciones

            checkPermission('PARTIDO','SHOWALL', $_SESSION['login']);

            $message = array();
            $model = new PARTIDO_Model('');

            $data = $model->Get_inscripciones_user($_SESSION['login']);
            
            if( !is_int($data) && !is_array( $data)){
                $labels = array_keys($data->fetch_assoc());
            }
            else{
                $labels=NULL;
                $data=NULL;
            }
            include '../Views/PARTIDO/Showall.php';
            new Showall($data, $labels);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        break;



  
    case 'SHOWCURRENT':
    
            checkPermission('PARTIDO','SHOWCURRENT', $_SESSION['login']);

            $partido = get_data_form();
            $user_model = new PARTIDO_Model($partido);

            $data = $user_model->getData();

            include '../Views/PARTIDO/Showcurrent.php';
            new Showcurrent($data);

        break;

        
    default:
            checkPermission('PARTIDO','SHOWALL', $_SESSION['login']);
            $message = array();
            $model = new PARTIDO_Model('');

            $data = $model->AllData();

            
            if( !is_int($data) && !is_array( $data)){
                $labels = array_keys($data->fetch_assoc());
            }
            else{
                $labels=NULL;
                $data=NULL;
            }
            $message=array();
            include '../Views/PARTIDO/Showall.php';
            new Showall($data, $labels, $message);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        break;
    }
}


?>
