<?php

class CLASIFICACION_Model
{
   
    var $mysqli;

    function __construct($clasificacion)
    {

        $this->clasificacion = $clasificacion;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function Add(){
        $pareja_id = $this->clasificacion->getId_pareja();
        $grupo_id = $this->clasificacion->getId_grupo();

        $sql = "INSERT INTO CLASIFICACION( puntos, PAREJA_id, GRUPO_id) 
                            VALUES(0, $pareja_id, $grupo_id)";


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
    }//fin Add


    function Update_clasificacion($enfrentamiento_id, $resultado){
        $sets=explode(", ", $resultado);
        $set_1=$sets[0];
        $set_2=$sets[1];
        $set_3=$sets[2];

        $set_1=explode('-', $set_1);
        $p1_set1 = $set_1[0];
        $p2_set1 = $set_1[1];

        $set_2=explode('-', $set_2);
        $p1_set2 = $set_2[0];
        $p2_set2 = $set_2[1];

        $set_3=explode('-', $set_3);
        if($set_3[0] == '') $p1_set3 = 0;
        else $p1_set3 = $set_3[0];

        if($set_3[0] == '') $p2_set3 = 0;
        else $p2_set3 = $set_3[1];


        $ganador_set1 = $this->Ganador_set($p1_set1, $p2_set1);
        $ganador_set2 = $this->Ganador_set($p1_set2, $p2_set2);
        $ganador_set3 = $this->Ganador_set($p1_set3, $p2_set3);
        $ganador_partido = $this->Ganador_partido($ganador_set1,$ganador_set2,$ganador_set3);

        $puntos_p1 = 0;
        $puntos_p2 = 0;

        $sql_enfrenta = "SELECT * FROM ENFRENTAMIENTO WHERE id = '$enfrentamiento_id'";

        if (!$result_enfrenta = $this->mysqli->query($sql_enfrenta)){   
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            $row_enf = $result_enfrenta->fetch_array();
            $pareja_1 = $row_enf['PAREJA_1'];
            $pareja_2 = $row_enf['PAREJA_2'];
            $grupo_id = $row_enf['GRUPO_id'];

            //Se obtiene la puntuacion actual de ambas parejas
            $sql_puntos_p1 = "SELECT puntos FROM 
                                                CLASIFICACION 
                                            WHERE 
                                                    PAREJA_id = '$pareja_1' 
                                                AND GRUPO_id = '$grupo_id'
                                            ";

            if (!$result_puntos_p1 = $this->mysqli->query($sql_puntos_p1)){ 
                $this->respuesta["text"] = "No se han podido obtener los puntos de la pareja 1";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{ 

                $sql_puntos_p2 = "SELECT puntos FROM 
                                                CLASIFICACION 
                                            WHERE 
                                                    PAREJA_id = '$pareja_2' 
                                                AND GRUPO_id = '$grupo_id'
                                            ";

                if (!$result_puntos_p2 = $this->mysqli->query($sql_puntos_p2)){ 
                    $this->respuesta["text"] = "No se han podido obtener los puntos de la pareja 2";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{ 
                    $row_p1 = mysqli_fetch_array($result_puntos_p1);
                    $puntos_p1 = $row_p1[0];

                    $row_enf2 = mysqli_fetch_array($result_puntos_p2);
                    $puntos_p2 = $row_enf2[0];

            
                    if($ganador_partido == 1){
                        $puntos_p1 = $puntos_p1 + 3;
                        $puntos_p2 = $puntos_p2 + 1;   
                    }
            
                    if($ganador_partido == 2){         
                        $puntos_p1 = $puntos_p1 + 1;
                        $puntos_p2 = $puntos_p2 + 3;   
                    }
            
                    if($ganador_partido == 0){}
                   
                    //Se actualizan la clasificacion con las puntuaciones de ambas parejas
                    $sql_update_p1 = "UPDATE CLASIFICACION
                                        SET puntos = '$puntos_p1'
                                        WHERE
                                                PAREJA_id = '$pareja_1'
                                            AND GRUPO_id = '$grupo_id'
                                    ";

                    if (!$result_update_p1 = $this->mysqli->query($sql_update_p1)){ 
                        $this->respuesta["text"] = "No se han podido actualizar los puntos de la pareja 1";
                        $this->respuesta["type"] = false;
                        return $this->respuesta;
                    }
                    else{ 

                        $sql_update_p2 = "UPDATE CLASIFICACION
                                        SET puntos = '$puntos_p2'
                                        WHERE
                                                PAREJA_id = '$pareja_2'
                                            AND GRUPO_id = '$grupo_id'
                                    ";

                        if (!$result_update_p2 = $this->mysqli->query($sql_update_p2)){ 
                            $this->respuesta["text"] = "No se han podido actualizar los puntos de la pareja 2";
                            $this->respuesta["type"] = false;
                            return $this->respuesta;
                        }
                        else{ 
                            $this->respuesta["text"] = "Clasificación actualizada correctamente";
                            $this->respuesta["type"] = true;
                            return $this->respuesta;
                        }//fin update_puntos_p2
                    }//fin update_puntos_p1
                }//consulta puntos_p2
            }//consulta puntos_p1
        }//consulta enfrentamiento

    }//fin Update_clasificacion


    function Ganador_set($set_p1, $set_p2){
        if( ($set_p1 >= 6) || ($set_p2 >= 6) ) {

            if($set_p1 > $set_p2) return 1; 
            if($set_p1 < $set_p2) return 2; 
            return 0;
        }
        else return 0; 

    }//fin Ganador_set

    function Ganador_partido($set_1, $set_2, $set_3){
        $cont_p1 = 0;
        $cont_p2 = 0;

        if($set_1 == 1) $cont_p1 = $cont_p1 + 1;
        if($set_1 == 2) $cont_p2 = $cont_p2 + 1;

        if($set_2 == 1) $cont_p1 = $cont_p1 + 1;
        if($set_2 == 2) $cont_p2 = $cont_p2 + 1;

        if($set_3 == 1) $cont_p1 = $cont_p1 + 1;
        if($set_3 == 2) $cont_p2 = $cont_p2 + 1;

        if($cont_p1 > $cont_p2) return 1; 
        if($cont_p1 < $cont_p2) return 2;
        
        return 0;
    }//fin Ganador_partido


    function Get_camp_cat_grupo($campeonato_id, $categoria_id){
        $grupo_id = $this->clasificacion->getId_grupo();

        $sql = "SELECT  
                        G.nombre AS nombre_grupo,
                        CAMP.nombre AS nombre_campeonato,
                        CAT.nivel, 
                        CAT.genero,
                        G.id AS GRUPO_id
                    FROM    
                        GRUPO G,
                        CATEGORIA_CAMPEONATO CC,
                        CAMPEONATO CAMP,
                        CATEGORIA CAT
                    WHERE   
                            G.CAMPEONATO_id = CC.CAMPEONATO_id
                        AND G.CATEGORIA_id = CC.CATEGORIA_id
                        AND CAMP.id = CC.CAMPEONATO_id
                        AND CAT.id = CC.CATEGORIA_id
                        AND G.CAMPEONATO_id = CAMP.id
                        AND G.CATEGORIA_id = CAT.id
                        AND CAMP.id = '$campeonato_id'
                        AND CAT.id = '$categoria_id'
                        AND G.id = '$grupo_id'
                    ";
        
        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else{
            if ($resultado->num_rows == 0) return 0;
            else return $resultado;
        }
    }//fin Get_camp_cat_grupo


    function Get_clasificaciones_camp($campeonato_id, $categoria_id){

        $grupo_id = $this->clasificacion->getId_grupo();

        $sql = "SELECT 
                        C.puntos,
                        P.capitan,
                        P.jugador_2
                    FROM
                        CLASIFICACION C,
                        PAREJA P,
                        GRUPO G
                    WHERE
                            C.PAREJA_id = P.id
                        AND G.id = C.GRUPO_id
                        AND C.GRUPO_id = '$grupo_id'
                        AND G.CAMPEONATO_id = '$campeonato_id'
                        AND G.CATEGORIA_id = '$categoria_id'
                    GROUP BY P.id
                    ORDER BY C.puntos DESC";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else return $resultado;
    }//fin Get_clasificaciones_camp

    function Get_grupos_clasificacion($campeonato_id){
        $sql = "SELECT * FROM GRUPO WHERE CAMPEONATO_id = '$campeonato_id'";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else return $resultado;
    }//fin Get_grupos_clasificacion


}
