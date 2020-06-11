<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta


    require_once('../Models/HUECO_DISPONIBLE_Model.php');
    require_once('../Models/HORARIO_Model.php');
    require_once('../Models/RESERVA_Model.php');
    require_once('../Models/PISTA_Model.php');
    include_once '../Entities/Hueco_disponible.php';
    include_once '../Entities/Reserva.php';

    if(isset($_REQUEST['enfrentamiento_id'])){
        $enfrentamiento_id = $_REQUEST['enfrentamiento_id'];
    }else{
        $enfrentamiento_id = NULL;
    }

    if(isset($_REQUEST['pareja_id'])){
        $pareja_id = $_REQUEST['pareja_id'];
    }else{
        $pareja_id = NULL;
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
            $fecha = NULL ;
        }

        if(isset($_REQUEST['horario_id'])){
            $horario_id = $_REQUEST['horario_id'];
        }else{
            $horario_id = NULL;
        }

        if(isset($_REQUEST['pareja_id'])){
            $pareja_id =  $_REQUEST['pareja_id'];
        }else{
            $pareja_id = NULL;
        }

        if(isset($_REQUEST['enfrentamiento_id'])){
            $enfrentamiento_id= $_REQUEST['enfrentamiento_id'];
        }else{
            $enfrentamiento_id = NULL;
        }

        return new Hueco_disponible($id, $fecha, $horario_id, $pareja_id, $enfrentamiento_id);

    }


    if (!isset($_REQUEST['action'])){

        $_REQUEST['action'] = '';
    }

    $_SESSION['currentController'] = 'HUECO_DISPONIBLE';
    $_SESSION['currentEntity'] = 'Hueco_disponible';
    $_SESSION['currentKey'] = 'id';


    Switch ($_REQUEST['action']){

        case 'SHOW_HUECOS_DISPOBIBLES':
                $message = array();
                $Reserva = new Reserva('', '',  $_SESSION['login'], '', '');
                $reserva_model = new RESERVA_Model(new Reserva('','','','',''));
                $horario_model = new HORARIO_Model('');
                $pista_model = new PISTA_Model('');

                $horarios = $horario_model->ShowAll();
                $reservas = $reserva_model->ShowAll();
                $pistas =  $pista_model->ShowAll();

                $message=array();
                include '../Views/ENFRENTAMIENTO/HORARIOS/Show_horarios_hueco_disponible.php';
                new Show_horarios_hueco_disponible($horarios, $reservas, $pistas, $enfrentamiento_id, $pareja_id);

                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);
            
            break;

        case 'SHOW_OFERTAS':
                $hueco_disponible = get_data_form();
                $model = new HUECO_DISPONIBLE_Model($hueco_disponible);

                $huecos_propuestos = $model->Get_ofertas_huecos();
                $data = $model->Get_datos_adicinales_ofertas_huecos();

                $message = array();
                include '../Views/ENFRENTAMIENTO/HORARIOS/Show_huecos_propuestos.php';
                new Show_huecos_propuestos($huecos_propuestos, $data, $message, $enfrentamiento_id, $pareja_id);
                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);
            break;



        case 'SHOW_TUS_PROPUESTAS':
                $hueco_disponible = get_data_form();
                $model = new HUECO_DISPONIBLE_Model($hueco_disponible);

                $huecos_propuestos = $model->Get_tus_ofertas_propuestas();
                $data = $model->Get_datos_adicionales_tus_ofertas_propuestas();

                $message = array();
                include '../Views/ENFRENTAMIENTO/HORARIOS/Show_tus_propuestas_realizadas.php';
                new Show_tus_propuestas_realizadas($huecos_propuestos, $data, $message, $enfrentamiento_id, $pareja_id);
                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);
            break;

        case 'ADD_HUECO':
                $hueco_disponible = get_data_form();
                $model = new HUECO_DISPONIBLE_Model($hueco_disponible);
                $respuesta = $model->Add();

                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }

                header('Location:../Controllers/HUECO_DISPONIBLE_Controller.php?action=PROPUESTAS&enfrentamiento_id='.$hueco_disponible->getId_enfrentamiento().'&pareja_id='.$hueco_disponible->getId_pareja());
            break;

        case 'PROPUESTAS':
                $hueco_disponible = get_data_form();
                $model = new HUECO_DISPONIBLE_Model($hueco_disponible);

                $propuestas_actuales = $model->Propuestas_huecos();

                $message = array();
                include '../Views/ENFRENTAMIENTO/HORARIOS/Show_propuestas_actuales.php';
                new Show_propuestas_actuales($propuestas_actuales, $message, $enfrentamiento_id, $pareja_id);
                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);

            break;

        case 'DELETE':
                $hueco_disponible = get_data_form();
                $model = new HUECO_DISPONIBLE_Model($hueco_disponible);
                $respuesta = $model->delete();

                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }

                header('Location:../Controllers/HUECO_DISPONIBLE_Controller.php?action=PROPUESTAS&enfrentamiento_id='.$hueco_disponible->getId_enfrentamiento().'&pareja_id='.$hueco_disponible->getId_pareja());
            break;

        case 'ACEPTAR_PROPUESTA':
                $hueco_disponible = get_data_form();
                $model = new HUECO_DISPONIBLE_Model($hueco_disponible);
                $respuesta = $model->Aceptar_propuesta();
                
                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }

                header('Location:../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO');
                
            break;

        case 'RECHAZAR_PROPUESTA':
                    $hueco_disponible = get_data_form();
                    $model = new HUECO_DISPONIBLE_Model($hueco_disponible);
                    $respuesta = $model->Delete_huecos_restantes();
                    

                    if(isset($respuesta["text"]) && isset($respuesta["type"])){
                        $_SESSION['text_message'] = 'Las propuestas han sido rechazadas.<br>Puedes proponer un nuevo día y hora!';
                        $_SESSION['type_message'] = $respuesta["type"];
                    }

                    header('Location:../Controllers/HUECO_DISPONIBLE_Controller.php?action=PROPUESTAS&enfrentamiento_id='.$hueco_disponible->getId_enfrentamiento().'&pareja_id='.$hueco_disponible->getId_pareja());

            break;
        

        default:

            break;
        
    }

}
