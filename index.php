<?php

/**
 * Archivo php donde arranca la web
 * Autor: Alex -Grupo Imeda
 * Fecha: 28/11/2017
 */


//entrada a la aplicacion

//se va usar la session de la conexion
session_start();

//funcion de autenticacion
include './Functions/Authentication.php';


//si no ha pasado por el login de forma correcta
if (!IsAuthenticated()){
	header('Location:./Controllers/LOGIN_Controller.php');
}
//si ha pasado por el login de forma correcta 
else{
    header('Location:./Controllers/LOGIN_Controller.php');
}

?>
