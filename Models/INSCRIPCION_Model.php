<?php

class INSCRIPCION_Model
{
    var $mysqli;


    function __construct($inscripcion)
    {

        $this->inscripcion = $inscripcion;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    //Funcion para añadir inscripciones a la BD
    function ADD(){
        $fecha = $this->inscripcion->getFecha();
        $pareja_id = $this->inscripcion->getId_pareja();
        $cat_camp_id = $this->inscripcion->getId_cat_camp();

        $sql = "INSERT INTO INSCRIPCION( fecha, PAREJA_id, CATEGORIA_CAMPEONATO_id ) 
                            VALUES( '$fecha', '$pareja_id', '$cat_camp_id' )";


        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta; 
        }
        else{
            $this->respuesta["text"] = "Inscripcion registrada correctamente";
            $this->respuesta["type"] = true;
            return $this->respuesta; 
        }

    }

    //Función para eliminar inscripciones de la bd
    function DELETE(){
        $pareja_id = $this->inscripcion->getId_pareja();
        $cat_camp_id = $this->inscripcion->getId_cat_camp();

        $sql = "DELETE FROM INSCRIPCION WHERE (PAREJA_id = '$pareja_id') AND (CATEGORIA_CAMPEONATO_id = '$cat_camp_id')";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta; 
        }
        else{
            $this->respuesta["text"] = "Inscripcion ha sido eliminada correctamente";
            $this->respuesta["type"] = true;
            return $this->respuesta; 
        }

    }

    //Función para asignar grupo a las parejas en una categoría de un campeonato
    function SET_GRUPO($grupo_id){
        $pareja_id = $this->inscripcion->getId_pareja();
        $cat_camp_id = $this->inscripcion->getId_cat_camp();

        $sql_up = "UPDATE INSCRIPCION SET 
                                            GRUPO_id = '$grupo_id'
                                        WHERE 
                                            PAREJA_id = '$pareja_id' 
                                        AND CATEGORIA_CAMPEONATO_ID = '$cat_camp_id'";

        if (!$resultado = $this->mysqli->query($sql_up)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta; 
        }
        else{
            $this->respuesta["text"] = "Grupos asignado a las parejas de una categoría";
            $this->respuesta["type"] = true;
            return $this->respuesta; 
        }
    }

    



}
