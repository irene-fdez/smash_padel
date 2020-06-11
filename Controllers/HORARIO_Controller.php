<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta


require_once('../Models/HORARIO_Model.php');
include_once '../Entities/Horario.php';

function get_data_form_add(){

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }else{
        $id = NULL;
    }

    $todos_horarios = array(
                            '07:30:00' => '09:00:00',
                            '09:00:00' => '10:30:00',
                            '10:30:00' => '12:00:00',
                            '12:00:00' => '13:30:00',
                            '13:30:00' => '15:00:00',
                            '15:00:00' => '16:30:00',
                            '16:30:00' => '18:00:00',
                            '18:00:00' => '19:30:00',
                            '19:30:00' => '21:00:00',
                            '21:00:00' => '22:30:00',
                            '22:30:00' => '00:00:00'
                        );

    if(isset($_REQUEST['horario'])){
        $hora_inicio = $_REQUEST['horario'];
        $hora_fin = $todos_horarios[$hora_inicio];
    }else{
        $hora_inicio = 0;
    }
    
    $Horario = new Horario($id, $hora_inicio, $hora_fin);

    return $Horario;
}

function get_data_form(){

    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }else{
        $id = NULL;
    }

    if(isset($_REQUEST['hora_inicio'])){
        $hora_inicio = $_REQUEST['hora_inicio'];
    }else{
        $hora_inicio = 0;
    }

    if(isset($_REQUEST['hora_fin'])){
        $hora_fin = $_REQUEST['hora_fin'];
    }else{
        $hora_fin = 0;
    }
    
    $Horario = new Horario($id, $hora_inicio, $hora_fin);

    return $Horario;
}

if (!isset($_REQUEST['action'])){

    $_REQUEST['action'] = '';
}

$_SESSION['currentController'] = 'HORARIO';
$_SESSION['currentEntity'] = 'Horario';
$_SESSION['currentKey'] = 'id';


Switch ($_REQUEST['action']){

    case 'ADD':
        checkPermission('HORARIO','ADD', $_SESSION['login']);

            $message = array();

            if (!$_POST){

                $model = new HORARIO_Model('');
                $data = $model->horarios_disponibles();
              
                include '../Views/Horario/Add_horario.php';
                new Add_horario($data,false);
            }
            else{

                $horario = get_data_form_add();

                $model = new HORARIO_Model($horario);
                $respuesta = $model->Add();
                
              /*  foreach($data as $rol) {
                    if(isset($_POST['rol_'.$rol['id']]) == true ) {
                        $respuesta = $model->setUserRole($rol['id']);
                    }
                }*/
                
                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }

                header('Location:../Controllers/HORARIO_Controller.php');
            }


        break;

    case 'DELETE':

        checkPermission('HORARIO','DELETE', $_SESSION['login']);

            $message = array();

            if ($_POST){

                $entity = get_data_form();
                $model = new HORARIO_Model($entity);
                $respuesta = $model->delete();

                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }
            }
            header('Location:../Controllers/HORARIO_Controller.php');


        break;

       
    default:
            checkPermission('HORARIO','SHOWALL', $_SESSION['login']);
            $message = array();
            $model = new HORARIO_Model('');

            $data = $model->AllData();

            
            if( !is_int($data) && !is_array( $data)){
                $labels = array_keys($data->fetch_assoc());
            }
            else{
                $labels=NULL;
                $data=NULL;
            }
            $message=array();

            include '../Views/HORARIO/Showall.php';
            new Showall($data, $labels, $message);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        break;
    }
}


?>
