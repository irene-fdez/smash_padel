<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta


require_once('../Models/PISTA_Model.php');
include_once '../Entities/Pista.php';


function get_data_form(){

    if(isset($_REQUEST['nombre'])){
        $nombre = $_REQUEST['nombre'];
    }else{
        $nombre = NULL;
    }

    if(isset($_REQUEST['tipo'])){
        $tipo = $_REQUEST['tipo'];
    }else{
        $tipo = 0;
    }


    $Pista = new Pista($nombre, $tipo);

    return $Pista;
}

if (!isset($_REQUEST['action'])){

    $_REQUEST['action'] = '';
}

$_SESSION['currentController'] = 'PISTA';
$_SESSION['currentEntity'] = 'Pista';
$_SESSION['currentKey'] = 'nombre';


Switch ($_REQUEST['action']){

    case 'ADD':
        checkPermission('PISTA','ADD', $_SESSION['login']);

            $message = array();

            if (!$_POST){

                $model = new PISTA_Model('');
                $data = array($model->AllData());
              
                include '../Views/PISTA/Add.php';
                new Add($data,false);
            }
            else{

                $pista = get_data_form();
                //if(!$pista->check()) {
                /*    $model = new ROL_Model('');
                    $data = $model->AllData();*/

                    $model = new PISTA_Model($pista);
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
                header('Location:../Controllers/PISTA_Controller.php');
            }


        break;

    case 'DELETE':

        checkPermission('PISTA','DELETE', $_SESSION['login']);

            $message = array();

            if ($_POST){

                $entity = get_data_form();
                $model = new PISTA_Model($entity);
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
            header('Location:../Controllers/PISTA_Controller.php');

            break;

    case 'SHOWCURRENT':
    
            checkPermission('PISTA','SHOWCURRENT', $_SESSION['login']);

            $pista = get_data_form();
            $user_model = new PISTA_Model($pista);

            $data = $user_model->getData();

            include '../Views/PISTA/Showcurrent.php';
            new Showcurrent($data);

        break;
        
    default:
            checkPermission('PISTA','SHOWALL', $_SESSION['login']);
            $message = array();
            $model = new PISTA_Model('');

            $data = $model->AllData();

            
            if( !is_int($data) && !is_array( $data)){
                $labels = array_keys($data->fetch_assoc());
            }
            else{
                $labels=NULL;
                $data=NULL;
            }
            $message=array();
            include '../Views/PISTA/Showall.php';
            new Showall($data, $labels, $message);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        break;
    }
}


?>
