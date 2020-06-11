<?php

class Clasificacion {

    var $id;
    var $puntos;
    var $id_pareja;
    var $id_grupo;

    
    function __construct($id, $puntos, $id_pareja, $id_grupo){
        $this->id= $id;
        $this->puntos= $puntos;
        $this->id_pareja = $id_pareja;
        $this->id_grupo = $id_grupo;

    } 
    
    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }
    
    function getPuntos(){
        return $this->puntos;
    }

    function setPuntos($puntos){
        $this->puntos = $puntos;
    }

    function getId_pareja(){
        return $this->id_pareja;
    }

    function setId_pareja($id_pareja){
        $this->id_pareja = $id_pareja;
    }

    function getId_grupo(){
        return $this->id_grupo;
    }

    function setId_grupo($id_grupo){
        $this->id_grupo = $id_grupo;
    }

    function check() {
        $error = false;

        if (strlen($this->id) < 2) {
            $error = true;
        }

        if (strlen($this->puntos) < 2) {
            $error = true;
        }

        if (strlen($this->id_pareja) < 2) {
            $error = true;
        }
        
        if (strlen($this->id_grupo) < 2) {
            $error = true;
        }

        return $error;
    }

}

?>