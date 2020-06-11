<?php

class PISTA_Model{
    var $pista;
    var $mysqli;

    function __construct($pista)
    {
        $this->pista = $pista;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function AllData(){
        $sql = "SELECT * FROM PISTA ORDER BY tipo";

        if(!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else{
            if($resultado->num_rows == 0){
                return 0;
            }else{
                return $resultado;
            }
        }
    }

    function AllData_user($login){
        
        $sql = "SELECT P.* 
                FROM 
                    PISTA P,
                    RESERVA R,
                    HORARIO H
                WHERE
                        USUARIO_login = '$login'
                    AND R.PISTA_nombre = P.nombre
                    AND R.HORARIO_id = H.id
                GROUP BY P.nombre
                ORDER BY tipo";

        if(!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }else{
            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }
    }

    function Show_pistas_reserva(){
        $sql = "SELECT P.* 
                FROM 
                    PISTA P,
                    RESERVA R,
                    HORARIO H
                WHERE
                        R.PISTA_nombre = P.nombre
                    AND R.HORARIO_id = H.id
                    
                GROUP BY P.nombre
                ORDER BY tipo";

        if(!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else{
            if($resultado->num_rows == 0){
                return 0;
            }else{
                return $resultado;
            }
        }
    }

    function getData(){
        $nombre = $this->pista->getNombre();
           
        $sql = "SELECT  * FROM PISTA  WHERE  nombre = '$nombre' ";

        if(!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }else{
            $result = $resultado->fetch_array();
            return $result;
        }
    }


    
    function Add(){
        $nombre = $this->pista->getNombre();
        $tipo = $this->pista->getTipo();

        if (($nombre <> '') || ($tipo <> '') ){ // si los atributos no estan vacios
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM PISTA WHERE nombre = '$nombre' AND tipo = '$tipo'";

            if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{ //si la ejecución de la query no da error
                $num_rows = mysqli_num_rows($resultado);
                if($num_rows == 0){
                    $sql = "INSERT INTO PISTA( nombre, tipo) 
                                        VALUES( '$nombre','$tipo')";

                    if (!($resultado = $this->mysqli->query($sql))){ 
                        $this->respuesta["text"] = "No se ha podido registrar la pista";
                        $this->respuesta["type"] = false;
                        return $this->respuesta;
                    }
                    else{
                        $this->respuesta["text"] = 'Pista insertada correctamente';
                        $this->respuesta["type"] = true;
                        return $this->respuesta;
                    }
                }
                else{
                    $this->respuesta["text"] = "Ya existe una pista con esos datos asociados";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
            }
        }
        else{
            $this->respuesta["text"] = "Introduzca todos los campos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }


    }

    function delete(){
        $nombre = $this->pista->getNombre();

        $sql = "SELECT * FROM `PISTA` WHERE nombre = '$nombre'";
        $resultado = $this->mysqli->query($sql);
        
        if($resultado->num_rows == 1) {

            $sql2 = "DELETE FROM PISTA WHERE nombre = '$nombre'";
            //echo($sql2); exit;

            if(!$resultado = $this->mysqli->query($sql2) ){
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{
                $this->respuesta["text"] = 'Pista eliminada correctamente';
                $this->respuesta["type"] = true;
                return $this->respuesta;
            }
        } 
        else {
            $this->respuesta["text"] = 'La pista no existe en la base de datos';
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
    }

    function ShowAll(){
        $sql = "SELECT * FROM PISTA ORDER BY nombre";

		if (!($resultado = $this->mysqli->query($sql))){
			$this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
		}
		else{
			return $resultado;
		}
    }

    function Get_num_pistas(){
        $sql = "SELECT count(*) FROM PISTA ";

        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] ='No se ha podido conectar con la base de datos';
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else { 
            $row = mysqli_fetch_array($resultado);
			return $row[0];
        }
    }

    

}