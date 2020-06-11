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
require_once('../Models/USUARIO_PARTIDO_Model.php');
include_once '../Entities/Partido.php';
include_once '../Entities/Reserva.php';
include_once '../Entities/Usuario_partido.php';
include_once '../Entities/Pista.php';


function get_data_form(){

    if(isset( $_REQUEST['login'])){
        $login_user = $_REQUEST['login'];
    }
    elseif($_SESSION['login']){
        $login_user = $_SESSION['login'];
    }
    else{
        $login_user= NULL;
    }    

    if(isset( $_REQUEST['id_partido'])){
        $id_partido = $_REQUEST['id_partido'];
    }else{
        $id_partido = NULL;
    }


    $Usuario_partido = new Usuario_partido($login_user, $id_partido);

    return $Usuario_partido;
}

if (!isset($_REQUEST['action'])){

    $_REQUEST['action'] = '';
}

$_SESSION['currentController'] = 'USUARIO_PARTIDO';
$_SESSION['currentEntity'] = 'usuario_partido';
$_SESSION['currentKey'] = 'id_partido';



Switch ($_REQUEST['action']){

    case 'ADD_INSCRIPCION':

        $usuario_partido = get_data_form();
        $model = new USUARIO_PARTIDO_Model($usuario_partido);
        $respuesta = $model->Add(); //se incribe al usuario en el partido

        $num_inscripciones = $model->Get_inscripciones();

        //si el numero de inscripciones llega a 4 se realiza la reserva del partido
        if($num_inscripciones >= '4'){
            
            if(isset($_REQUEST['id_partido'])){
                $id = $_REQUEST['id_partido'];
               
                if(isset( $_REQUEST['login'])){ $login = $_REQUEST['login'];  }
                elseif($_SESSION['login']){  $login = $_SESSION['login'];  }
                else{ $login= NULL; } 

                //se obtiene la fecha y hora del partido, se busca una pista disponible y realiza la reserva
                $Partido = new Partido($id, '', '', '', '', '');
                $model_partido = new PARTIDO_Model($Partido);
                $fecha_partido = $model_partido->Get_fecha();
                $horario_id = $model_partido->Get_id_horario();

                //se obtiene el numero de pistas
                $Pista = new Pista('', '');
                $model_pista = new PISTA_Model($Pista);
                $num_pistas = $model_pista->Get_num_pistas();

                //se obtiene el numero de reservas para la fecha y hora del partido
                $Reserva = new Reserva('', $fecha_partido, '', $horario_id, '');
                $model_reserva = new RESERVA_Model($Reserva);
                $num_reservas = $model_reserva->Get_num_reserva_fecha_hora();

                //si no hay pistas disponibles para ese dia/hora se cancela (elimina) el partido
                if($num_reservas >= $num_pistas){
                    //se elimina el partido
                    $respuesta = $model_partido->delete();

                    //se eliminan las inscripciones de ese partido
                    $Usuario_partido = new Usuario_partido($id, '', '', '', '', '');
                    $model_usuario_partido = new USUARIO_PARTIDO_Model($Usuario_partido);
                    $resultado = $model_usuario_partido->delete_partido();

                    if($resultado){
                        $_SESSION['text_message'] = "Se ha eliminado el partido y sus incripciones por no haber pistas disponibles";
                        $_SESSION['type_message'] = true;
                    }
                    header('Location:../Controllers/PARTIDO_Controller.php?action=INSCRIBIRSE_PARTIDO');

                }
                else{ //si hay pistas disponibles se realiza la reserva en la primera pista que haya disponible

                    $pista_disponible = $model_reserva->Get_pista_sin_reserva();

                    $Reserva = new Reserva($id, $fecha_partido, $login, $horario_id, $pista_disponible);
                    $model_reserva = new RESERVA_Model($Reserva);
                    $reserva = $model_reserva->Add();

                    //se actualiza el partido con el id de la reserva
                    if(isset($reserva['id_reserva'])){
                        $Partido = new Partido($id, '', '', '', $reserva['id_reserva'],'');
                        $model_partido = new PARTIDO_Model($Partido);
                        $partido = $model_partido->Update();

                        if($partido){
                            $_SESSION['text_message'] = "Se ha realizado la reserva del partido";
                            $_SESSION['type_message'] = true;
                        }
                        header('Location:../Controllers/PARTIDO_Controller.php?action=INSCRIBIRSE_PARTIDO');
                    }
                }
            }else{
                $_SESSION['text_message'] = "Se ha perdido el ID del partido";
                $_SESSION['type_message'] = false;

                header('Location:../Controllers/PARTIDO_Controller.php?action=INSCRIBIRSE_PARTIDO');
            }
        }else{
            $_SESSION['text_message'] = "Se ha inscrito el usuario en el partido";
            $_SESSION['type_message'] = false;
            
            header('Location:../Controllers/PARTIDO_Controller.php?action=INSCRIBIRSE_PARTIDO');
        }
        unset($_SESSION['text_message']);
        unset($_SESSION['type_message']);
        break;
    
    case 'DELETE':
        
           // checkPermission('USUARIO_PARTIDO','DELETE', $_SESSION['login']);

            $message = array();

            if (!$_POST){
                if($_SESSION["rol"]['nombre'] == 'Administrador'){

                    if(isset($_REQUEST["id_partido"]) && isset($_REQUEST["login"])){
                        $entity = get_data_form();
                        $model = new USUARIO_PARTIDO_Model($entity);
                        $respuesta = $model->delete();
                    }
                }
                else{
                    echo 'deposrtista, partido'.$_REQUEST["id_partido"];
                    
                    if(isset($_REQUEST["id_partido"])){echo 'partido ok';
                        $entity = new Usuario_partido($_SESSION["login"], $_REQUEST["id_partido"]);
                        $model = new USUARIO_PARTIDO_Model($entity);
                        $respuesta = $model->delete();
                    }
                }
            }

            if(isset($respuesta["text"]) && isset($respuesta["type"])){
                $_SESSION['text_message'] = $respuesta["text"];
                $_SESSION['type_message'] = $respuesta["type"];
            }

            if($_SESSION["rol"]['nombre'] == 'Administrador'){
                header('Location:../Controllers/PARTIDO_Controller.php?action=SHOWALL_PARTIDOS_INSCRIPCION');
            }else{
                header('Location:../Controllers/PARTIDO_Controller.php?action=INSCRIPCIONES_USER_PARTIDOS');
            }
        break;
   
    default:
            $_SESSION['currentController'] = 'PARTIDO';
            $_SESSION['currentEntity'] = 'Partido';

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
