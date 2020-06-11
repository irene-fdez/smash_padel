<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no está autenticado

    header('Location:../Controllers/LOGIN_Controller.php');
}
else{ //si lo esta


    require_once('../Models/ROL_Model.php');
    require_once('../Models/Functionality_Model.php');
    require_once('../Models/Action_Model.php');
    
    include_once '../Entities/Rol.php';
    
    function get_data_form(){ //recoge los valores del formulario

        if(isset($_REQUEST['id'])) {
            $IdRol = $_REQUEST['id'];
        } else {
            $IdRol = NULL;
        }

        if(isset($_REQUEST['nombre'])) {
            $NombreRol = $_REQUEST['nombre']; 
        } else {
            $NombreRol = NULL; 
        }


        $Rol = new Rol(
            $IdRol,
            $NombreRol
        );

        return $Rol;
    }

    if (!isset($_REQUEST['action'])){
        $_REQUEST['action'] = '';
    }

    $Permi = new ROL_Model('');

    $_SESSION['currentEntity'] = 'Rol';
	$_SESSION['currentKey'] = 'id';

    $col_name = array(
        'id' => 'Id',
        'nombre' => 'Nombre'
    );
    
    $message = array();

    Switch ($_REQUEST['action']){ 
        
        case 'ADD':
          
            checkPermission('PERMISO','ADD', $_SESSION['login']);

            if (!$_POST) { 
                
                $model = new ROL_Model(new Rol($_SESSION['login'],'','','',''));
                $data = array($model->getActionFunctionality(),array());
                include '../Views/Rol/Add.php';
                new Add($data,$col_name,false);
            }
            else{

                $entity = get_data_form();
                $model = new ROL_Model($entity);
                
                if(!$entity->check()) {
                    
                    $respuesta = $model->Add();

                    $data = $model->getActionFunctionality();
                    
                    foreach($data[1] as $functionality) {
                        foreach($data[0] as $action) {
                            
                            if (isset($_POST[$functionality['id'].'_'.$action['id']]) == true)    
                                $respuesta = $model->setRolPermission($functionality['id'],$action['id']);
                        }
                    }                    
                    
                    $_SESSION['text_message'] = $respuesta;
                    $_SESSION['type_message'] = true;
                    
                } else {
                    
                    $model = new ROL_Model('');
                    
                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = true;
                }
                    
                header('Location:../Controllers/ROL_Controller.php');
            }
                
            break;
                    
               

        
        case 'DELETE':

            checkPermission('PERMISO','DELETE', $_SESSION['login']);

            if ($_POST) {
                $entity = get_data_form();
                $model = new ROL_Model($entity);
                
                $respuesta = $model->Delete();

                $_SESSION['text_message'] = $respuesta;
                $_SESSION['type_message'] = true;
            }

            header('Location:../Controllers/ROL_Controller.php');       
            break;

        case 'EDIT':

            checkPermission('PERMISO','EDIT', $_SESSION['login']);

            $entity = get_data_form();

            $model = new ROL_Model($entity);
            if (!$_POST){
                
                $data = array( $model->getActionFunctionality(), $model->getData());
                include '../Views/Rol/Add.php';
                new Add($data, $col_name, true);
            }
            else{
                if(!$entity->check()) {

                    $respuesta = $model->Edit();
                    
                    $data = $model->getActionFunctionality();
                    $respuesta = $model->DeletePermission();
                    
                    
                    foreach($data[1] as $functionality) {
                        foreach($data[0] as $action) {
                            
                            if (isset($_POST[$functionality['id'].'_'.$action['id']]) == true)    
                                $model->setRolPermission($functionality['id'],$action['id']);
                        }
                    }

                    $_SESSION['text_message'] = $respuesta;
                    $_SESSION['type_message'] = true;
                } else {
                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = true;
                }
                
                header('Location:../Controllers/ROL_Controller.php');
            }
            break;
                

        case 'SHOWCURRENT':

            checkPermission('PERMISO','SHOWCURRENT', $_SESSION['login']);
                
            $entity = get_data_form();

            $model = new ROL_Model($entity);

            $data = $model->getData();

            include '../Views/Template/Showcurrent.php';
            new Showcurrent($data);

            break;


        default:

            checkPermission('PERMISO','SHOWALL', $_SESSION['login']);
                
            $model = new ROL_Model('');

            $data = $model->AllData();

            $labels = array_keys($data->fetch_assoc());
            
            
            include '../Views/Template/Showall.php';
            new Showall($data, $col_name, $message);

            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);   
            
            break;
    } //fin switch

}
?>