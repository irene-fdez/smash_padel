<?php

session_start();

require_once('../Models/USUARIO_Model.php');
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
        $password = NULL;
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
        $rol = '2';
    }
    
    $User = new User($login,$password,$nombre,$apellidos,$genero,$email,$rol);

    return $User;
}
            $message = array();
            if (!$_POST){
                include '../Views/core/Register.php';
                new Register();
            }
            else{
                $user = get_data_form();
                if(!$user->check()) {

                    $model = new USUARIO_Model($user);
                    $respuesta = $model->Add();
                    if($respuesta === true){
                        $respuesta = $model->setUserRole(2);
                        if ($respuesta === true){
                            $message['text'] = 'Usuario registrado correctamente';
                            $message['type'] = true;
                        }else{
                            $message['text'] = $respuesta;
                            $message['type'] = false;
                        }
                    }else{
                        $message['text'] = $respuesta;
                        $message['type'] = false;  
                    }
                }else {
                    $message['text'] = 'Datos no válidos';
                    $message['type'] = false;
                }
                header('Location:../Controllers/LOGIN_Controller.php?resp='.$respuesta);
                die();

            }
 


?>
