<?php

class PAREJA_Model
{
    var $mysqli;


    function __construct($pareja)
    {

        $this->pareja = $pareja;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }

    function ADD(){
        $capitan = $this->pareja->getCapitan();
        $jugador2 = $this->pareja->getJugador_2();

        $sql = "SELECT * FROM PAREJA WHERE
                                            ( (capitan = '$capitan' AND jugador_2 = '$jugador2') OR (capitan = '$jugador2' AND jugador_2 = '$capitan') )
                                            ";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else{

            if ($resultado->num_rows == 0) {
                
                $sql2 = "INSERT INTO PAREJA(capitan, jugador_2)
                                VALUES('$capitan', '$jugador2')";

                if (!($resultado = $this->mysqli->query($sql2))) {
                    $this->respuesta["text"]='No se ha podido registrar la pareja';
                    $this->respuesta["type"]=false;
                    return $this->respuesta;
                }
                else{
                    $this->respuesta["text"]='Esta pareja registrada con exito';
                    $this->respuesta["type"]=true;
                    return $this->respuesta;
                }

            }
            else{
                $this->respuesta["text"]='Esta pareja ya está registrada en la BD';
                $this->respuesta["type"]=true;
                return $this->respuesta;
            }
        }
    }

    function GET_ID(){
        $capitan = $this->pareja->getCapitan();
        $jugador2 = $this->pareja->getJugador_2();

        $sql = "SELECT id FROM PAREJA WHERE
                                        ( (capitan = '$capitan' AND jugador_2 = '$jugador2') OR (capitan = '$jugador2' AND jugador_2 = '$capitan') )
                                        ";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
        else{

            if ($resultado->num_rows == 0) {
                $this->respuesta["text"]='La pareja no está registrada en la Base de Datos';
                $this->respuesta["type"]=false;
                return $this->respuesta;
            }
            else{
                $row=mysqli_fetch_array($resultado);
                return $row["id"];
            }
        }
                        
    }


}
