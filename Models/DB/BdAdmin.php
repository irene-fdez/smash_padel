<?php
/*
Autor: IMEDA
29/11/2017
Archivo php donde se realiza la conexion con la base de datos
*/
    if (!function_exists('ConnectDB')) { 
        
        function ConnectDB(){

            $mysqli = new mysqli("localhost", "abp_padel", "abp_padel","ABP_PADEL");

            if($mysqli->connect_errno){
                echo "Fallo al conectar a MYSQL: (" . $mysqli->connect_errno . " )" . $mysqli->connect_errno;
            }

            return $mysqli;
        }
    
    }

?>