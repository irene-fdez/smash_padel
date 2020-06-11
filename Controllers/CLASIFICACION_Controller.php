<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta

    require_once('../Models/CLASIFICACION_Model.php');
    require_once('../Models/CAMPEONATO_Model.php');
    require_once('../Models/GRUPO_Model.php');
    require_once('../Models/ENFRENTAMIENTO_Model.php');
    include_once '../Entities/Clasificacion.php';
    include_once '../Entities/Campeonato.php';
    include_once '../Entities/Grupo.php';

    if(isset($_REQUEST['campeonato_id'])) $campeonato_id = $_REQUEST['campeonato_id'];
    else $campeonato_id = NULL;

    if(isset($_REQUEST['cat_grupo'])){
        $cat_grupo = explode('-',$_REQUEST['cat_grupo']);
        $categoria_id = $cat_grupo[0];
        $grupo_id = $cat_grupo[1];
    }
    else{
        if(isset($_REQUEST['grupo_id']))  $grupo_id = $_REQUEST['grupo_id'];
        else $grupo_id = NULL;

        if(isset($_REQUEST['categoria_id']))  $categoria_id = $_REQUEST['categoria_id'];
        else $categoria_id = NULL;
    }

    function get_data_form(){

        if(isset($_REQUEST['id'])) $id = $_REQUEST['id'];
        else $id = NULL;

        if(isset($_REQUEST['puntos'])) $puntos = $_REQUEST['puntos'];
        else $puntos = NULL;

        if(isset($_REQUEST['pareja_id'])) $pareja_id = $_REQUEST['pareja_id'];
        else $pareja_id = NULL;

        if(isset($_SESSION['grupo_id'])) $grupo_id= $_SESSION['grupo_id'];
        else $grupo_id = NULL;

        return new Clasificacion($id, $puntos, $pareja_id, $grupo_id);
    }

    if (!isset($_REQUEST['action'])){

        $_REQUEST['action'] = '';
    }

    $_SESSION['currentController'] = 'CLASIFICACION';
    $_SESSION['currentEntity'] = 'Clasificacion';
    $_SESSION['currentKey'] = 'id';


    Switch ($_REQUEST['action']){
        case 'RANKING':
                $model_camp = new CAMPEONATO_Model(new Campeonato($campeonato_id,'','',''));
                $datos_camp = $model_camp->Get_datos_campeonato();

                $model_clasif = new CLASIFICACION_Model(new Clasificacion('','','', $grupo_id));
                $camp_cat_grupo = $model_clasif->Get_camp_cat_grupo($campeonato_id, $categoria_id);
                //se obtienen los datos de la clasificacion para la categoria-grupo seleccionada
                $clasificaciones = $model_clasif->Get_clasificaciones_camp($campeonato_id, $categoria_id);

                $model_grupo = new GRUPO_Model(new Grupo('','',$campeonato_id,''));
                $num_grupos = $model_grupo->Numero_grupos();
                $message = array();


                include '../Views/CLASIFICACION/Show_ranking.php';
                new Show_ranking($datos_camp, $camp_cat_grupo, $clasificaciones, $num_grupos, $message);

            break;

        case 'SHOW_ENFRENTA':
            
            $model_enfrent = new ENFRENTAMIENTO_Model('');
            $enfrentamientos = $model_enfrent->Show_enfrent_camp($campeonato_id);
        
            $model_camp = new CAMPEONATO_Model(new Campeonato($campeonato_id, '', '', ''));
            $datos_camp = $model_camp->Get_datos_campeonato();
            $cat_grupo = $model_camp->Get_cat_grupo();

            include '../Views/CLASIFICACION/Select_categoria_ranking.php';
            new Select_categoria_ranking($datos_camp, $cat_grupo);
        break;

        default:
                $model_camp = new CAMPEONATO_Model('');
                $data = $model_camp->Campeonatos_clasificacion();
                $message = array();

                include '../Views/CLASIFICACION/Show_campeonatos_clasificacion.php';
                new Show_campeonatos_clasificacion($data, $message);
            break;
        
    }

}
?>
