<?php

class HORARIO_Model{
    var $horario;
    var $mysqli;

    function __construct($horario){
        $this->horario = $horario;

        $this->todos_horarios = array(
                                        '07:30:00' => '09:00:00',
                                        '09:00:00' => '10:30:00',
                                        '10:30:00' => '12:00:00',
                                        '12:00:00' => '13:30:00',
                                        '13:30:00' => '15:00:00',
                                        '15:00:00' => '16:30:00',
                                        '16:30:00' => '18:00:00',
                                        '18:00:00' => '19:30:00',
                                        '19:30:00' => '21:00:00',
                                        '21:00:00' => '22:30:00',
                                        '22:30:00' => '00:00:00'
                                    );

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();
    }

    function AllData(){

        $sql = "SELECT * FROM `HORARIO` ORDER BY 'hora_inicio'";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {

            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }
    }

    function AllDataArray(){
        $result = $this->AllData();

        while($fila = mysqli_fetch_assoc($result)){
            $array[] = $fila;
        }
        return $array;
    }


    function delete()
    {
        $id = $this->horario->getId();

        $sql = "SELECT * FROM `HORARIO` WHERE (id = '$id')";
        $resultado = $this->mysqli->query($sql);
        
        if ($resultado->num_rows == 1) {

            $sql2 = "DELETE FROM HORARIO WHERE (id = '$id')";
            //echo($sql2); exit;

            if(!$resultado = $this->mysqli->query($sql2) ){
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }else{

                $this->respuesta["text"] = 'Eliminado correctamente';
                $this->respuesta["type"] = true;
                return $this->respuesta;
            }
        } 
        else {
            $this->respuesta["text"] = 'El elemento no existe';
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }

    }

    function horarios_disponibles(){

        $sql = "SELECT * FROM HORARIO ORDER BY hora_inicio";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            if($resultado <> NULL){

                while ($row = mysqli_fetch_array($resultado)) {
                    $this->horarios_anadidos[$row["hora_inicio"]] = $row["hora_fin"];
                }
            }
            
            if( $this->horarios_anadidos == NULL){
                return $this->todos_horarios;
            }
            else{

                foreach ($this->todos_horarios as $key => $value) {

                    if(!array_key_exists($key, $this->horarios_anadidos)){
                        $this->horarios_disponibles[$key] = $value;
                    }
                } 
                return $this->horarios_disponibles;
            }
        }
    }


    function ADD()
    {
        $hora_inicio = $this->horario->getHora_inicio();
        $hora_fin = $this->horario->getHora_fin();

        if (($hora_inicio <> '') || ($hora_fin <> '')){ // si los atributos estan vacios
           
            $sql = "SELECT * FROM 
                                HORARIO 
                            WHERE
                                    hora_inicio = '$hora_inicio' 
                                AND hora_fin = '$hora_fin'";

            if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                $this->respuesta["text"] = " No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else { //si la ejecución de la query no da error
                $num_rows = mysqli_num_rows($resultado);

                if($num_rows == 0){

                    $sql = "INSERT INTO HORARIO ( id, hora_inicio, hora_fin)
                                        VALUES ( NULL, '$hora_inicio', '$hora_fin' )";

                    if (!($resultado = $this->mysqli->query($sql))){ 
                        $this->respuesta["text"] = "No se podido registrar el horario";
                        $this->respuesta["type"] = false;
                        return $this->respuesta;
                    }
                    else{
                        $this->respuesta["text"] = "Registrado correctamente";
                        $this->respuesta["type"] = true;
                        return $this->respuesta;
                    }
                }
                else{
                    $this->respuesta["text"] = "Ya existe un horario con eses datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
            }
        }
        else{ 
            $this->respuesta["text"] = "Introduzca los valores en todos los campos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
    } // fin del metodo ADD

    function ShowAll(){

        $sql = "SELECT * FROM `HORARIO` ORDER BY hora_inicio";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {

            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }
    } //fin ShowAll

    function Get_horario(){

        $id = $this->horario->getId();

        $sql = "SELECT * FROM HORARIO WHERE id = '$id'";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    } //fin Get_horario

} //fin HORARIO_Model