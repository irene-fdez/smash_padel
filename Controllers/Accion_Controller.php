<?php


session_start(); //solicito trabajar con la session

include '../Functions/Authentication.php';
if (!IsAuthenticated()){ //si no está autenticado
    header('Location:../Controllers/LOGIN_Controller.php');
}else{ //si lo esta

    require_once('../Models/Action_Model.php');
    require_once('../Models/Role_Model.php');
    include_once '../Entities/Action.php';
    include_once '../Functions/Authentication.php';
    
    function get_data_form(){ 

        if(isset($_REQUEST['id']))
            $IdAccion= $_REQUEST['id']; 
        else
            $IdAccion = NULL;

        if(isset($_REQUEST['nombre']))
            $NombreAccion = $_REQUEST['nombre']; 
        else
            $NombreAccion = NULL;

        if(isset($_REQUEST['descripcion']))
            $DescripAccion = $_REQUEST['descripcion']; 
        else 
            $DescripAccion = NULL;

        $ACCION = new Action(
            $IdAccion,
            $NombreAccion,
            $DescripAccion);

        return $ACCION;
    }

    if (!isset($_REQUEST['action'])){ 
        $_REQUEST['action'] = '';
    }

    $Permi = new Role_Model('');

    $_SESSION['currentEntity'] = 'Accion';
	$_SESSION['currentKey'] = 'id';

    $col_name = array(
        'id' => 'Id',
        'nombre' => 'Nombre Accion', 
        'descripcion' => 'Descripcion Acción'
    );
    
    $message = array();
    
    Switch ($_REQUEST['action']){ 

        case 'ADD':
          
            checkPermission('ACCION','ADD', $_SESSION['dni']);

            if (!$_POST){ 
                include '../Views/Accion/Add.php';
                new Add('',$col_name,false);
            }
            else{
                $action = get_data_form();
                
                if(!$action->check()) {
                    
                    $model = new Action_Model($action);
                    $respuesta = $model->Add();
                
                    $_SESSION['text_message'] = $respuesta;
                    $_SESSION['type_message'] = true;
                    
                } else {
                    
                    $model = new Action_Model('');
                    
                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = true;
                }
                
                header('Location:../Controllers/Accion_Controller.php');
            }
            
            break;
                

        case 'DELETE':

            checkPermission('ACCION','DELETE', $_SESSION['dni']);

            if (isset($_POST)){
                
                $action = get_data_form();
                
                $model = new Action_Model($action);
                $respuesta = $model->Delete();

                $_SESSION['text_message'] = $respuesta;
                $_SESSION['type_message'] = true;
            }

            header('Location:../Controllers/Accion_Controller.php');
            break;

        case 'EDIT':
            
            checkPermission('ACCION','EDIT', $_SESSION['dni']);

            $action = get_data_form();

            $model = new Action_Model($action);

            if (!$_POST){

                $data = $model->getData();
                
                include '../Views/Accion/Add.php';
                new Add($data, $col_name, true);
            }
            else{
                
                if(!$action->check()) {
                    $respuesta = $model->Edit();
                    $_SESSION['text_message'] = $respuesta;
                    $_SESSION['type_message'] = true;
                } else {
                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = false;
                }
                
                header('Location:../Controllers/Accion_Controller.php');
            }
            break;


        case 'SHOWCURRENT':

            checkPermission('ACCION','SHOWCURRENT', $_SESSION['dni']);

            $entity = get_data_form();

            $model = new Action_Model($entity);

            $data = $model->getData();

            include '../Views/Template/Showcurrent.php';
            new ShowCurrent($data);

            break;

        default:

            checkPermission('ACCION','SHOWALL', $_SESSION['dni']);

            $action_model = new Action_Model('');

            $data = $action_model->AllData();

            $labels = array_keys($data->fetch_assoc());
            
            include '../Views/Template/Showall.php';
            new Showall($data, $col_name, $message);

            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);

    }

}
?>