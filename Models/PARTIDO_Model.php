<?php

class PARTIDO_Model
{

   
    var $mysqli;


    function __construct($partido)
    {

        $this->partido = $partido;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function AllData()
    {
        $sql = "SELECT  PA.id,
                        PA.fecha ,
                        PA.HORARIO_id AS horario,
                        H.hora_inicio AS 'Hora inicio', 
                        H.hora_fin AS 'Hora finalizacion', 
                        PA.inscritos AS 'Inscripciones'
                FROM 
                    PARTIDO PA, HORARIO H
                WHERE 
                        PA.HORARIO_id = H.id
                ORDER BY fecha DESC
                "; 

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


    function getData()
    {

        //diferenciar entre los partidos que tienen reserva y los que no la tienen
        $id = $this->partido->getId();
        $id_reserva = $this->partido->getId_reserva();

        //si el partido tiene reserva
        if($id_reserva != NULL){
           
            $sql = "SELECT  PA.id,
                            PA.fecha ,
                            PA.HORARIO_id AS horario,
                            R.fecha AS 'Fecha reserva', 
                            R.PISTA_nombre AS 'Nombre pista', 
                            H.hora_inicio AS 'Hora inicio', 
                            H.hora_fin AS 'Hora finalizacion', 
                            PA.inscritos AS 'Inscripciones'
                    FROM 
                        PARTIDO PA, HORARIO H, PISTA PI, RESERVA R 
                    WHERE 
                            PA.id = '$id'
                        AND PA.HORARIO_id = H.id
                        AND PA.RESERVA_id = R.id
                        AND R.HORARIO_id = H.id
                        AND R.PISTA_nombre = PI.nombre
                    ";
        }//si el partido no tiene reserva asociada
        else{

            $sql = "SELECT  PA.id,
                            PA.fecha ,
                            PA.HORARIO_id AS horario,
                            H.hora_inicio AS 'Hora inicio', 
                            H.hora_fin AS 'Hora finalizacion', 
                            PA.inscritos AS 'Inscripciones'
                        FROM 
                            PARTIDO PA, HORARIO H
                        WHERE 
                                PA.id = '$id'
                            AND PA.HORARIO_id = H.id
                        ";
        }

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            $result = $resultado->fetch_array();
            return $result;
        }
    }


    
    function Add(){
        $fecha = $this->partido->getFecha();
        if($fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $fecha);
            $format_fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }

        $id_horario = $this->partido->getId_horario();
        $usuario = $this->partido->getLogin_user();


        if (($fecha <> '') || ($id_horario <> '') ){ // si los atributos estan vacios
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM 
                                PARTIDO 
                             WHERE       
                                    (FECHA = '$format_fecha') 
                                AND (HORARIO_ID = '$id_horario')";

           // echo $sql;exit;
            if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }else { //si la ejecución de la query no da error

                $num_rows = mysqli_num_rows($resultado);
                if($num_rows == 0){
                    $sql = "INSERT INTO PARTIDO( id,  fecha,  inscritos,  HORARIO_id, RESERVA_id,  USUARIO_login) 
                                        VALUES( NULL, '$format_fecha', '0',  '$id_horario', NULL, '$usuario')";

                    if (!($resultado = $this->mysqli->query($sql))){ 
                        $this->respuesta["text"] = "No se ha podido registrar el partido";
                        $this->respuesta["type"] = false;
                        return $this->respuesta;

                    }else{
                        $this->respuesta["text"] = 'Insertado correctamente';
                        $this->respuesta["type"] = true;
                        return $this->respuesta;
                    }
                }
                else{
                    $this->respuesta["text"] = "Ya existe un partido con esos datos asociados";
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

    function delete()
    {
        $id = $this->partido->getId();

        $sql_reserva = "SELECT RESERVA_id FROM PARTIDO WHERE (id = '$id')";
       

        if(!$result_reserva = $this->mysqli->query($sql_reserva) ){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }else{

            $sql = "SELECT * FROM `PARTIDO` WHERE (id = '$id')";
            $resultado = $this->mysqli->query($sql);
           
            if ($resultado->num_rows == 1) {

                $sql2 = "DELETE FROM PARTIDO WHERE (id = '$id')";
                //echo($sql2); exit;

                if(!$resultado = $this->mysqli->query($sql2) ){
                    $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }else{
                    $row = mysqli_fetch_array($result_reserva);
                    if($row[0] <> NULL){
                        $this->respuesta['id_reserva'] = $row[0] ; 
                    }
                    
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

    }

    function ShowAll(){
        $sql = "SELECT P.id, P.fecha, PI.nombre, P.HORARIO_id, 
                        P.inscritos AS inscripciones, H.hora_inicio, H.hora_fin
                FROM 
                    PARTIDO P, HORARIO H, PISTA PI, RESERVA R
                WHERE      
                        H.id = P.HORARIO_id
                    AND H.id = R.HORARIO_id
                    AND R.id = P.RESERVA_id
                    AND PI.nombre = R.PISTA_nombre
                ORDER BY 
                    P.fecha DESC, H.hora_inicio, PI.nombre";

            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }

    function ShowAll_partidos_futuros(){
        $hora = date('H:i:s'); //hora de hoy
        $fecha = date('Y-m-d'); //fecha de hoy

        $sql = "SELECT 
                    P.id, P.fecha, P.HORARIO_id AS 'horario', H.hora_inicio AS 'hora inicio', H.hora_fin AS 'hora fin', P.inscritos AS 'incripciones'
                FROM 
                    PARTIDO P, HORARIO H
                WHERE 
                        P.HORARIO_id = H.id
                    AND (H.hora_inicio > '$hora' AND P.fecha = '$fecha') OR P.fecha > '$fecha'
                GROUP BY P.id
                ORDER BY P.fecha DESC, H.hora_inicio
                ";
      
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }

    function Show_futuros_partidos(){
        $hora = date('H:i:s'); //hora de hoy
        $fecha = date('Y-m-d'); //fecha de hoy

        $sql = "SELECT 
                    P.id, P.fecha, P.HORARIO_id AS 'horario', H.hora_inicio AS 'hora inicio', H.hora_fin AS 'hora fin', P.inscritos AS 'inscripciones'
                FROM 
                    PARTIDO P, HORARIO H
                WHERE 
                        P.HORARIO_id = H.id
                    AND P.inscritos < 4
                    AND (H.hora_inicio > '$hora' AND P.fecha = '$fecha') OR P.fecha > '$fecha'
                GROUP BY P.id
                ORDER BY P.fecha DESC, H.hora_inicio
                ";
        
        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }

    function Show_futuros_partidos_user($login){
        $hora = date('H:i:s');
        $fecha = date('Y-m-d');
            
        $sql = "SELECT * FROM USUARIO_PARTIDO WHERE USUARIO_login = '$login'";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado1 = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado

                $sql = "SELECT 
                    P.id AS partido_id, P.fecha, P.HORARIO_id AS 'horario', H.hora_inicio AS 'hora inicio', H.hora_fin AS 'hora fin', P.inscritos AS 'inscripciones'
                FROM 
                    PARTIDO P, HORARIO H
                WHERE 
                        P.HORARIO_id = H.id
                    AND P.inscritos < 4
                    AND (H.hora_inicio > '$hora' AND P.fecha = '$fecha') OR P.fecha > '$fecha'
                GROUP BY P.id
                ORDER BY P.fecha DESC, H.hora_inicio
                ";

                if (!($resultado2 = $this->mysqli->query($sql))){
                    $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{  //si se ejecuta la query
                    $listPartidos = NULL;
                    $listInscripcion = NULL;

                    if($resultado1 <> NULL){ //si hay tuplas
                        while($row = mysqli_fetch_array($resultado1)){
                            $listInscripcion[$row["PARTIDO_id"]] = "Inscrito";
                        }
                    }

                    if($resultado2 <> NULL) {
                        if($listInscripcion == NULL ){ //si no esta inscrito en ningun partido
                            while($row = mysqli_fetch_array($resultado2)){                                
                                $listPartidos[$row["partido_id"]] = array($row["fecha"],$row["hora inicio"],$row["hora fin"],$row["inscripciones"]);
                            }   
                        }else{ //si esta inscrito en algun partido
                             while($row = mysqli_fetch_array($resultado2)){
                                if( !array_key_exists($row["partido_id"],  $listInscripcion)){
                                    $listPartidos[$row["partido_id"]] = array($row["fecha"],$row["hora inicio"],$row["hora fin"],$row["inscripciones"]);
                                }
                            }//fin del while
                        }//fin del else
                    }
                    return $listPartidos;
                }//fin del else
            return NULL;
        }  
    }

    function ShowAll_incripciones(){
        $sql = "SELECT
                    P.id, 
                    UP.USUARIO_login AS 'login', 
                    P.fecha, 
                    P.HORARIO_id AS 'horario', 
                    H.hora_inicio AS 'hora inicio', 
                    H.hora_fin AS 'hora fin',
                    P.inscritos AS 'inscripciones'
                FROM 
                    PARTIDO P, HORARIO H, USUARIO_PARTIDO UP    
                WHERE
                        H.id = P.HORARIO_id
                    AND P.id = UP.PARTIDO_id
                GROUP BY P.id
                ORDER BY P.fecha desc, H.hora_inicio
                ";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }

    function Show_usuarios_inscripcion(){
        $id = $this->partido->getId();

        $sql = "SELECT
                    P.id as id_partido, U.login, U.nombre, U.apellidos, P.fecha, H.hora_inicio, H.hora_fin
                FROM
                    PARTIDO P, USUARIO U, ROL R, HORARIO H
                WHERE 
                        P.id = '$id'
                    AND P.HORARIO_id = H.id
                    AND U.ROL_id = R.id
                    AND R.nombre <> 'Administrador'
                    AND U.login NOT IN 
                                    (SELECT UP.USUARIO_login
                                        FROM USUARIO_PARTIDO UP
                                        WHERE U.login = UP.USUARIO_login AND UP.PARTIDO_id = '$id'
                                    )
                ";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        } 
    }

    function Show_inscritos(){
        $id = $this->partido->getId();

        $sql = "SELECT 
                    U.login, U.nombre, U.apellidos, P.fecha, H.hora_inicio, H.hora_fin, P.RESERVA_id AS 'reserva', P.id AS 'id_partido'
                FROM 
                    USUARIO_PARTIDO UP , USUARIO U, PARTIDO P, HORARIO H
                WHERE
                        H.id = P.HORARIO_id
                    AND UP.USUARIO_login = U.login  
                    AND UP.PARTIDO_id = P.id
                    AND UP.PARTIDO_id = '$id'
                ";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        } 
    }

    function Get_fecha(){
        $id = $this->partido->getId();

        $sql = "SELECT fecha FROM PARTIDO WHERE id = '$id'";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            $row = mysqli_fetch_array($resultado);
            return $row[0];
        }
    }

    function Get_id_horario(){
        $id = $this->partido->getId();

        $sql = "SELECT HORARIO_id FROM PARTIDO WHERE id = '$id'";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            $row = mysqli_fetch_array($resultado);
            return $row[0];
        }
    }

    function Update(){
        $id = $this->partido->getId();
        $id_reserva = $this->partido->getId_reserva();

        $sql = "UPDATE PARTIDO SET RESERVA_id = '$id_reserva' WHERE id = '$id' ";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return true;
        }
    }

    function Get_inscripciones_user($login){
        
        $sql = "SELECT  PA.id,
                        PA.fecha ,
                        PA.HORARIO_id AS horario,
                        H.hora_inicio AS 'Hora inicio', 
                        H.hora_fin AS 'Hora finalizacion', 
                        PA.inscritos AS 'Inscripciones'
                FROM 
                    PARTIDO PA, HORARIO H, USUARIO_PARTIDO UP
                WHERE 
                        PA.HORARIO_id = H.id
                    AND PA.id = UP.PARTIDO_id
                    AND UP.USUARIO_login = '$login'
                ORDER BY fecha DESC
                "; 

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
 
}
