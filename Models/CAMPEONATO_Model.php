<?php

class CAMPEONATO_Model
{
    var $mysqli;


    function __construct($campeonato)
    {

        $this->campeonato = $campeonato;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function AllData()
    {
        $sql = "SELECT * FROM CAMPEONATO "; 

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

    function Add($categorias){
        $nombre = $this->campeonato->getNombre();
        $fecha = $this->campeonato->getFecha();
        if($fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $fecha);
            $format_fecha = date('Y-m-d',mktime(0,0,0,$aux[0],$aux[1],$aux[2]));
        }

        $login = $this->campeonato->getLoginAdmin();

        if (($nombre <> '') || ($fecha <> '') ){ // si los atributos estan vacios
            
            $sql = "SELECT * FROM CAMPEONATO WHERE nombre = '$nombre' AND fecha = '$format_fecha'";

            if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{ //si la ejecución de la query no da error

                $num_rows = mysqli_num_rows($resultado);
                if($num_rows == 0){
                    
                    $sql = "INSERT INTO CAMPEONATO( nombre, fecha, USUARIO_admin_login )
                                            VALUE('$nombre', '$format_fecha', '$login')";

                    if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                        $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                        $this->respuesta["type"] = false;
                        return $this->respuesta; 
                    }
                    else{
                        
                        //obtenemos el id del campeonato que acabamos de insertar
                        $resultado = $this->mysqli->query("SELECT @@identity AS id"); //recoge el id de la ultima inserccion
                        $row = mysqli_fetch_array($resultado);
                        $this->campeonato->setId($row[0]);
                        $id_campeonato = $this->campeonato->getId();
                        
                        if(!$categorias == NULL){
                            foreach($categorias as $key => $id_categoria){
                                $sql2 = "INSERT INTO CATEGORIA_CAMPEONATO( CAMPEONATO_id, CATEGORIA_id )
                                                                    VALUE( '$id_campeonato', '$id_categoria' )";
                                
                                if (!($resultado = $this->mysqli->query($sql2))){ 
                                    $this->respuesta["text"] = "No se ha podido registrar la categoría-campeonato"; exit;
                                    $this->respuesta["type"] = false;
                                    return $this->respuesta; 
            
                                }else{
                                    $consulta = "ok";
                                }
                            }
                        }

                        if ($consulta == "ok"){ 
                            $this->respuesta["text"] = 'Campeonato insertado correctamente';
                            $this->respuesta["type"] = true;
                            return $this->respuesta;
                        }else{
                            //si se ha producido algun error en alguno de los pasos se elimina el campeonato
                            $sql3 = "DELETE FROM CAMPEONATO  WHERE CAMPEONATO_id = '$id_campeonato'";
                            $resultado = $this->mysqli->query($sql3);

                            $this->respuesta["text"] = "No se ha podido insertar el campeonato";
                            $this->respuesta["type"] = false;
                            return $this->respuesta; 
                        }
                    }

                }
                else{
                    $this->respuesta["text"] = "Ya existe un campeonato con ese nombre en esa fecha";
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

    function Get_campeonatos_abiertos(){
        $hoy = date("Y-m-d");
        $sql = "SELECT id, nombre, fecha FROM CAMPEONATO WHERE fecha >= '$hoy' ";

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

    function Get_campeonatos_abiertos_usuario($login){
        $hoy = date("Y-m-d");
        $sql = "SELECT genero FROM USUARIO WHERE login = '$login' ";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            $row = mysqli_fetch_array($resultado);
            $genero = $row[0];

            $sql_camp = "SELECT CAMP.id, CAMP.nombre, CAMP.fecha 
                            FROM 
                                CAMPEONATO CAMP,
                                CATEGORIA_CAMPEONATO CC,
                                CATEGORIA CAT
                            WHERE 
                                    fecha >= '$hoy' 
                                AND CAMP.id = CC.CAMPEONATO_id
                                AND CAT.id = CC.CATEGORIA_id
                                AND ( CAT.genero = '$genero'  ||  CAT.genero = 'Mixto' )
                            GROUP BY 1;
                        ";
                        
            if (!($resultado_camp = $this->mysqli->query($sql_camp))) {
                $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
                $this->respuesta["type"]=false;
                return $this->respuesta;
            } else {
                if ($resultado_camp->num_rows == 0) {
                    return 0;
                }else{
                    return $resultado_camp;
                }
            }
        }
    }

    function delete(){

        $id = $this->campeonato->getId();

        $sql = "SELECT * FROM CAMPEONATO WHERE (id = '$id')";
        $resultado = $this->mysqli->query($sql);
        
        if ($resultado->num_rows == 1) {

            $sql1 = "DELETE FROM INSCRIPCION 
                            WHERE CATEGORIA_CAMPEONATO_id IN (SELECT id
                                                                FROM
                                                                    CATEGORIA_CAMPEONATO 
                                                                WHERE
                                                                    CAMPEONATO_id = '$id')";
           
           if(!$resultado = $this->mysqli->query($sql1) ){ 
                $this->respuesta["text"] = "No se ha podido eliminar el campeonato";
                $this->respuesta["type"] = false;
                return $this->respuesta;
            }
            else{
                $sql2 = "DELETE FROM CATEGORIA_CAMPEONATO
                                WHERE CAMPEONATO_id = '$id'";

                if(!$resultado = $this->mysqli->query($sql2) ){ 
                    $this->respuesta["text"] = "No se ha podido eliminar el campeonato";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{
                    $sql3 = "DELETE FROM CAMPEONATO
                                    WHERE id = '$id'";

                    if(!$resultado = $this->mysqli->query($sql3) ){ 
                        $this->respuesta["text"] = "No se ha podido eliminar el campeonato";
                        $this->respuesta["type"] = false;
                        return $this->respuesta;
                    }
                    else{
                        $this->respuesta["text"] = "Campeonato eliminado correctamente";
                        $this->respuesta["type"] = true;
                        return $this->respuesta;
                    }
                }
            }
        } 
        else {
            $this->respuesta["text"] = 'El elemento no existe';
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
    } //fin delete

    function Get_deportistas_campeonato(){
        
        $id = $this->campeonato->getId();

        $sql =  "SELECT U.* FROM 
                                USUARIO U, ROL R  
                            WHERE 
                                    U.ROL_id = R.id 
                                AND R.nombre = 'Deportista'
                                AND (   'Mixto' IN ( SELECT CAT.genero FROM CAMPEONATO CAMP, CATEGORIA CAT, CATEGORIA_CAMPEONATO CC
                                                        WHERE 
                                                                CAMP.id = CC.CAMPEONATO_id
                                                            AND CAT.id = CC.CATEGORIA_id
                                                            AND CAMP.id = '$id'
                                                        GROUP BY 
                                                            CAT.genero)
                                        OR
                                        U.genero IN ( SELECT CAT.genero FROM CAMPEONATO CAMP, CATEGORIA CAT, CATEGORIA_CAMPEONATO CC
                                                        WHERE 
                                                                CAMP.id = CC.CAMPEONATO_id
                                                            AND CAT.id = CC.CATEGORIA_id
                                                            AND CAMP.id = '$id'
                                                        GROUP BY 
                                                            CAT.genero)
                                    )
                ";
       
        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }
    }//fin Get_deportistas_campeonato

    function Get_deportistas_campeonato_reverse(){
        
        $id = $this->campeonato->getId();

        $sql =  "SELECT U.* FROM 
                                USUARIO U, ROL R  
                            WHERE 
                                    U.ROL_id = R.id 
                                AND R.nombre = 'Deportista'
                                AND (   'Mixto' IN ( SELECT CAT.genero FROM CAMPEONATO CAMP, CATEGORIA CAT, CATEGORIA_CAMPEONATO CC
                                                        WHERE 
                                                                CAMP.id = CC.CAMPEONATO_id
                                                            AND CAT.id = CC.CATEGORIA_id
                                                            AND CAMP.id = '$id'
                                                        GROUP BY 
                                                            CAT.genero)
                                        OR
                                        U.genero IN ( SELECT CAT.genero FROM CAMPEONATO CAMP, CATEGORIA CAT, CATEGORIA_CAMPEONATO CC
                                                        WHERE 
                                                                CAMP.id = CC.CAMPEONATO_id
                                                            AND CAT.id = CC.CATEGORIA_id
                                                            AND CAMP.id = '$id'
                                                        GROUP BY 
                                                            CAT.genero)
                                    )
                            ORDER BY U.login ASC
                ";
       
        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }
    }//fin Get_deportistas_campeonato_reverse

 
    function Get_camp_con_enfrentamiento(){
        $fecha = date('Y-m-d');
        $sql = "SELECT id, nombre, fecha FROM CAMPEONATO WHERE 
                                                fecha < '$fecha'
                                            AND id IN (SELECT DISTINCT CAMPEONATO_id FROM GRUPO)";
   
        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }       
    }//fin Get_camp_con_enfrentamiento

    function Get_camp_sin_enfrentamiento(){
        $fecha = date('Y-m-d');
        $sql = "SELECT id, nombre, fecha FROM CAMPEONATO WHERE 
                                                fecha < '$fecha'
                                            AND id NOT IN (SELECT DISTINCT CAMPEONATO_id FROM GRUPO)";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }      
    }//fin Get_camp_sin_enfrentamiento


    function Comprobar_camp_pasados(){
        $fecha = date('Y-m-d');

        //numero de partidos con fecha anterior a hoy
        $sql_p = "SELECT 
                        C.id 
                    FROM 
                        CAMPEONATO C, CATEGORIA_CAMPEONATO CC 
                    WHERE 
                            CC.CAMPEONATO_id = C.id
                        AND C.id NOT IN (SELECT DISTINCT CAMPEONATO_id FROM GRUPO)
                        AND C.fecha < '$fecha'
                    GROUP BY C.id";

        if (!$resultado = $this->mysqli->query($sql_p)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ //si la ejecución de la query no da error
            $num_partidos = $resultado->num_rows;

            $cont = 0;
            while($cont < $num_partidos){
                
                $sql = "SELECT 
                            C.id AS campeonato_id
                        FROM 
                            CAMPEONATO C, CATEGORIA_CAMPEONATO CC 
                        WHERE 
                                CC.CAMPEONATO_id = C.id 
                            AND C.id NOT IN (SELECT DISTINCT CAMPEONATO_id FROM GRUPO)
                            AND C.fecha < '$fecha'
                        GROUP BY C.id
                        LIMIT 1
                        ";

                if (!$resultado1 = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                    $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{
                    $row = mysqli_fetch_array($resultado1);
                    $id_camp = $row[0];

                    $sql = "SELECT 
                                COUNT(I.PAREJA_id) AS num_parejas
                            FROM 
                                INSCRIPCION I, CAMPEONATO C, CATEGORIA_CAMPEONATO CC 
                            WHERE 
                                    CC.CAMPEONATO_id = C.id 
                                AND I.CATEGORIA_CAMPEONATO_id = CC.id 
                                AND C.id = '$id_camp' 
                            ";

                    
                    if (!$resultado2 = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                        $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
                        $this->respuesta["type"] = false;
                        return $this->respuesta;
                    }
                    else{
                        $this->campeonato->setId($id_camp);
                        $row = mysqli_fetch_array($resultado2);
                        $num_parejas = $row[0];

                        if($num_parejas < 8){
                            //se elimina el campeonato
                            $this->delete();

                            $this->respuesta["text"] = "Se ha eliminado el campeonato por no haber inscripciones suficientes para formar los grupos";
                            $this->respuesta["type"] = false;
                            return $this->respuesta;
                        }
                        else{
                            //se crean los grupos
                            $this->Generar_grupos();

                        }
                    }
                }
                $cont++;
            }//fin del while
        }
    } //fin Comprobar_camp_pasados



    //Generacion de grupos para cada categoría de un campeonato en función de las parejas inscritas
    function Generar_grupos(){
        include '../Entities/Grupo.php';
        include '../Entities/Inscripcion.php';
        include '../Entities/Clasificacion.php';
        include '../Models/GRUPO_Model.php';
        include '../Models/INSCRIPCION_Model.php';
        include '../Models/CLASIFICACION_Model.php';

        $id_campeonato = $this->campeonato->getId();
           
        //Obtenemos las categorias del campeonato
        $sql_cat_camp = "SELECT * FROM CATEGORIA_CAMPEONATO WHERE CAMPEONATO_id = '$id_campeonato'";       

        if (!$result_cat_camp = $this->mysqli->query($sql_cat_camp)){ //si da error la ejecución de la query
            $this->respuesta["text"] = "Debe existir al menos un campeonato con una categoría";
            $this->respuesta["type"] = false;
            return $this->respuesta; 
        }
        else{
           
            while($row = mysqli_fetch_array($result_cat_camp)){
                //Para cada categoría se obtienen los inscritos
                $cat_id = $row['CATEGORIA_id'];

                $sql_insc = "SELECT * FROM INSCRIPCION I, CATEGORIA_CAMPEONATO CC
                            WHERE   
                                    I.CATEGORIA_CAMPEONATO_id = CC.id
                                AND CC.CATEGORIA_id = '$cat_id'
                                AND CC.CAMPEONATO_id = '$id_campeonato'
                            ORDER BY I.fecha        
                            "; 

                $result_insc = $this->mysqli->query($sql_insc);
                $num_inscritos = $result_insc->num_rows;

                if($num_inscritos >= 8){ //por categoría

                        /*** CREACIÓN DE GRUPOS ***/

                        //Se calcula el número de grupos a crear
                        $num_grupos = floor($num_inscritos/8);

                        for ($grupo = 1; $grupo <= $num_grupos ; $grupo++) { 
                                                                                   
                            $grupo_entidad = new Grupo('', $grupo, $id_campeonato, $cat_id);
                            $model_grupo = new GRUPO_Model($grupo_entidad); 
                            $respuesta = $model_grupo->ADD();  
                                    
                            //Se asigna el grupo a 8 parejas inscritas
                            for ($i = 0; $i < 8; $i++) { 
                                
                                //Se registra una pareja como miembro de un grupo  
                                if($inscripcion = mysqli_fetch_array($result_insc)){
                                    
                                    $inscripcion_entidad = new Inscripcion('','',$inscripcion['PAREJA_id'],$inscripcion['CATEGORIA_CAMPEONATO_id'],'');
                                    $model_inscripcion = new INSCRIPCION_Model($inscripcion_entidad);
                                   
                                    $sql_grupo = "SELECT * FROM 
                                                                GRUPO
                                                            WHERE 
                                                                    CATEGORIA_id = '$cat_id'
                                                                AND CAMPEONATO_id = '$id_campeonato'
                                                                AND nombre = '$grupo'
                                                            ";
                                    
                                    $result_grupo = $this->mysqli->query($sql_grupo);
                                    if(!$result_grupo){
                                        $this->respuesta["text"] = "No se ha podiado realizar la consulta sobre grupos";
                                        $this->respuesta["type"] = false;
                                        return $this->respuesta;
                                    }
                                    $row_grupo = mysqli_fetch_array($result_grupo);
                                    $id_grupo = $row_grupo['id'];            
                                    $model_inscripcion->SET_GRUPO($id_grupo); //se asigna el id del grupo a la inscripcion

                                    //Para cada inscrito se inicializa su clasificación 
                                    $clasificacion =  new Clasificacion('',0, $inscripcion['PAREJA_id'], $id_grupo);
                                    $model_clasif = new CLASIFICACION_Model($clasificacion); 
                                    $result_add_clasif = $model_clasif->Add();  
                                    
                                    $num_inscritos--; 
                                }                             
                            }                                                            
                        } //  FIN CREACIÓN DE GRUPOS

                        //Si las parejas que quedan por asignarles un grupo son menos de 8, se reparten entre los restantes grupos (sin tener más de 12 en cada grupo)
                        $grupo_actual = $num_grupos;

                        //Si se ha creado más de un grupo
                        if($grupo_actual > 1){

                            /*** ASIGNACIÓN DE INSCRITOS RESTANTES ***/
                            while($num_inscritos > 0 && $inscripcion = mysqli_fetch_array($result_insc)){

                                $model_inscripcion = new INSCRIPCION_Model( new Inscripcion('','',$inscripcion['PAREJA_id'], $inscripcion['CATEGORIA_CAMPEONATO_id'],'') );

                                $sql_grupo = "SELECT * FROM 
                                                            GRUPO 
                                                        WHERE 
                                                                CATEGORIA_id = '$cat_id'
                                                            AND CAMPEONATO_id = '$id_campeonato' 
                                                            AND nombre = '$grupo_actual'
                                                    ";

                                $result_grupo = $this->mysqli->query($sql_grupo);
                                if(!$result_grupo){
                                    $this->respuesta["text"] = "No se ha podiado realizar la consulta sobre grupos";
                                    $this->respuesta["type"] = false;
                                    return $this->respuesta;
                                }
                                $row_grupo = mysqli_fetch_array($result_grupo);
                                $id_grupo = $row_grupo['id'];                               
                                $model_inscripcion->SET_GRUPO($id_grupo);  //se asigna el id del grupo a la inscripcion

                                //Para cada inscrito se inicializa su clasificación
                                $model_clasif = new CLASIFICACION_Model( new Clasificacion('',0, $inscripcion['PAREJA_id'], $id_grupo) ); 
                                $model_clasif->Add();  
                                                
                                $num_inscritos--;   
                                $grupo_actual--; 

                                if($grupo_actual == 0){
                                    $grupo_actual = $num_grupos;
                                } 
                            } // FIN ASIGNACIÓN DE INSCRITOS RESTANTES EN GRUPOS EXISTENTES

                        }//Si sólo hay un grupo 
                        else{
                            //Metemos parejas hasta llegar al máximo (12)
                            $i = 0;

                            //Metemos en el grupo 1 siempre, sólo a 4 más
                            for ($i = 0; $i < 4; $i++) { 

                                if($inscripcion = mysqli_fetch_array($result_insc)){

                                    $model_inscripcion = new INSCRIPCION_Model( new Inscripcion('','',$inscripcion['PAREJA_id'],$inscripcion['CATEGORIA_CAMPEONATO_id'],'') );

                                    //Asignamos el id del grupo correspondiente
                                    $sql_grupo = "SELECT * FROM 
                                                            GRUPO 
                                                        WHERE 
                                                                CATEGORIA_id = '$cat_id'
                                                            AND CAMPEONATO_id = '$id_campeonato' 
                                                            AND nombre = '$grupo_actual'
                                                    ";

                                    $result_grupo = $this->mysqli->query($sql_grupo);
                                    if(!$result_grupo){
                                        $this->respuesta["text"] = "No se ha podiado realizar la consulta sobre grupos";
                                        $this->respuesta["type"] = false;
                                        return $this->respuesta;
                                    }
                                    $row_grupo = mysqli_fetch_array($result_grupo);
                                    $id_grupo = $row_grupo['id'];                               
                                    $model_inscripcion->SET_GRUPO($id_grupo);  //se asigna el id del grupo a la inscripcion

                                    //Para cada inscrito inicializamos su clasificación
                                    $model_clasif = new CLASIFICACION_Model( new Clasificacion('',0, $inscripcion['PAREJA_id'], $id_grupo) );
                                    $model_clasif->Add();  
                                                    
                                    $num_inscritos--;   
                                }
                            }

                            for ($i = $num_inscritos; $i > 0 ; $i--){ 
                                if($inscripcion = mysqli_fetch_array($result_insc)){

                                    $model_inscripcion = new INSCRIPCION_Model( new Inscripcion('','',$inscripcion['PAREJA_id'],$inscripcion['CATEGORIA_CAMPEONATO_id'],'') );
                                    $model_inscripcion->delete(); 
                                    $num_inscritos--;    
                                }
                            }
                        }
                } //fin if(inscritos >= 8)
            }//fIN WHILE
            return $this->Generar_enfrentamientos();    
        }
    }//fin Generar_grupos


    //Función para generar los enfrentamientos
    function Generar_enfrentamientos(){
        include '../Entities/Enfrentamiento.php';
        include '../Models/ENFRENTAMIENTO_Model.php';

        $sql_grupos = "SELECT * FROM GRUPO";
        $result_grupos = $this->mysqli->query($sql_grupos);
       
        while ($row_grupo = mysqli_fetch_array($result_grupos)) {
            $num_grupo = $row_grupo['id'];

            $sql = "SELECT PAREJA_id FROM INSCRIPCION WHERE (GRUPO_id = '$num_grupo')";
            $resultado = $this->mysqli->query($sql);
            $i = 0;

            while($row_pareja = mysqli_fetch_array($resultado)){
                $parejas[$i] = $row_pareja[0];
                $i++;
            }
            $num_parejas = $resultado->num_rows;

            //Se realizan los cruces de las parejas (todos juegan contra todos)
            for ($i = 0; $i < $num_parejas; $i++) { 

                $pareja1_id = $parejas[$i];

                for ($j = 0; $j < $num_parejas; $j++) { 

                    $pareja2_id = $parejas[$j];
                    
                    $sql_enfr = "SELECT * FROM 
                                            ENFRENTAMIENTO 
                                        WHERE 
                                                (( PAREJA_1 = '$pareja1_id' AND PAREJA_2 = '$pareja2_id' ) OR ( PAREJA_2 = '$pareja1_id' AND PAREJA_1 = '$pareja2_id' ))
                                            AND GRUPO_id = '$num_grupo'
                    ";
                    $result_enfr = $this->mysqli->query($sql_enfr);
                    
                    //si el enfrentamiento no existe se añade
                    if($result_enfr->num_rows == 0 && ($pareja1_id <> $pareja2_id)){ 

                        $model_enfr = new ENFRENTAMIENTO_Model( new Enfrentamiento('', '', $pareja1_id, $pareja2_id, $num_grupo, '') );
                        $resul_add_enfr=$model_enfr->ADD(); 
                    }
                }
            }
        }
        return $resul_add_enfr;
    }//fin Generar_enfrentamientos

    //Funcion para obtener el nombre de un campeonato
    function Get_nombre(){
        $id = $this->campeonato->getId();
        
        $sql = "SELECT nombre FROM CAMPEONATO WHERE id = '$id'";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            $row = mysqli_fetch_array($resultado);
            return $row[0];
        }
    }//fin Get_nombre

    //Funcion para obtener las categorias y grupos de un campeonato
    function Get_cat_grupo(){
        $id = $this->campeonato->getId();

        $sql = "SELECT 
                    C.id AS categoria_id,
                    C.nivel,
                    C.genero,
                    G.id AS grupo_id,
                    G.nombre AS nombre_grupo,
                    G.CAMPEONATO_id,
                    G.CATEGORIA_id
                FROM 
                    CATEGORIA C, GRUPO G
                WHERE
                        G.CAMPEONATO_id = '$id'
                    AND G.CATEGORIA_id = C.id
                ";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    }//fin Get_cat_grupo

    function Get_campeonatos_usuario($login){
        $sql_pareja = "SELECT * FROM 
                                PAREJA 
                            WHERE 
                                    capitan='$login' 
                                OR JUGADOR_2='$login'";

        if (!($result_par = $this->mysqli->query($sql_pareja))){
            $this->respuesta["text"] = "Fallo en la consulta sobre la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            $listCampeonatos = NULL;
            $i = 0;
            while($row = mysqli_fetch_array($result_par)){
                $pareja_id = $row['id'];
                $sql = "SELECT  	
                            CAMP.nombre AS nombre_campeonato,
                            CAT.nivel,
                            CAT.genero,
                            P.capitan,
                            P.jugador_2,
                            I.GRUPO_id
                        FROM
                            PAREJA P,
                            INSCRIPCION I,
                            CATEGORIA_CAMPEONATO CC,
                            CAMPEONATO CAMP,
                            CATEGORIA CAT
                        WHERE
                                I.PAREJA_id = P.id
                            AND CC.id = I.CATEGORIA_CAMPEONATO_id
                            AND CC.CAMPEONATO_id = CAMP.id
                            AND CC.CATEGORIA_id = CAT.id
                            AND I.PAREJA_id = '$pareja_id'";

                    // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
                if (!($resultado = $this->mysqli->query($sql))){
                    $this->respuesta["text"] = "Fallo en la consulta sobre la base de datos";
                    $this->respuesta["type"] = false;
                    return $this->respuesta;
                }
                else{ 
                    if($resultado <> NULL) {
                        
                        while($row = mysqli_fetch_array($resultado)){   

                            $capitan = $row['capitan'];
                            $jugador_2 = $row['jugador_2'];

                            $categoria_nombre = $row['nivel']." - ".$row['genero'];

                            $grupo_id = $row['GRUPO_id'];

                            $grupo_nombre = NULL;

                            if($grupo_id <> NULL){
                                //Buscamos el nombre del grupo
                                $sql_grupo = "SELECT nombre AS NOMBRE_GRUPO FROM GRUPO WHERE (ID = '$grupo_id')";
                                $res_grupo = $this->mysqli->query($sql_grupo);

                                if($row_grupo = mysqli_fetch_array($res_grupo)){
                                    $grupo_nombre = $row_grupo['NOMBRE_GRUPO'];
                                }
                                
                            }
                            else{
                                $grupo_nombre = "Sin asignar";
                            }

                            if($login == $capitan){
                                $listCampeonatos[$i] = array($row['nombre_campeonato'],$categoria_nombre,$jugador_2,$grupo_nombre);
                                
                            }else{
                                $listCampeonatos[$i] = array($row['nombre_campeonato'],$categoria_nombre,$capitan,$grupo_nombre);
                            }                             
                            $i++;
                            
                        } 
                    }

                }  
            }
            /*print_r('<pre>') ;
            print_r($listCampeonatos);
            print_r('<pre>') ;
            exit;*/

		return $listCampeonatos;
        }
    }//fin Get_campeonatos_usuario


    function Get_campeonatos_enfrentamientos(){
        $hoy = date('Y-m-d');
        $sql = "SELECT * FROM
                            CAMPEONATO
                        WHERE 
                                fecha < '$hoy'
                            AND id IN (SELECT DISTINCT CAMPEONATO_id FROM GRUPO)
                ";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "Fallo en la consulta sobre la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            return $resultado;
        }
    }//fin Get_campeonatos_enfrentamientos

    //Funcion para obtener los datos de un campeonato concreto
    function Get_datos_campeonato(){
        $id = $this->campeonato->getId();
        
        $sql = "SELECT * FROM CAMPEONATO WHERE id = '$id'";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    }//fin Get_datos_campeonato


    function Comprobar_etapa($grupo_id){
        $sql_cmp = "SELECT * FROM  ENFRENTAMIENTO WHERE  GRUPO_id = '$grupo_id' ";

        if (!($resultado = $this->mysqli->query($sql_cmp))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 
            //Se recorren los campeonatos para comprobar que todos tienen un resultado asociado
            while ($row =  mysqli_fetch_array($resultado) ) {
                if($row['resultado'] == NULL){ //si alguno es null, se sale del bucle
                    return false;
                }
            }
            return true;
        }
    }//fin Comprobar_etapa


   /* function Ganadores_grupo($grupo_id){
        //Se buscan las clasificaciones del grupo y se orden por puntos

        $sql_cmp = "SELECT * FROM CLASIFICACION WHERE GRUPO_id = '$grupo_id' ORDER BY puntos DESC"; 

        if (!($resultado = $this->mysqli->query($sql_cmp))){
            $this->respuesta["text"] = "No se ha podido conectar con la base de datos";
            $this->respuesta["type"] = false;
            return $this->respuesta;
        }
        else{ 


        $result = $this->mysqli->query($sql_cmp);
        //Seleccionamos los 8 primeros y los añadimos como finalistas
        $num_finalistas = 0;
        while ( $num_finalistas < 8 ) {
            if($row_g =  mysqli_fetch_array($result)){
                $pareja_id = $row_g['PAREJA_ID'];
            //Creamos la instancia del jugador como finalista
            $FINALISTA_CAMPEONATO = new FINALISTA_CAMPEONATO_Model($grupo_id,$pareja_id,"C",$num_finalistas);
            $FINALISTA_CAMPEONATO->ADD();
            $num_finalistas++;
            }
            
        }         
    }//fin Ganadores_grupo*/

    function Campeonatos_clasificacion()
    {
        $sql = "SELECT C.* FROM 
                            CAMPEONATO C,
                            GRUPO G,
                            CLASIFICACION CL
                        WHERE
                                G.CAMPEONATO_id = C.id
                            AND G.id = CL.GRUPO_id
                        GROUP BY C.id
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


} //FIN CAMPEONATO_Model
