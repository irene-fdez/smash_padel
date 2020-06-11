<?php

class Enfrentamiento {

    var $id;
    var $resultado;
    var $pareja_1;
    var $pareja_2;
    var $id_grupo;
    var $id_reserva;

    
    function __construct($id, $resultado, $pareja_1, $pareja_2, $id_grupo, $id_reserva){
        $this->id = $id;
        $this->resultado = $resultado;
        $this->pareja_1 = $pareja_1;
        $this->pareja_2 = $pareja_2;
        $this->id_grupo = $id_grupo;
        $this->id_reserva = $id_reserva;
    } 
    
    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getResultado(){
        return $this->resultado;
    }

    function setResultado($resultado){
        $this->resultado = $resultado;
    }

    function getPareja_1()
    {
        return $this->pareja_1;
    }

    function setPareja_1($pareja_1)
    {
        $this->pareja_1 = $pareja_1;
    }

    function getPareja_2()
    {
        return $this->pareja_2;
    }

    function setPareja_2($pareja_2)
    {
        $this->pareja_2 = $pareja_2;
    }

    function getId_grupo()
    {
        return $this->id_grupo;
    }

    function setId_grupo($id_grupo)
    {
        $this->id_grupo = $id_grupo;
    }

    function getId_reserva()
    {
        return $this->id_reserva;
    }

    function setId_reserva($id_reserva)
    {
        $this->id_reserva = $id_reserva;
    }

    function check() {
        $error = false;

        if (strlen($this->resultado) < 2) {
            $error = true;
        }

        if (strlen($this->pareja_1) < 2) {
            $error = true;
        }
        
        if (strlen($this->pareja_2) < 2) {
            $error = true;
        }

        if (strlen($this->id_grupo) < 2) {
            $error = true;
        }
        
        if (strlen($this->id_reserva) < 2) {
            $error = true;
        }
        return $error;
    }

}

?>