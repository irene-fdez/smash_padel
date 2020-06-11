<?php

class USUARIO_PARTIDO_Model
{

   
    var $mysqli;


    function __construct($usuario_partido)
    {

        $this->usuario_partido = $usuario_partido;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function Get_inscripciones(){
        $id_partido = $this->usuario_partido->getId_partido();

        $sql = "SELECT inscritos FROM PARTIDO WHERE id = '$id_partido'";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            $row = mysqli_fetch_array($resultado);
            return $row[0];
        }
    }//fin Get_inscripciones

    function Add_inscripcion_partido(){
        $id_partido = $this->usuario_partido->getId_partido();

        $sql = "SELECT inscritos FROM PARTIDO WHERE id = '$id_partido'";
       
        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            
            $row = mysqli_fetch_array($resultado); 
            $num_inscripciones =  $row[0]; //se obtiene el numero de inscripciones para ese partido

            $sql2 = "SELECT COUNT(*) 
                        FROM USUARIO_PARTIDO 
                        WHERE PARTIDO_id = '$id_partido'";

            if (!$resultado2 = $this->mysqli->query($sql2)){ //si da error la ejecución de la query
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{ //si la ejecución de la query no da error
                
                $row2 = mysqli_fetch_array($resultado2); 
                $num_usuarios_inscritos =  $row2[0]; //se obtiene el numero de inscritos para ese partido

                if($num_usuarios_inscritos > $num_inscripciones){
                    $sql = "UPDATE 
                                PARTIDO 
                            SET 
                                inscritos = '$num_usuarios_inscritos'
                            WHERE 
                                id = '$id_partido'";

                    if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                        $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                        $this->respuesta["type"] = false;
                        return $this->respuesta;
                    }
                    else{
                        return true;
                    }
                }
            }

        }

    }


    function Add()
    {
        $login = $this->usuario_partido->getLogin_user();
        $id_partido = $this->usuario_partido->getId_partido();


        if ( ($login != '') || ($id_partido != '') ){ // si los atributos estan vacios
            
            if($this->Get_inscripciones() < 4){

                $sql = "SELECT * FROM USUARIO_PARTIDO 
                            WHERE  
                                    USUARIO_login = '$login'
                                AND PARTIDO_id = '$id_partido'
                            ";

                if (!$resultado = $this->mysqli->query($sql)){ 
                    $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{  
                    
                    $num_rows = mysqli_num_rows($resultado);
                    
                    if($num_rows == 0){    
                        $sql = "INSERT INTO USUARIO_PARTIDO( USUARIO_login, PARTIDO_id) 
                                                    VALUES( '$login', '$id_partido')";

                        if (!$resultado = $this->mysqli->query($sql)){ 
                            $this->respuesta["text"] = "No se ha podido inscribir al usuario";
                            $this->respuesta["type"] = false;
                            return $this->respuesta;
                        }
                        else{ 
                            
                            if($this->Add_inscripcion_partido() ){
                                $this->respuesta["text"] = "Inscrito en el partido correctamente";
                                $this->respuesta["type"] = true;
                                
                            }
                            return $this->respuesta;
                        }
                    }else{
                        $this->respuesta["text"] = "El usuario ya se ha inscrito para este partido";
                        $this->respuesta["type"] = false;
                        return $this->respuesta;
                    }
                }
            }else{ //si se llego al maximo de inscripciones
                $this->respuesta["text"] = "No se permiten más incripciones en este partido";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
        }else{ 
            $this->respuesta["text"] = "Introduzca todos los campos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
    } // fin del metodo ADD

    function delete(){
        $id_partido = $this->usuario_partido->getId_partido();
        $login = $this->usuario_partido->getLogin_user();

        $sql = " DELETE FROM 
                            USUARIO_PARTIDO 
                        WHERE 
                            USUARIO_login = '$login' 
                        AND PARTIDO_id = '$id_partido'";


        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{
        
            if($this->Update($id_partido) == true){
                $this->respuesta["text"] = "Dado de baja del partido correctamente";
                $this->respuesta["type"] = true;
            }
            return $this->respuesta; 
        }
    }

    function Update($id_partido){

        $sql = "SELECT * FROM PARTIDO";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado

            $sql = "UPDATE 
                        PARTIDO 
                    SET inscritos = (SELECT COUNT(*) 
                                        FROM USUARIO_PARTIDO 
                                        WHERE PARTIDO_ID = '$id_partido')
                    WHERE id = '$id_partido'
                    ";

            if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{
                return true;
            }
        }
    }  // fin del metodo Update 
    
    function delete_partido(){
        $id_partido = $this->usuario_partido->getId_partido();

        $sql = "DELETE FROM USUARIO_PARTIDO WHERE PARTIDO_id = '$id_partido'";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{
            return true;
        }

    }
}
