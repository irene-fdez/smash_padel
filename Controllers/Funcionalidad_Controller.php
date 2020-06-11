<?php


session_start(); 
include '../Functions/Authentication.php';
if (!IsAuthenticated()){ //si no está autenticado
    header('Location:../Controllers/LOGIN_Controller.php');
}else{ //si lo esta


    require_once('../Models/Functionality_Model.php');
    require_once('../Models/Role_Model.php');
    include_once '../Entities/Functionality.php';
    include_once '../Functions/Authentication.php';
    
    function get_data_form(){ 

        if(isset($_REQUEST['id']))
            $IdFuncionalidad= $_REQUEST['id']; 
        else
            $IdFuncionalidad = NULL;

        if(isset($_REQUEST['nombre']))
            $NombreFuncionalidad = $_REQUEST['nombre']; 
        else
            $NombreFuncionalidad = NULL;

        if(isset($_REQUEST['descripcion']))
            $DescripFuncionalidad = $_REQUEST['descripcion']; 
        else
            $DescripFuncionalidad = NULL;

        if(isset($_REQUEST['action']))
            $action = $_REQUEST['action']; 
        else
            $action = NULL; 

        
        $FUNCIONALIDAD = new Functionality(
            $IdFuncionalidad,
            $NombreFuncionalidad,
            $DescripFuncionalidad);

        return $FUNCIONALIDAD;
    }

    if (!isset($_REQUEST['action'])){
        $_REQUEST['action'] = '';
    }

    $Permi = new Role_Model(''); 

    $_SESSION['currentEntity'] = 'Funcionalidad';
	$_SESSION['currentKey'] = 'id';

    $col_name = array(
        'id' => 'Id',
        'nombre' => 'Nombre', 
        'descripcion' => 'Descripción'
    );

    $message = array();
    
    Switch ($_REQUEST['action']){ 

        case 'ADD':

            checkPermission('FUNCIONALIDAD','ADD', $_SESSION['dni']);

            $message = array();

            if (!$_POST){ 
                include '../Views/Funcionalidad/Add.php';
                new Add('',$col_name,false);
            }
            else{

                $entity = get_data_form();
                
                if(!$entity->check()) {
                    
                    $model = new Functionality_Model($entity);
                    
                    $respuesta = $model->Add();
                        
                    $_SESSION['text_message'] = $respuesta;
                    $_SESSION['type_message'] = true;
                        
                } else {
                        
                    $model = new Functionality_Model('');
                    
                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = false;
                }
                    
                header('Location:../Controllers/Funcionalidad_Controller.php');
            }
                
                break;


        case 'DELETE':

            checkPermission('FUNCIONALIDAD','DELETE', $_SESSION['dni']);

            if ($_POST) {
                
                $entity = get_data_form();
                $model = new Functionality_Model($entity);
                
                $respuesta = $model->Delete();
                
                $_SESSION['text_message'] = $respuesta;
                $_SESSION['type_message'] = true;
            }

            header('Location:../Controllers/Funcionalidad_Controller.php');
            break;


        case 'EDIT':            

            checkPermission('FUNCIONALIDAD','EDIT', $_SESSION['dni']);

            $entity = get_data_form();
            
            $model = new Functionality_Model($entity);

            if (!$_POST) {

                $data = $model->getData();
                
                include '../Views/Funcionalidad/Add.php';
                new Add($data, $col_name, true);
            }
            else{
                
                if(!$entity->check()) {
                    $respuesta = $model->Edit();
                    $_SESSION['text_message'] = $respuesta;
                    $_SESSION['type_message'] = true;
                } else {
                    $_SESSION['text_message'] = 'Datos Incorrectos';
                    $_SESSION['type_message'] = false;
                }
                
                header('Location:../Controllers/Funcionalidad_Controller.php');
            }
            break;


        case 'SHOWCURRENT':        

                checkPermission('FUNCIONALIDAD','SHOWCURRENT', $_SESSION['dni']);

                $entity = get_data_form();

                $model = new Functionality_Model($entity);

                $data = $model->getData();

                include '../Views/Template/Showcurrent.php';
                new ShowCurrent($data);

                break;
            

        default:

            checkPermission('FUNCIONALIDAD','SHOWALL', $_SESSION['dni']);
            
            $model = new Functionality_Model('');

            $data = $model->AllData();

            $labels = array_keys($data->fetch_assoc());
            
            include '../Views/Template/Showall.php';
            new Showall($data, $col_name, $message);   

            unset($_SESSION['text_message']);
            unset($_SESSION['type_message']);
            }
}
?>