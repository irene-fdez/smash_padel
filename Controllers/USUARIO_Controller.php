<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta



require_once('../Models/USUARIO_Model.php');
require_once('../Models/ROL_Model.php');
include_once '../Entities/Usuario.php';


function get_data_form(){

    if(isset($_REQUEST['login'])){
        $login = $_REQUEST['login'];
    }else{
        $login = NULL;
    }
    
    if(isset($_REQUEST['password'])){
        $password = $_REQUEST['password'];
    }else{
        if(isset($_REQUEST['password2'])){
            $password = $_REQUEST['password2'];
        }else{
            $password = NULL;
        }
    }
    if(isset($_REQUEST['nombre'])){
        $nombre = $_REQUEST['nombre'];
    }else{
        $nombre = NULL;
    }
    if(isset($_REQUEST['apellidos'])){
        $apellidos = $_REQUEST['apellidos'];
    }else{
        $apellidos = NULL;
    }
    if(isset($_REQUEST['genero'])){
        $genero= $_REQUEST['genero'];
    }else{
        $genero = NULL;
    }
    if(isset($_REQUEST['email'])){
        $email = $_REQUEST['email'];
    }else{
        $email = NULL;
    }
    if(isset($_REQUEST['rol'])){
        $rol = $_REQUEST['rol'];
    }else{
        $rol = NULL;
    }


    $User = new Usuario($login,$password,$nombre,$apellidos,$genero,$email, $rol);

    return $User;
}

if (!isset($_REQUEST['action'])){

    $_REQUEST['action'] = '';
}

$_SESSION['currentController'] = 'USUARIO';
$_SESSION['currentEntity'] = 'Usuario';
$_SESSION['currentKey'] = 'login';


$Permi = new ROL_Model('');


Switch ($_REQUEST['action']){

    case 'ADD':
        checkPermission('USUARIO','ADD', $_SESSION['login']);

            $message = array();

            if (!$_POST){

                $model = new ROL_Model('');
                $data = array($model->AllData());
                include '../Views/USUARIO/Add.php';
                new Add($data,false);
            }
            else{

                $user = get_data_form();
                if(!$user->check()) {
                    $model = new ROL_Model('');
                    $data = $model->AllData();

                    $model = new USUARIO_Model($user);
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

                } else {

                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = false;
                }
                header('Location:../Controllers/USUARIO_Controller.php');
            }


        break;

    case 'DELETE':

         checkPermission('USUARIO','DELETE', $_SESSION['login']);

            $message = array();

            if ($_POST){

                $entity = get_data_form();
                $model = new USUARIO_Model($entity);
                $respuesta = $model->delete();

                if(isset($respuesta["text"]) && isset($respuesta["type"])){
                    $_SESSION['text_message'] = $respuesta["text"];
                    $_SESSION['type_message'] = $respuesta["type"];
                }
            }
            header('Location:../Controllers/USUARIO_Controller.php');


        break;

    case 'EDIT':

            checkPermission('USUARIO','EDIT', $_SESSION['login']);
            $message = array();
            $entity = get_data_form();
            $model = new USUARIO_Model($entity);
            
            if (!$_POST){
                $role_model = new ROL_Model('');
                $data = array($role_model->AllData(), $model->getData(), $model->getDataRoleUser());
                
                include '../Views/USUARIO/Add.php';
                new Add($data, true);
            }
            else{

                if(!$entity->checkEdit()) {
                
                    $model = new ROL_Model('');
                    $data = $model->AllData();
                    
                    $model = new USUARIO_Model($entity);
                    $respuesta = $model->Edit();

                   /* $model->deleteUserRoles();
                    foreach($data as $rol) {
                        if(isset($_POST['rol_'.$rol['id']]) == true ) {
                            $respuesta = $model->setUserRole($rol['id']);
                        }
                    }*/

                    if(isset($respuesta["text"]) && isset($respuesta["type"])){
                        $_SESSION['text_message'] = $respuesta["text"];
                        $_SESSION['type_message'] = $respuesta["type"];
                    }

                } else {
                    echo('else checkEdit');exit;

                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = false;
                }
                header('Location:../Controllers/USUARIO_Controller.php');
            }

        break;

    case 'SHOWCURRENT':
            checkPermission('USUARIO','SHOWCURRENT', $_SESSION['login']);

            $user = get_data_form();
            $user_model = new USUARIO_Model($user);

            $data = $user_model->getData();

            include '../Views/Template/Showcurrent.php';
            new Showcurrent($data);

        break;
        
    default:
            checkPermission('USUARIO','SHOWALL', $_SESSION['login']);
            $message = array();
            $model = new USUARIO_Model('');

            $data = $model->AllData();
          /*  print_r('<pre>');
            print_r($data );
            print_r('<pre>');
            
            print_r('<pre>');
            print_r( array_keys($data->fetch_assoc()));
            print_r('<pre>');//exit;*/

            
            if( !is_int($data) && !is_array( $data)){
                $labels = array_keys($data->fetch_assoc());
            }
            else{
                $labels=NULL;
                $data=NULL;
            }
            $message=array();
            include '../Views/Template/Showall.php';
            new Showall($data, $labels, $message);
            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
        break;
    }
}


?>
