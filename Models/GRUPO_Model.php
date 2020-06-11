<?php

class GRUPO_Model
{

   
    var $mysqli;


    function __construct($grupo)
    {

        $this->grupo = $grupo;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function ADD(){
       
        $nombre = $this->grupo->getNombre();
        $campeonato_id = $this->grupo->getId_campeonato();
        $categoria_id = $this->grupo->getId_categoria();


        $sql = "INSERT INTO GRUPO(nombre,CAMPEONATO_id,CATEGORIA_id) 
                            VALUES('$nombre','$campeonato_id','$categoria_id')";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            $this->respuesta["text"] = "Grupo insertado correctamente";
            $this->respuesta["type"] = true;
            return $this->respuesta;
        }
    }//fin ADD

    
    function Get_datos_grupo(){
        $id = $this->grupo->getId();

        $sql = "SELECT * FROM GRUPO WHERE id = '$id'";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }//fin Get_datos_grupo

    function Numero_grupos(){
        $campeonato_id = $this->grupo->getId_campeonato();

        $sql = "SELECT * FROM GRUPO WHERE CAMPEONATO_id = '$campeonato_id' ";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else return $resultado->num_rows;
    }//fin Numero_grupos

}//fin GRUPO_Model
