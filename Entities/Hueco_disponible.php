<?php

class Hueco_disponible {

    var $id;
    var $fecha;
    var $id_horario;
    var $id_pareja;
    var $id_enfrentamiento;

    
    function __construct($id, $fecha, $id_horario, $id_pareja, $id_enfrentamiento){
        $this->id= $id;
        $this->fecha= $fecha;
        $this->id_horario= $id_horario;
        $this->id_pareja = $id_pareja;
        $this->id_enfrentamiento = $id_enfrentamiento;

    } 

    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }

    function getFecha(){
        return $this->fecha;
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }
    
    function getId_horario(){
        return $this->id_horario;
    }

    function setId_horario($id_horario){
        $this->id_horario = $id_horario;
    }

    function getId_pareja(){
        return $this->id_pareja;
    }

    function setId_pareja($id_pareja){
        $this->id_pareja = $id_pareja;
    }

    function getId_enfrentamiento(){
        return $this->id_enfrentamiento;
    }

    function setId_enfrentamiento($id_enfrentamiento){
        $this->id_enfrentamiento = $id_enfrentamiento;
    }

    function check() {
        $error = false;

        if (strlen($this->fecha) < 2) {
            $error = true;
        }

        if (strlen($this->id_horario) < 2) {
            $error = true;
        }

        if (strlen($this->id_pareja) < 2) {
            $error = true;
        }
        
        if (strlen($this->id_enfrentamiento) < 2) {
            $error = true;
        }

        return $error;
    }

}

?>