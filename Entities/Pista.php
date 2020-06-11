<?php

class Pista {

    var $nombre;
    var $tipo;

    
    function __construct($nombre, $tipo){
        $this->nombre = $nombre;
        $this->tipo= $tipo;

    } 
    
    function getNombre(){
        return $this->nombre;
    }

    function setNombre($nombre){
        $this->nombre = $nombre;
    }

    function getTipo(){
        return $this->tipo;
    }

    function setTipo($tipo){
        $this->tipo = $tipo;
    }

    function check() {
        $error = false;

        if (strlen($this->nombre) < 2) {
            $error = true;
        }

        if (strlen($this->tipo) < 2) {
            $error = true;
        }

        return $error;
    }

}

?>