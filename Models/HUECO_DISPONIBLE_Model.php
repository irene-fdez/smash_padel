<?php

class HUECO_DISPONIBLE_Model{

    var $hueco_disponible;
    var $mysqli;


    function __construct($hueco_disponible)
    {

        $this->hueco_disponible = $hueco_disponible;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function Add(){
        $enfrentamiento_id = $this->hueco_disponible->getId_enfrentamiento();
        $pareja_id = $this->hueco_disponible->getId_pareja();
        $horario_id = $this->hueco_disponible->getId_horario();
        $fecha = $this->hueco_disponible->getFecha();
        if($fecha <> NULL){   //cambio de formato de la fecha para adecuarlo al de la bd
            $aux = explode("/", $fecha);
            $format_fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }

        //Se comprueba si ese hueco ya ha sido propuesto
        $sql = "SELECT * FROM HUECO_DISPONIBLE 
                            WHERE 
                                    fecha = '$format_fecha'
                                AND ENFRENTAMIENTO_id = '$enfrentamiento_id'
                                AND PAREJA_id = '$pareja_id'
                                AND HORARIO_id = '$horario_id'
                        ";

        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            if($resultado->num_rows > 0){
                $this->respuesta["text"] = "Esa fecha con ese horario ya ha sido registrado para este enfrentamiento";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{
                
                $sql_ins = "INSERT INTO HUECO_DISPONIBLE(fecha, HORARIO_id, PAREJA_id, ENFRENTAMIENTO_id)
                                        VALUES('$format_fecha', '$horario_id', '$pareja_id', '$enfrentamiento_id')";
            
                if (!$resultado = $this->mysqli->query($sql_ins)){ 
                    $this->respuesta["text"] = "No se ha podido registrar la propuesta en la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{
                    $this->respuesta["text"] = "Propuesta registrada correctamente";
                    $this->respuesta["type"] = true;
                    return $this->respuesta;
                }
            }
        }
    }// fin Add

    function Delete_huecos_restantes(){
        $enfrentamiento_id = $this->hueco_disponible->getId_enfrentamiento();

        $sql = "SELECT * FROM HUECO_DISPONIBLE WHERE ENFRENTAMIENTO_id = '$enfrentamiento_id'";

        if (!$resultado = $this->mysqli->query($sql)){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{

            //para cada hueco restante se llama al delete para eliminarlo
            while ($row_del = mysqli_fetch_array($resultado)) {

                $this->hueco_disponible->setId($row_del['id']);
                $respuesta = $this->delete();
            }
            if($respuesta['type'] == true){
                $this->respuesta["text"] = 'Propuestas eliminadas correctamente';
                $this->respuesta["type"] = true;
                return $this->respuesta;
            }
        }
    }//fin Delete_huecos_restantes


    function delete(){
        $id = $this->hueco_disponible->getId();

        $sql = "SELECT * FROM HUECO_DISPONIBLE WHERE id = '$id'";

        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            if($resultado->num_rows == 1){
                $sql2 = "DELETE FROM HUECO_DISPONIBLE WHERE id = '$id'";

                if(!$resultado = $this->mysqli->query($sql2) ){
                    $this->respuesta["text"] = "No se ha podido eliminar la propuesta";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }else{
                    $this->respuesta["text"] = 'Propuesta eliminada correctamente';
                    $this->respuesta["type"] = true;
                    return $this->respuesta;
                }
            }
            else{
                $this->respuesta["text"] = 'No existe esa propuesta en la base de datos';
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
        }
    } //fin delete

    function Propuestas_huecos(){
        $enfrentamiento_id = $this->hueco_disponible->getId_enfrentamiento();
        $pareja_id = $this->hueco_disponible->getId_pareja();

        $sql = "SELECT 
                    HD.id AS 'hueco_id',
                    HD.fecha,
                    HD.HORARIO_id,
                    HD.PAREJA_id,
                    HD.ENFRENTAMIENTO_id,
                    H.*
                FROM 
                    HUECO_DISPONIBLE HD,
                    HORARIO H
                WHERE
                        HD.ENFRENTAMIENTO_id = '$enfrentamiento_id'
                    AND HD.PAREJA_id = '$pareja_id'
                    AND HD.HORARIO_id = H.id
                ";

        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    } //fin Propuestas_huecos

    function Aceptar_propuesta(){
        $enfrentamiento_id = $this->hueco_disponible->getId_enfrentamiento();
        $horario_id = $this->hueco_disponible->getId_horario();
        $fecha = $this->hueco_disponible->getFecha();
   
       
        $reservas = NULL;
        //Reservas para ese horario
        $sql_reserva = "SELECT * FROM 
                                RESERVA 
                            WHERE 
                                    HORARIO_id = '$horario_id' 
                                AND fecha = '$fecha'";

        if (!$result_reserva = $this->mysqli->query($sql_reserva)){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            if($result_reserva->num_rows > 0){
                while($row_reserva = mysqli_fetch_array($result_reserva)){
                    $reservas[$row_reserva['PISTA_nombre']] = array($row_reserva['id']);
                }    
            }
            else{
                $reservas['libre'] = NULL;
            }

            //Se recorren las pistas 
            $sql_pista = "SELECT * FROM PISTA";

            if (!$result_pista = $this->mysqli->query($sql_pista)){ 
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{ 
                $cont = 0;
                $pistas_disponibles = null;
                //Si la pista no está reservada se guarda en pistas_disponibles
                while($row_pista = mysqli_fetch_array($result_pista)){
                    if(!array_key_exists($row_pista['nombre'], $reservas)){
                        $pistas_disponibles[$cont] = $row_pista['nombre'];
                        $cont++;
                    }
                }

                if($pistas_disponibles[0] <> null){
                    $pista_nombre = $pistas_disponibles[0];
 
                    $fecha_expl = explode("-", $fecha);  
                    $fehca_format = $fecha_expl[2]."/".$fecha_expl[1]."/".$fecha_expl[0];

                    //se añade la reserva de la pista para la fecha/hora acordadas
                    $reserva_entity = new Reserva('', $fehca_format, 'admin', $horario_id, $pista_nombre);
 
                    $model_reserva = new RESERVA_Model($reserva_entity);
                    $respuesta_res = $model_reserva->Add();

                    if (!$respuesta_res["type"]){ 
                        $this->respuesta["text"] = $respuesta_res["text"];
                        $this->respuesta["type"] = $respuesta_res["type"];
                        return $this->respuesta;
                    }
                    else{ 
                        //Se obtiene el id de la reserva que se acaba de crear
                        $sql_reserva_id = "SELECT id FROM 
                                                    RESERVA 
                                                WHERE 
                                                        HORARIO_id = '$horario_id'
                                                    AND PISTA_nombre = '$pista_nombre'
                                                    AND fecha = '$fecha'
                                        ";       
                                        
                        if (!$result_reserva_id = $this->mysqli->query($sql_reserva_id)){ 
                            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                            $this->respuesta["type"] = false;
                            return $this->respuesta;
                        }
                        else{
                            $row_reserva_id = mysqli_fetch_array($result_reserva_id);
                            $reserva_id = $row_reserva_id[0];

                            //Se añade el id al enfrentamiento
                            include '../Models/ENFRENTAMIENTO_Model.php';
                            include '../Entities/Enfrentamiento.php';
                            $model_enfrent = new ENFRENTAMIENTO_Model( new Enfrentamiento($enfrentamiento_id,'','','','', $reserva_id) );
                            $respuesta_update = $model_enfrent->Update_reserva_enfrentamiento();

                            if (!$respuesta_update["type"]){ 
                                $this->respuesta["text"] = $respuesta_res["text"];
                                $this->respuesta["type"] = $respuesta_res["type"];
                                return $this->respuesta;
                            }
                            else{ 
                                //Se eliminan los huecos propuestas restantes relacionados con el enfrentamiento
                                $respuesta_delete = $this->Delete_huecos_restantes();

                                if (!$respuesta_delete["type"]){ 
                                    $this->respuesta["text"] = $respuesta_delete["text"];
                                    $this->respuesta["type"] = $respuesta_delete["type"];
                                    return $this->respuesta;
                                }
                                else{ 
                                    $this->respuesta["text"] = "Reserva realizada correctamente";
                                    $this->respuesta["type"] = true;
                                    return $this->respuesta;
                                }
                            }//fin else resultado consulta update de reserva
                        }//fin else consulta $sql_reserva2
                    }//fin else resultado consulta ADD de reserva
                }
                else{
                    $this->respuesta["text"] = "No hay pistas disponibles para ese horario";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }               
            } //fin else consulta $sql_pista
        }//fin else consulta $sql_reserva

    }//fin Aceptar_propuesta


    function Get_ofertas_huecos(){
        $enfrentamiento_id = $this->hueco_disponible->getId_enfrentamiento();
        $pareja_id = $this->hueco_disponible->getId_pareja();

        $sql = "SELECT 
                    HD.id AS 'hueco_id',
                    HD.fecha,
                    HD.HORARIO_id,
                    HD.PAREJA_id,
                    HD.ENFRENTAMIENTO_id,
                    H.id AS 'horario_id',
                    H.hora_inicio,
                    H.hora_fin,
                    P.capitan,
                    P.jugador_2,
                    C.nombre AS nombre_campeonato
                FROM 
                    HUECO_DISPONIBLE HD,
                    HORARIO H,
                    ENFRENTAMIENTO E,
                    PAREJA P,
                    GRUPO G,
                    CAMPEONATO C
                WHERE
                        HD.ENFRENTAMIENTO_id = '$enfrentamiento_id'
                    AND HD.PAREJA_id <> '$pareja_id'
                    AND HD.HORARIO_id = H.id
                    AND HD.ENFRENTAMIENTO_id = E.id
                    AND HD.PAREJA_id = P.id
                    AND E.GRUPO_id = G.id
                    AND G.CAMPEONATO_id = C.id
                ";

        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }//fin Get_ofertas_huecos

    function Get_datos_adicinales_ofertas_huecos(){
        $enfrentamiento_id = $this->hueco_disponible->getId_enfrentamiento();
        $pareja_id = $this->hueco_disponible->getId_pareja();

        $sql = "SELECT 
                    HD.id AS 'hueco_id',
                    HD.fecha,
                    HD.HORARIO_id,
                    HD.PAREJA_id,
                    HD.ENFRENTAMIENTO_id,
                    H.id AS 'horario_id',
                    H.hora_inicio,
                    H.hora_fin,
                    P.capitan,
                    P.jugador_2,
                    C.nombre AS nombre_campeonato
                FROM 
                    HUECO_DISPONIBLE HD,
                    HORARIO H,
                    ENFRENTAMIENTO E,
                    PAREJA P,
                    GRUPO G,
                    CAMPEONATO C
                WHERE
                        HD.ENFRENTAMIENTO_id = '$enfrentamiento_id'
                    AND HD.PAREJA_id <> '$pareja_id'
                    AND HD.HORARIO_id = H.id
                    AND HD.ENFRENTAMIENTO_id = E.id
                    AND HD.PAREJA_id = P.id
                    AND E.GRUPO_id = G.id
                    AND G.CAMPEONATO_id = C.id
                GROUP BY P.id
                ";

        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }//fin Get_datos_adicinales_ofertas_huecos

    function Get_tus_ofertas_propuestas(){

        $enfrentamiento_id = $this->hueco_disponible->getId_enfrentamiento();
        $pareja_id = $this->hueco_disponible->getId_pareja();

        $sql = "SELECT 
                    HD.fecha,
                    HD.id AS 'hueco_id',
                    CAMP.id AS 'campeonato_id',
                    CAMP.nombre as 'campeonato_nombre',
                    CAT.genero,
                    CAT.nivel,
                    E.id AS 'enfrentamiento_id',
                    H.hora_inicio,
                    H.hora_fin,
                    G.nombre AS 'grupo_nombre',
                    E.PAREJA_1 AS pareja_id,
                    E.PAREJA_2 AS id_pareja2,
                    P.capitan AS capitan_oponente
                    
                FROM
                    CAMPEONATO CAMP,
                    CATEGORIA CAT,
                    GRUPO G,
                    ENFRENTAMIENTO E,
                    HORARIO H,
                    HUECO_DISPONIBLE HD,
                    PAREJA P

                WHERE 
                        HD.HORARIO_id = H.id
                    AND HD.ENFRENTAMIENTO_id = E.id
                    AND E.GRUPO_id = G.id
                    AND G.CAMPEONATO_id = CAMP.id
                    AND G.CATEGORIA_id = CAT.id
                    AND E.PAREJA_1 = P.id
                    AND E.id = '$enfrentamiento_id'
                ORDER BY HD.fecha
        ";
 
        if (!$resultado = $this->mysqli->query($sql)){ 
        $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
        $this->respuesta["type"] = false;
        return $this->respuesta;
        }
        else{ 
        return $resultado;
        }
     }//fin Get_tus_ofertas_propuestas


     function Get_datos_adicionales_tus_ofertas_propuestas(){

        $enfrentamiento_id = $this->hueco_disponible->getId_enfrentamiento();
        $pareja_id = $this->hueco_disponible->getId_pareja();

        $sql_pareja = "SELECT PAREJA_1, PAREJA_2 FROM ENFRENTAMIENTO WHERE id = '$enfrentamiento_id'";

        if (!$resultado_pareja = $this->mysqli->query($sql_pareja)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
            }
            else{ 
                $row = mysqli_fetch_array($resultado_pareja);
                $id_p1 = $row[0];
                $id_p2 = $row[1];

                $sql = "SELECT 
                            HD.fecha,
                            HD.id AS 'hueco_id',
                            CAMP.id AS 'campeonato_id',
                            CAMP.nombre as 'campeonato_nombre',
                            CAT.genero,
                            CAT.nivel,
                            E.id AS 'enfrentamiento_id',
                            H.hora_inicio,
                            H.hora_fin,
                            G.nombre AS 'grupo_nombre',
                            E.PAREJA_1 AS id_pareja1,
                            E.PAREJA_2 AS id_pareja2,
                            (SELECT P.capitan FROM PAREJA P, ENFRENTAMIENTO E WHERE P.id = E.PAREJA_1 AND E.id = '$enfrentamiento_id') AS 'capitan_p1',
                            (SELECT P.capitan FROM PAREJA P, ENFRENTAMIENTO E  WHERE P.id = E.PAREJA_2 AND E.id = '$enfrentamiento_id') AS 'capitan_p2'
                        FROM
                            CAMPEONATO CAMP,
                            CATEGORIA CAT,
                            GRUPO G,
                            ENFRENTAMIENTO E,
                            HORARIO H,
                            HUECO_DISPONIBLE HD,
                            PAREJA P
                        WHERE
                                HD.ENFRENTAMIENTO_id = '$enfrentamiento_id'
                            AND ( HD.PAREJA_id = '$id_p1' OR  HD.PAREJA_id = '$id_p2')
                            AND HD.HORARIO_id = H.id
                            AND HD.ENFRENTAMIENTO_id = E.id
                            AND HD.PAREJA_id = P.id
                            AND E.GRUPO_id = G.id
                            AND G.CAMPEONATO_id = CAMP.id
                        GROUP BY P.id
                        ";
       
                if (!$resultado = $this->mysqli->query($sql)){ 
                    $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{ 
                    return $resultado;
                }
            }
     }//fin Get_datos_adicionales_tus_ofertas_propuestas





}// fin HUECO_DISPONIBLE_Model
