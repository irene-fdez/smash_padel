<?php

class ENFRENTAMIENTO_Model
{

    var $enfrentamiento;
    var $mysqli;

    function __construct($enfrentamiento)
    {
        $this->enfrentamiento = $enfrentamiento;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();
    }

    //Funcion para añadir enfrentamientos
    function ADD(){
        
        $pareja_1 = $this->enfrentamiento->getPareja_1();
        $pareja_2 = $this->enfrentamiento->getPareja_2();
        $grupo_id = $this->enfrentamiento->getId_grupo();

        //Comprobamos que no se ha creado el enfrentamiento previamente
        $sql_cmp = "SELECT * FROM 
                                    ENFRENTAMIENTO 
                            WHERE
                                    PAREJA_1 = '$pareja_1'  
                                AND PAREJA_2 = '$pareja_2'
                        ";

        if (!$resultado = $this->mysqli->query($sql_cmp)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            
            if($resultado->num_rows > 0){
                $this->respuesta["text"] = "Este enfrentamiento ya ha sido registrado";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{
                
                $sql_ins = "INSERT INTO ENFRENTAMIENTO (GRUPO_id, PAREJA_1, PAREJA_2) 
                                                VALUES($grupo_id, $pareja_1, $pareja_2)";
               
                if (!$resultado = $this->mysqli->query($sql_ins)){
                    $this->respuesta["text"] = "No ha sido posible registrar el enfrentamiento";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{
                    $this->respuesta["text"] = "Enfrentamiento registrado correctamente";
                    $this->respuesta["type"] = true;
                    return $this->respuesta;
                }
            }
        }
    } //fin ADD


    //Funcion para obtener las propuestas de horarios que tiene un usuario para los enfrentamientos en los que está incrito como pareja 1
    function Show_ofertas_pareja1($login){

        //Se buscan todos los enfrentamientos de una pareja como pareja1
        $sql = "SELECT 
                    HD.id AS 'hueco_id',
                    CAMP.id AS 'campeonato_id',
                    CAMP.nombre as 'campeonato_nombre',
                    CAT.genero,
                    CAT.nivel,
                    E.id AS 'enfrentamiento_id',
                    HD.fecha,
                    H.hora_inicio,
                    H.hora_fin,
                    (SELECT capitan FROM ENFRENTAMIENTO E, PAREJA P WHERE E.PAREJA_1 = P.id AND capitan = '$login' GROUP BY capitan) AS 'capitan pareja 1',
                    G.nombre AS grupo_nombre,
                    E.PAREJA_1 AS pareja_id,
                    E.PAREJA_2 AS id_pareja2,
                    P.capitan AS capitan
                FROM 
                    ENFRENTAMIENTO E,
                    HUECO_DISPONIBLE HD,
                    HORARIO H,
                    PAREJA P,
                    GRUPO G,
                    CATEGORIA CAT,
                    CAMPEONATO CAMP
                WHERE 
                        E.id = HD.ENFRENTAMIENTO_id
                    AND HD.HORARIO_id = H.id
                    AND E.GRUPO_id = G.id
                    AND G.CAMPEONATO_id = CAMP.id
                    AND G.CATEGORIA_id = CAT.id
                    AND E.PAREJA_2 = P.id
                    AND E.PAREJA_1 IN (SELECT id FROM PAREJA WHERE capitan = '$login')
                    AND HD.PAREJA_id = E.PAREJA_2
                GROUP BY E.PAREJA_2
                ";


        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }//fin Show_ofertas_pareja1


    //Funcion para obtener las propuestas de horarios que tiene un usuario para los enfrentamientos en los que está incrito como pareja 2
    function Show_ofertas_pareja2($login){
        //Se buscan todos los enfrentamientos de una pareja como pareja1
        $sql = "SELECT 
                    HD.id AS 'hueco_id',
                    CAMP.id AS 'campeonato_id',
                    CAMP.nombre as 'campeonato_nombre',
                    CAT.genero,
                    CAT.nivel,
                    E.id AS 'enfrentamiento_id',
                    HD.fecha,
                    H.hora_inicio,
                    H.hora_fin,
                    (SELECT capitan FROM ENFRENTAMIENTO E, PAREJA P WHERE E.PAREJA_2 = P.id AND capitan = '$login' GROUP BY capitan) AS 'capitan pareja 2',
                    G.nombre AS grupo_nombre,
                    E.PAREJA_2 AS pareja_id,
                    E.PAREJA_1 AS id_pareja1,
                    P.capitan AS capitan
                FROM 
                    ENFRENTAMIENTO E,
                    HUECO_DISPONIBLE HD,
                    HORARIO H,
                    PAREJA P,
                    GRUPO G,
                    CATEGORIA CAT,
                    CAMPEONATO CAMP
                WHERE 
                        E.id = HD.ENFRENTAMIENTO_id
                    AND HD.HORARIO_id = H.id
                    AND E.GRUPO_id = G.id
                    AND G.CAMPEONATO_id = CAMP.id
                    AND G.CATEGORIA_id = CAT.id
                    AND E.PAREJA_1 = P.id
                    AND E.PAREJA_2 IN (SELECT id FROM PAREJA WHERE capitan = '$login')
                    AND HD.PAREJA_id = E.PAREJA_1
                GROUP BY E.PAREJA_1
                ";


        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }//fin Show_ofertas_pareja2


    //Funcion para obtener las ofertas que ha propuesto un usuario como capitan (pareja1)
    function Show_ofertas_propuestas_pareja1($login){
       
        //Se buscan todos los enfrentamientos de una pareja como pareja1
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
                    (SELECT capitan FROM ENFRENTAMIENTO E, PAREJA P WHERE E.PAREJA_1 = P.id AND capitan = '$login' GROUP BY capitan) AS 'capitan pareja 1',
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
                    AND E.PAREJA_2 = P.id
                    AND E.PAREJA_1 IN (SELECT id FROM PAREJA WHERE capitan = '$login')
                    AND E.id IN (SELECT ENFRENTAMIENTO_id
                                    FROM HUECO_DISPONIBLE
                                    WHERE PAREJA_id IN (SELECT id FROM PAREJA WHERE capitan = '$login'))
                GROUP BY E.id,  P.id
                ";

        if (!$resultado = $this->mysqli->query($sql)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }// fin Show_ofertas_propuestas_pareja1


    //Funcion para obtener las ofertas que ha propuesto un usuario como capitan (pareja2)
    function Show_ofertas_propuestas_pareja2($login){
       //Se buscan todos los enfrentamientos de una pareja como pareja2
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
                    (SELECT capitan FROM ENFRENTAMIENTO E, PAREJA P WHERE E.PAREJA_2 = P.id AND capitan = '$login' GROUP BY capitan) AS 'capitan pareja 1',
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
                    AND E.PAREJA_2 IN (SELECT id FROM PAREJA WHERE capitan = '$login')
                    AND E.id IN (SELECT ENFRENTAMIENTO_id
                                    FROM HUECO_DISPONIBLE
                                    WHERE PAREJA_id IN (SELECT id FROM PAREJA WHERE capitan = '$login'))
                GROUP BY E.id, P.id
                ";

                if (!$resultado = $this->mysqli->query($sql)){ 
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
                }
                else{ 
                return $resultado;
                }
    }//fin Show_ofertas_propuestas_pareja2


    //Funcion para obtener los enfrentamientos en los que no ha sido propuesto ningún horario
    function Show_enfrent_sin_oferta_pareja1($login){
        
        $sql_enf = "SELECT  
                    CAMP.NOMBRE AS campeonato_nombre,
                    CAT.nivel,
                    CAT.genero,
                    G.nombre AS grupo_nombre,
                    P.capitan,
                    E.id AS enfrentamiento_id,
                    E.PAREJA_1 AS pareja_id
                FROM 
                    ENFRENTAMIENTO E,
                    PAREJA P,
                    GRUPO G,
                    CATEGORIA CAT,
                    CAMPEONATO CAMP
                WHERE 
                        E.GRUPO_id = G.id
                    AND G.CAMPEONATO_id = CAMP.id
                    AND G.CATEGORIA_id = CAT.id
                    AND E.PAREJA_2 = P.id
                    AND E.PAREJA_1 IN (SELECT id FROM PAREJA WHERE capitan = '$login')
                    AND E.id NOT IN (SELECT ENFRENTAMIENTO_id
                                    FROM HUECO_DISPONIBLE)
                    AND E.RESERVA_id IS NULL
                ";

        if (!$resultado = $this->mysqli->query($sql_enf)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }//fin Show_enfrent_sin_oferta_pareja1


    //Funcion para obtener los enfrentamientos en los que no ha sido propuesto ningún horario
    function Show_enfrent_sin_oferta_pareja2($login){

        //Se buscan todos los enfrentamientos de una pareja como pareja2
        $sql_enf = "SELECT  
                        CAMP.NOMBRE AS campeonato_nombre,
                        CAT.nivel,
                        CAT.genero,
                        G.nombre AS grupo_nombre,
                        P.capitan,
                        E.id AS enfrentamiento_id,
                        E.PAREJA_2 AS pareja_id
                    FROM 
                        ENFRENTAMIENTO E,
                        PAREJA P,
                        GRUPO G,
                        CATEGORIA CAT,
                        CAMPEONATO CAMP
                    WHERE 
                            E.GRUPO_id = G.id
                        AND G.CAMPEONATO_id = CAMP.id
                        AND G.CATEGORIA_id = CAT.id
                        AND E.PAREJA_1 = P.id
                        AND E.PAREJA_2 IN (SELECT id FROM PAREJA WHERE capitan = '$login')
                        AND E.id NOT IN (SELECT ENFRENTAMIENTO_id
                                        FROM HUECO_DISPONIBLE)
                        AND E.RESERVA_id IS NULL
                    ";

        if (!$resultado = $this->mysqli->query($sql_enf)){ 
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }//fin Show_enfrent_sin_oferta_pareja2


    function Show_enfrent_grupo(){
        $grupo_id = $this->enfrentamiento->getId_grupo();

        $sql = "SELECT DISTINCT 
                        CAMP.nombre AS campeonato_nombre,
                        CAT.nivel,
                        CAT.genero,
                        G.nombre AS grupo_nombre,
                        E.id AS enfrentamiento_id,
                        E.PAREJA_1 AS pareja1_id,
                        E.PAREJA_2 AS pareja2_id,
                        E.resultado,
                        (SELECT capitan FROM PAREJA WHERE E.PAREJA_1 = id) AS capitan_p1,
                        (SELECT jugador_2 FROM PAREJA WHERE E.PAREJA_1 = id) AS jugador2_p1,
                        (SELECT capitan FROM PAREJA WHERE E.PAREJA_2 = id) AS capitan_p2,
                        (SELECT jugador_2 FROM PAREJA WHERE E.PAREJA_2 = id) AS jugador2_p2
                    FROM
                        ENFRENTAMIENTO E,
                        GRUPO G,
                        CATEGORIA CAT,
                        CAMPEONATO CAMP
                    WHERE
                            E.GRUPO_id = G.id
                        AND G.CAMPEONATO_id = CAMP.id
                        AND G.CATEGORIA_id = CAT.id
                        AND G.id = '$grupo_id'
                    ORDER BY 1, 2, 3, 4 
                ";

                
        if (!$resultado = $this->mysqli->query($sql)){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{
            return $resultado;
        }
    }//fin Show_enfrent_grupo

    function Show_enfrent_grupo_fin(){
        $grupo_id = $this->enfrentamiento->getId_grupo();
        $hoy = date('Y-m-d');
        $hora_actual = date("H:i");

        $sql = "SELECT DISTINCT 
                        CAMP.nombre AS campeonato_nombre,
                        CAT.id AS categoria_id,
                        CAT.nivel,
                        CAT.genero,
                        G.id AS grupo_id,
                        G.nombre AS grupo_nombre,
                        E.id AS enfrentamiento_id,
                        E.PAREJA_1 AS pareja1_id,
                        E.PAREJA_2 AS pareja2_id,
                        R.fecha,
                        H.hora_inicio,
                        H.hora_fin,
                        P.nombre AS pista_nombre,
                        E.resultado,
                        (SELECT capitan FROM PAREJA WHERE E.PAREJA_1 = id) AS capitan_p1,
                        (SELECT jugador_2 FROM PAREJA WHERE E.PAREJA_1 = id) AS jugador2_p1,
                        (SELECT capitan FROM PAREJA WHERE E.PAREJA_2 = id) AS capitan_p2,
                        (SELECT jugador_2 FROM PAREJA WHERE E.PAREJA_2 = id) AS jugador2_p2
                    FROM
                        ENFRENTAMIENTO E,
                        GRUPO G,
                        CATEGORIA CAT,
                        CAMPEONATO CAMP,
                        RESERVA R,
                        HORARIO H,
                        PISTA P
                    WHERE
                            E.GRUPO_id = G.id
                        AND G.CAMPEONATO_id = CAMP.id
                        AND G.CATEGORIA_id = CAT.id
                        AND E.RESERVA_id = R.id
                        AND R.HORARIO_id = H.id
                        AND (R.fecha < '$hoy' OR ( R.fecha <= '$hoy' AND H.hora_fin < '$hora_actual'))
                        AND R.PISTA_nombre = P.nombre
                        AND G.id = '$grupo_id'
                    ORDER BY 1, 2, 3, 4 
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

    //Funcion para obtener los enfrntamientos de un campeonato
    function Show_enfrent_camp($campeonato_id){
        $hoy = date('Y-m-d');

        $sql = "SELECT  
                    CAMP.nombre AS nombre_campeonato,
                    CAT.nivel,
                    CAT.genero,
                    G.nombre AS nombre_grupo,
                    E.id AS enfrentamiento_id,
                    E.PAREJA_1 AS pareja1_id,
                    E.PAREJA_2 AS pareja2_id,
                    R.fecha,
                    H.hora_inicio,
                    H.hora_fin,
                    P.nombre AS nombre_pista,
                    E.resultado
                FROM
                    ENFRENTAMIENTO E,
                    GRUPO G,
                    CATEGORIA CAT,
                    CAMPEONATO CAMP,
                    RESERVA R,
                    HORARIO H,
                    PISTA P
                WHERE
                        E.GRUPO_id = G.id
                    AND G.CAMPEONATO_id = CAMP.id
                    AND G.CATEGORIA_id = CAT.id
                    AND E.RESERVA_id = R.id
                    AND R.fecha <= '$hoy'
                    AND R.HORARIO_id = H.id
                    AND R.PISTA_nombre = P.nombre
                    AND CAMP.id = '$campeonato_id'
                ORDER BY 1, 2, 3, 4 
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

    function Update_reserva_enfrentamiento(){
        $id = $this->enfrentamiento->getId();
        $reserva_id = $this->enfrentamiento->getId_reserva();

        $sql = "UPDATE ENFRENTAMIENTO SET 
                                        RESERVA_id = '$reserva_id'
                                    WHERE 
                                        id = '$id'";

        if (!$resultado = $this->mysqli->query($sql)){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{
            $this->respuesta["text"] = "Reserva de enfrentamiento registrada correctamente";
            $this->respuesta["type"] = true;
            return $this->respuesta;
        }
    }//fin Update_reserva_enfrentamiento

    function Get_datos_enfrentamiento(){
        $id = $this->enfrentamiento->getId();
        $grupo_id = $this->enfrentamiento->getId_grupo();

        $sql = "SELECT  
                    CAMP.id AS campeonato_id,
                    CAMP.nombre AS nombre_campeonato,
                    CAT.id AS categoria_id,
                    CAT.nivel,
                    CAT.genero,
                    G.id AS grupo_id,
                    G.nombre AS nombre_grupo,
                    E.id AS enfrentamiento_id,
                    E.PAREJA_1 AS pareja1_id,
                    E.PAREJA_2 AS pareja2_id,
                    R.fecha,
                    H.hora_inicio,
                    H.hora_fin,
                    P.nombre AS nombre_pista,
                    E.resultado,
                    (SELECT capitan FROM PAREJA WHERE E.PAREJA_1 = id) AS capitan_p1,
                    (SELECT jugador_2 FROM PAREJA WHERE E.PAREJA_1 = id) AS jugador2_p1,
                    (SELECT capitan FROM PAREJA WHERE E.PAREJA_2 = id) AS capitan_p2,
                    (SELECT jugador_2 FROM PAREJA WHERE E.PAREJA_2 = id) AS jugador2_p2
                FROM
                    ENFRENTAMIENTO E,
                    GRUPO G,
                    CATEGORIA CAT,
                    CAMPEONATO CAMP,
                    RESERVA R,
                    HORARIO H,
                    PISTA P
                WHERE
                        E.GRUPO_id = G.id
                    AND G.CAMPEONATO_id = CAMP.id
                    AND G.CATEGORIA_id = CAT.id
                    AND E.RESERVA_id = R.id
                    AND R.HORARIO_id = H.id
                    AND R.PISTA_nombre = P.nombre
                    AND E.id = '$id'
                ";

        if (!$resultado = $this->mysqli->query($sql)){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{
            return $resultado;
        }
    }//fin Get_datos_enfrentamiento


    function Update_resultado(){
        $id_enfrentamiento = $this->enfrentamiento->getId();
        $resultado = $this->enfrentamiento->getResultado();

        $sql = "UPDATE ENFRENTAMIENTO SET 
                                        resultado = '$resultado'
                                    WHERE
                                        id = '$id_enfrentamiento'
                                        
                ";
        if (!$resultado = $this->mysqli->query($sql)){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{
            $this->respuesta["text"] = "Resultado actualizado correctamente";
            $this->respuesta["type"] = true;
            return $this->respuesta;
        }
    }//fin Update_resultado



}//fin ENFRENTAMIENTO_Model
