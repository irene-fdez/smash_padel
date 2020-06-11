<?php

class RESERVA_Model
{
    var $reserva;
    var $mysqli;

    function __construct($reserva)
    {
        $this->reserva = $reserva;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

        
    }

    function Reserva_franja($horario){
        $_SESSION["reserva"] = 1;
        $i = 0;
        for($i = 0; $i<10; $i++){
            $fecha_actual = date("d/m/Y",strtotime("+".$i." day"));

            $fecha = $this->reserva->setFecha($fecha_actual);
            $horario_id = $this->reserva->setId_horario($horario);
            $login_user = $this->reserva->setLogin_user('admin');
            $this->Reserva_franja = true;

            $sql = "SELECT nombre FROM PISTA";

            if (!$resultado = $this->mysqli->query($sql)){ exit; //si da error la ejecución de la query 
                $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
                $this->respuesta["type"]=false;
                return $this->respuesta;
            }else {
                if($resultado <> NULL){
                    while ($row = mysqli_fetch_array($resultado)) {
                        $pista_nombre = $this->reserva->setNombre_pista($row[0]);
                        $this->Add_override();
                    }
                }
            }
        }
        return;

    }//  fin Reserva_franja

    function Add_override()
    {
        $id_horario = $this->reserva->getId_horario();
        $pista_nombre = $this->reserva->getNombre_pista();

        $fecha = $this->reserva->getFecha();
        if($fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $fecha);
            $format_fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }

        $sql = "SELECT * FROM RESERVA
                            WHERE       
                                    fecha = '$format_fecha'
                                AND HORARIO_id = '$id_horario'
                                AND PISTA_nombre = '$pista_nombre' ";

