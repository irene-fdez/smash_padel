<?php

class CATEGORIA_Model
{
    var $mysqli;


    function __construct($categoria)
    {

        $this->categoria = $categoria;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function AllData(){
        $sql = "SELECT * FROM CATEGORIA ORDER BY id";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }

    }//fin AllData

    function Get_categorias_campeonato($campeonato_id, $capitan, $jugador2){
        $sql_cap = "SELECT genero FROM USUARIO WHERE login = '$capitan'";
        $sql_j2 = "SELECT genero FROM USUARIO WHERE login = '$jugador2'";

        if ( !($resultado_cap = $this->mysqli->query($sql_cap)) OR !($resultado_j2 = $this->mysqli->query($sql_j2)) ){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            $row_cap = mysqli_fetch_array($resultado_cap);
            $row_j2 = mysqli_fetch_array($resultado_j2);
            $genero_camp = $row_cap[0];
            $genero_j2 = $row_j2[0];
            
          
            if($genero_camp == $genero_j2){
                $sql = "SELECT 
                        CC.id, CAT.id AS categoria_id, CAT.nivel, CAT.genero 
                    FROM 
                        CATEGORIA_CAMPEONATO CC, CAMPEONATO CAM, CATEGORIA CAT  
                    WHERE 
                            CC.CAMPEONATO_id = '$campeonato_id'
                        AND CC.CAMPEONATO_id = CAM.id
                        AND CC.CATEGORIA_id = CAT.id
                        AND  CC.id NOT IN 
                                    ( SELECT 
                                        I.CATEGORIA_CAMPEONATO_id 
                                    FROM 
                                        INSCRIPCION I, PAREJA P 
                                    WHERE 
                                            I.PAREJA_ID = P.id
                                        AND (  ( P.capitan = '$capitan' OR P.jugador_2 = '$jugador2' ) 
                                                OR 
                                                ( P.capitan = '$jugador2' OR P.jugador_2 = '$capitan ')
                                            )
                                    )
                        AND (CAT.genero = '$genero_camp' OR CAT.genero = 'Mixto')
                        ";
        //echo '<br>mismo genero - '.$sql;exit;
                if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                    $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{ //si la ejecución de la query no da error
                    return $resultado;
                }
            }
            else{  
                
                $sql = "SELECT 
                            CC.id, CAT.id AS categoria_id, CAT.nivel, CAT.genero 
                        FROM 
                            CATEGORIA_CAMPEONATO CC, CAMPEONATO CAM, CATEGORIA CAT  
                        WHERE 
                                CC.CAMPEONATO_id = '$campeonato_id'
                            AND CC.CAMPEONATO_id = CAM.id
                            AND CC.CATEGORIA_id = CAT.id
                            AND  CC.id NOT IN 
                                        ( SELECT 
                                            I.CATEGORIA_CAMPEONATO_id 
                                        FROM 
                                            INSCRIPCION I, PAREJA P 
                                        WHERE 
                                                I.PAREJA_ID = P.id
                                            AND (  ( P.capitan = '$capitan' OR P.jugador_2 = '$jugador2' ) 
                                                    OR 
                                                    ( P.capitan = '$jugador2' OR P.jugador_2 = '$capitan')
                                                )
                                        )
                            AND CAT.genero = 'Mixto'
                            ";
      //  echo '<br>distinto genero - '.$sql;exit;
        
                if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                    $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{ //si la ejecución de la query no da error
                    return $resultado;
                }
            }
        }
    }//fin Get_categorias_campeonato

    function Get_datos_categoria(){
        $id = $this->categoria->getId();

        $sql = "SELECT * FROM CATEGORIA WHERE id = '$id'";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            return $resultado;
        }
    }//fin Get_datos_categoria


}//fin CATEGORIA_Model
