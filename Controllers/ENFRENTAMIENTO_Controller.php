<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){ //si no esta autenticado

    header('Location:../Controllers/LOGIN_Controller.php');

}else{ //si lo esta


    require_once('../Models/ENFRENTAMIENTO_Model.php');
    require_once('../Models/CAMPEONATO_Model.php');
    require_once('../Models/CATEGORIA_Model.php');
    require_once('../Models/GRUPO_Model.php');
    require_once('../Models/CLASIFICACION_Model.php');
    include_once '../Entities/Enfrentamiento.php';
    include_once '../Entities/Campeonato.php';
    include_once '../Entities/Categoria.php';
    include_once '../Entities/Grupo.php';
    include_once '../Entities/Clasificacion.php';

    if(isset($_REQUEST['campeonato_id'])){
        $campeonato_id = $_REQUEST['campeonato_id'];
    }else{
        $campeonato_id = NULL;
    }

    if(isset($_REQUEST['id'])){
        $enfrentamiento_id = $_REQUEST['id'];
    }else{
        $enfrentamiento_id = NULL;
    }
    
    if(isset($_REQUEST['cat_grupo'])){
        $cat_grupo = explode('-',$_REQUEST['cat_grupo']);
        $categoria_id = $cat_grupo[0];
        $grupo_id = $cat_grupo[1];
    }else{
        if(isset($_REQUEST['grupo_id']))  $grupo_id = $_REQUEST['grupo_id'];
        else $grupo_id = NULL;

        if(isset($_REQUEST['categoria_id']))  $categoria_id = $_REQUEST['categoria_id'];
        else $categoria_id = NULL;
    }


    function get_data_form(){

        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
        }else{
            $id = NULL;
        }

        if(isset($_REQUEST['resultado'])){
            $resultado = $_REQUEST['resultado'];
        }else{
            $resultado = NULL ;
        }

        if(isset($_REQUEST['pareja1'])){
            $pareja1 = $_REQUEST['pareja1'];
        }else{
            $pareja1 = NULL;
        }

        if(isset($_REQUEST['pareja2'])){
            $pareja2 =  $_REQUEST['pareja2'];
        }else{
            $pareja2 = NULL;
        }

        if(isset($_REQUEST['grupo_id'])){
            $grupo_id= $_REQUEST['grupo_id'];
        }else{
            $grupo_id = NULL;
        }
        
        if(isset($_REQUEST['reserva_id'])){
            $reserva_id= $_REQUEST['reserva_id'];
        }else{
            $reserva_id = NULL;
        }

        $Enfrentamiento = new Enfrentamiento($id, $resultado, $pareja1, $pareja2, $grupo_id, $reserva_id);

        return $Enfrentamiento;
    }

    function get_data_form_resultado(){
        
        if(isset($_REQUEST['set1_p1'])){
            $set1_p1 = $_REQUEST['set1_p1'];
        }else{
            $set1_p1 = NULL;
        }

        if(isset($_REQUEST['set1_p2'])){
            $set1_p2 = $_REQUEST['set1_p2'];
        }else{
            $set1_p2 = NULL;
        }

        if(isset($_REQUEST['set2_p1'])){
            $set2_p1 = $_REQUEST['set2_p1'];
        }else{
            $set2_p1 = NULL;
        }

        if(isset($_REQUEST['set2_p2'])){
            $set2_p2 = $_REQUEST['set2_p2'];
        }else{
            $set2_p2 = NULL;
        }

        if(isset($_REQUEST['set3_p1'])){
            $set3_p1 = $_REQUEST['set3_p1'];
        }else{
            $set3_p1 = NULL;
        }

        if(isset($_REQUEST['set3_p2'])){
            $set3_p2 = $_REQUEST['set3_p2'];
        }else{
            $set3_p2 = NULL;
        }

        return $set1_p1."-".$set1_p2.", ".$set2_p1."-".$set2_p2.", ".$set3_p1."-".$set3_p2;
    }

    if (!isset($_REQUEST['action'])){

        $_REQUEST['action'] = '';
    }

    $_SESSION['currentController'] = 'ENFRENTAMIENTO';
    $_SESSION['currentEntity'] = 'Enfrentamiento';
    $_SESSION['currentKey'] = 'id';


    Switch ($_REQUEST['action']){

        case 'SHOW_ENFRENTA':
                if(isset($_REQUEST['add_result'])){
                    $add_result = true;
                }else{
                    $add_result = false;
                }

                $model_enfrent = new ENFRENTAMIENTO_Model('');
                $enfrentamientos = $model_enfrent->Show_enfrent_camp($campeonato_id);
            
                $model_camp = new CAMPEONATO_Model(new Campeonato($campeonato_id, '', '', ''));
                $datos_camp = $model_camp->Get_datos_campeonato();
                $cat_grupo = $model_camp->Get_cat_grupo();


                include '../Views/ENFRENTAMIENTO/ENFRENTAMIENTOS/Select_categoria_grupo.php';
                new Select_categoria_grupo($datos_camp, $cat_grupo, $add_result);
            break;

        case 'RESULTADOS': 
                $model_camp = new CAMPEONATO_Model( new Campeonato($campeonato_id, '','','') );
                //$nombre_camp = $model_camp->Get_nombre();
                $datos_camp = $model_camp->Get_datos_campeonato();

                $model_cat = new CATEGORIA_Model( new Categoria($categoria_id,'','') );
                $datos_cat = $model_cat->Get_datos_categoria();

                $model_grupo = new GRUPO_Model( new Grupo($grupo_id, '','','','') );
                $datos_grupo = $model_grupo->Get_datos_grupo();

                $model_enfrent = new ENFRENTAMIENTO_Model( new Enfrentamiento('','','','', $grupo_id, '') );
                $fase_grupos = $model_enfrent->Show_enfrent_grupo_fin();
                $message = array();

                include '../Views/ENFRENTAMIENTO/ENFRENTAMIENTOS/Show_enfrentamientos_resultados.php';
                new Show_enfrentamientos_resultados($datos_camp, $datos_cat, $datos_grupo, $fase_grupos, $message);
                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);
            break;

        case 'ADD_RESULTADOS':
                //si no viene del post va a la vista para introducir los resultados
                if(!$_POST){
                    //get_data_form(); para obtener el id_enfrentamiento y el id_grupo
                    $model = new ENFRENTAMIENTO_Model( get_data_form() );
                    $enfrentamiento = $model->Get_datos_enfrentamiento();
                    include '../Views/ENFRENTAMIENTO/ENFRENTAMIENTOS/Add_resultados_enfrentamiento.php';
                    new Add_resultados_enfrentamiento($enfrentamiento);
                }//si viene del post se añaden los resultados y vuelve a la vista de los resultados
                else{
                    $resultado = get_data_form_resultado();
                    $model_enfrenta = new ENFRENTAMIENTO_Model (new Enfrentamiento($enfrentamiento_id, $resultado,'','', $grupo_id, '') );
                    $update_enfrenta = $model_enfrenta->Update_resultado();

                    $model_clasif = new CLASIFICACION_Model('');
                    $clasificacion = $model_clasif->Update_clasificacion($enfrentamiento_id, $resultado);

                    //Se comprueba si el enfrentamiento para el que se ha actualizado los resultados es el último
                    $model_campeonato = new CAMPEONATO_Model('');
                    $promo_grupo = $model_campeonato->Comprobar_etapa($grupo_id);
                    if($promo_grupo){
                        $_SESSION['text_message'] = 'Ha terminado la fase de Liga Regular!';
                        $_SESSION['type_message'] = true;
                    }

                    header('Location:../Controllers/ENFRENTAMIENTO_Controller.php');
                }

            break;

        case 'GESTION_HORARIO':
                $login = $_SESSION['login'];

                if(isset($_REQUEST['opcion'])) $opcion = $_REQUEST['opcion'];
                else $opcion = 'ofertas';

                $model = new ENFRENTAMIENTO_Model('');
                //Ofertas hechas al usuario
                $oferta_usuario_pareja1 = $model->Show_ofertas_pareja1($login);
                $oferta_usuario_pareja2 = $model->Show_ofertas_pareja2($login);

                //Ofertas propuestas por el usuario
                $oferta_propuesta_pareja1 = $model->Show_ofertas_propuestas_pareja1($login);
                $oferta_propuesta_pareja2 = $model->Show_ofertas_propuestas_pareja2($login);

                //Enfrentamientos sin ofertas
                $enfrent_sin_oferta_pareja1 = $model->Show_enfrent_sin_oferta_pareja1($login);
                $enfrent_sin_oferta_pareja2 = $model->Show_enfrent_sin_oferta_pareja2($login);

                include '../Views/ENFRENTAMIENTO/HORARIOS/Gestion_horarios.php';
                new Gestion_horarios($oferta_usuario_pareja1, $oferta_usuario_pareja2, $oferta_propuesta_pareja1, $oferta_propuesta_pareja2, $enfrent_sin_oferta_pareja1, $enfrent_sin_oferta_pareja2, $opcion);
                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);
            break;

        case 'ENFRENTAMIENTOS_CAT_CAMP':
                $model_camp = new CAMPEONATO_Model( new Campeonato($campeonato_id, '','','') );
                //$nombre_camp = $model_camp->Get_nombre();
                $datos_camp = $model_camp->Get_datos_campeonato();

                $model_cat = new CATEGORIA_Model( new Categoria($categoria_id,'','') );
                $datos_cat = $model_cat->Get_datos_categoria();

                $model_grupo = new GRUPO_Model( new Grupo($grupo_id, '','','','') );
                $datos_grupo = $model_grupo->Get_datos_grupo();

                $model_enfrent = new ENFRENTAMIENTO_Model( new Enfrentamiento('','','','', $grupo_id, '') );
                $fase_grupos = $model_enfrent->Show_enfrent_grupo();
                $message = array();

                include '../Views/ENFRENTAMIENTO/ENFRENTAMIENTOS/Show_enfrentamiento_categoria_grupo.php';
                new Show_enfrentamiento_categoria_grupo($datos_camp, $datos_cat, $datos_grupo, $fase_grupos, $message);
                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);
            break;

        default:
                $model_camp = new CAMPEONATO_Model('');
                $data = $model_camp->Get_campeonatos_enfrentamientos();
                $message = array();
                
                include '../Views/ENFRENTAMIENTO/ENFRENTAMIENTOS/Show_campeonatos_enfrentamientos.php';
                new Show_campeonatos_enfrentamientos($data, $message);
                unset($_SESSION['text_message']);
                unset($_SESSION['type_message']);
            break;
        
    }

}