        if (!$resultado = $this->mysqli->query($sql)){ exit;
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }else { //si la ejecución de la query no da error
           // $num_rows = mysqli_num_rows($resultado);
            if($resultado->num_rows > 0){
                $this->Delete_duplicada();
            }
        return $this->Add();
        }

    } // fin Add_override

    function Delete_duplicada(){
        $id_horario = $this->reserva->getId_horario();
        $pista_nombre = $this->reserva->getNombre_pista();

        $fecha = $this->reserva->getFecha();
        if($fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $fecha);
            $format_fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }

        $sql = "DELETE FROM RESERVA 
                                WHERE
                                        fecha = '$fecha'
                                    AND HORARIO_id = '$id_horario'
                                    AND PISTA_nombre = '$pista_nombre' ";

   
        if(!$resultado = $this->mysqli->query($sql) ){
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }else{
            $this->respuesta["text"]='Borrado correctamente';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
    }//fin Delete_duplicada

    function AllData()
    {
        $sql = "SELECT * FROM RESERVA ";

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

    function ShowAll(){
        $sql = "SELECT * FROM RESERVA ORDER BY fecha DESC";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else{
            return $resultado;
        }
    }

    function CHECK_MAX(){
        $login = $this->reserva->getLogin_user();
        $fecha_actual = date('Y-m-d');

		$sql = "SELECT COUNT(*) AS TOTAL FROM RESERVA WHERE USUARIO_login = '$login' AND fecha > '$fecha_actual'"; 
		$resultado = $this->mysqli->query($sql);
        $fetch_resultado = mysqli_fetch_array($resultado);
        
		if($fetch_resultado[0]>="5"){
			return true;
		}
		else{
			return false;
        }
    }

    function Get_pistas_libres(){
        $id_horario = $this->reserva->getId_horario();
        $fecha = $this->reserva->getFecha();
        if($fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $fecha);
            $format_fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }

        //comprobamos si hay reservas
	    $sql = "SELECT * FROM  RESERVA 
                          WHERE  
                                fecha = '$format_fecha'
                            AND HORARIO_id = '$id_horario'";


        if ( !($resultado1 = $this->mysqli->query($sql)) ){
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            $pistasLibres = NULL;
        	$num_rows1 = mysqli_num_rows($resultado1);

            if($num_rows1 == 0){ //Si no hay reservas ese dia/hora
                
                $sql = "SELECT * FROM PISTA ORDER BY nombre";
                
		        if (!($resultado = $this->mysqli->query($sql)) ){
                    $this->respuesta["text"]='Fallo en la consulta sobre la base de datos';
                    $this->respuesta["type"]=false;
                    return $this->respuesta;
                }
                else{
                    while($row = mysqli_fetch_array($resultado)){
                        $pistasLibres[$row["nombre"]] = $row["tipo"];
                    }
		        	return $pistasLibres;
                }
            } //si hay alguna reserva para ese dia/hora
            else{
                $sql1 = "SELECT PISTA_nombre AS nombre FROM 
                                                            RESERVA 
                                                        WHERE  
                                                                fecha = '$format_fecha' 
                                                            AND HORARIO_id = '$id_horario'
                                                        ORDER BY id";

                $sql2   = "SELECT * FROM PISTA ORDER BY nombre";

                if ( !($resultado1 = $this->mysqli->query($sql1)) || !($resultado2 = $this->mysqli->query($sql2)) ){
                    $this->respuesta["text"]='Fallo en la consulta sobre la base de datos';
                    $this->respuesta["type"]=false;
                    return $this->respuesta;
                }else{

                    if($resultado1 <> NULL){
                        while($row = mysqli_fetch_array($resultado1)){
                            $list[$row["nombre"]] = "Ocupada";
                        }
                    }
                    if($resultado2 <> NULL){
                        while($row = mysqli_fetch_array($resultado2)){
                            if(!array_key_exists($row["nombre"], $list)){
                                $pistasLibres[$row["nombre"]] = $row["tipo"];
                            }
                        }
                    }
                    return $pistasLibres;
                }//fin del else

                return NULL;
            }//fin else
        } //fin else
    }// fin del metodo SEARCH_PISTAS_LIBRES

    function Num_reservas_dia_hora($fecha, $id_horario){
        $sql = "SELECT count(*) FROM RESERVA WHERE fecha = '$fecha' AND HORARIO_id = '$id_horario'";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"]='Fallo en la consulta sobre la base de datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else { //si la ejecución de la query no da error

            $row = mysqli_fetch_array($resultado);
			return $row[0];
        }
    }

    function Num_pistas(){
        $sql = "SELECT count(*) FROM PISTA ";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"]='Fallo en la consulta sobre la base de datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else { //si la ejecución de la query no da error

            $row = mysqli_fetch_array($resultado);
			return $row[0];
        }
    }
    
    function Num_reservas_disponibles($fecha, $id_horario){
        $num_reservas =  $this->Num_reservas_dia_hora($fecha, $id_horario);
        $num_pistas = $this->Num_pistas();

        return $num_pistas - $num_reservas;
    }

    function Get_partido_promocionado_fecha_hora($fecha, $id_horario){

        $sql = "SELECT * FROM PARTIDO WHERE fecha = '$fecha' AND HORARIO_id = '$id_horario' ";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"]='Fallo en la consulta sobre la base de datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else { //si la ejecución de la query no da error

            $num_rows = mysqli_num_rows($resultado);
            if($num_rows == 0){
                return false;
            }else{
                return true;
            }
        }
    }

    function Add(){
        $id_horario = $this->reserva->getId_horario();
        $login = $this->reserva->getLogin_user();
        $pista = $this->reserva->getNombre_pista();
        $fecha = $this->reserva->getFecha();
      
    
        if($fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $fecha);
            $format_fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }

        $sql = "SELECT * FROM 
                            RESERVA
                        WHERE       
                                fecha = '$format_fecha'
                            AND HORARIO_id = '$id_horario'
                            AND PISTA_nombre = '$pista'";
                        
                    
        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"]='Fallo en la consulta sobre la base de datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else { //si la ejecución de la query no da error
            $num_rows = mysqli_num_rows($resultado);
            if($num_rows == 0){

                $sql = "INSERT INTO RESERVA( id, fecha, USUARIO_login, HORARIO_id, PISTA_nombre)
                                VALUES( NULL, '$format_fecha', '$login', '$id_horario', '$pista')";
      

                    if (!($resultado = $this->mysqli->query($sql))){ 
                        $this->respuesta["text"]='Fallo en la consulta sobre la base de datos';
                        $this->respuesta["type"]=false;
                        return $this->respuesta;
                    }
                    else{

                        //si no quedan reservas disponibles para esa hora/fecha, se comprueba si había algún partido promocionado
                        if($this->Num_reservas_disponibles($format_fecha, $id_horario) == 0){

                           // exit($this->Get_partido_promocionado_fecha_hora($format_fecha, $id_horario));

                            if(!$this->Get_partido_promocionado_fecha_hora($format_fecha, $id_horario)){ //si no hay partidos promocionados
                                $this->respuesta["text"]='Reserva realizada correctamente';
                                $this->respuesta["type"]=true;
                                return $this->respuesta;
                            }
                            else{ //si hay partidos promocionados para esa fecha/hora

                                $sql = "SELECT id FROM PARTIDO WHERE HORARIO_id = '$id_horario' AND fecha = '$format_fecha'"; 
                                $resultado = $this->mysqli->query($sql);
                                $row = mysqli_fetch_array($resultado);
                                $partido = $row[0];

                                $this->respuesta["text"]='Reserva realizada correctamente';
                                $this->respuesta["type"]=true;
                                $this->respuesta["id_partido"]=$partido;
                                return $this->respuesta;
                            }
                        }
                        else{

                            $resultado = $this->mysqli->query("SELECT @@identity AS id"); //recoge el id de la ultima inserccion
                            if ($row = mysqli_fetch_array($resultado)) {
                                $this->respuesta['id_reserva'] = $row[0];
                            }

                            $this->respuesta["text"]='Reserva realizada correctamente';
                            $this->respuesta["type"]=true;
                            return $this->respuesta;
                        }
                        
                    }
                }else{
                    $this->respuesta["text"]='Ya existe una reserva en esa fecha y pista';
                    $this->respuesta["type"]=false;
                    return $this->respuesta;
                }
            }

    }

    function Get_reservas_pista(){
        $pista = $this->reserva->getNombre_pista();

        $sql = "SELECT R.id,
                        R.USUARIO_login AS 'Usuario',
                        R.fecha,
                        H.hora_inicio AS 'Hora inicio',
                        H.hora_fin AS 'Hora fin',
                        R.PISTA_nombre AS 'Pista'
                FROM 
                    RESERVA R, HORARIO H 
                WHERE 
                        R.PISTA_nombre = '$pista' 
                    AND R.HORARIO_id = H.id
                ORDER BY 
                    R.fecha, H.hora_fin DESC";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            return $resultado;
        }
    }

    function Get_reservas_pista_user($login){

        $pista = $this->reserva->getNombre_pista();
        $fecha_actual = date('Y-m-d');

        $sql = "SELECT R.id,
                        R.USUARIO_login AS 'Usuario',
                        R.fecha,
                        H.hora_inicio AS 'Hora inicio',
                        H.hora_fin AS 'Hora fin',
                        R.PISTA_nombre AS 'Pista'
                FROM 
                    RESERVA R, HORARIO H 
                WHERE 
                        R.PISTA_nombre = '$pista' 
                    AND R.HORARIO_id = H.id
                    AND R.USUARIO_login = '$login'
                ORDER BY 
                    R.fecha, H.hora_fin DESC";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
                return $resultado;
        }
    }

    function delete(){
        $id = $this->reserva->getId();
        
        $sql = "SELECT * FROM `RESERVA` WHERE (id = '$id')"; 
        $resultado = $this->mysqli->query($sql);
        
        $row = mysqli_fetch_array($resultado);
        $pista = $row[4];
        
        if ($resultado->num_rows == 1) {

            $sql2 = "DELETE FROM RESERVA WHERE (id = '$id')";
        
            if(!$resultado = $this->mysqli->query($sql2) ){
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }else{
                $row = mysqli_fetch_array($resultado);
                
                
                $this->respuesta["text"] = 'Eliminado correctamente';
                $this->respuesta["type"] = true;
                $this->respuesta["pista"] = $pista;
                return $this->respuesta;
            }
        } 
        else {
            $this->respuesta["text"] = 'El elemento no existe';
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
    }

    function Get_num_reserva_fecha_hora(){
        $fecha = $this->reserva->getFecha();
        $id_horario = $this->reserva->getId_horario();

        $sql = "SELECT COUNT(*) FROM RESERVA WHERE fecha = '$fecha' AND HORARIO_id = '$id_horario'";
        
        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            $row = mysqli_fetch_array($resultado);
            return $row[0];
        }
    }

    function Get_pista_sin_reserva(){
        $fecha = $this->reserva->getFecha();
        $id_horario = $this->reserva->getId_horario();

        $sql = "SELECT nombre 
                FROM PISTA 
                WHERE nombre NOT IN 
                            (SELECT PISTA_nombre 
                                FROM RESERVA 
                                WHERE 
                                        fecha = '$fecha' 
                                    AND HORARIO_id = '$id_horario')
                LIMIT 1;
                ";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            $row = mysqli_fetch_array($resultado);
            return $row[0];
        }

    }

    

}